<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use App\Events\ImportExportCompleted;
use App\Events\DataStorageMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected string $filePath;
    protected ?int $userId;
    protected int $chunkSize;

    public function __construct(string $modelClass, string $filePath, int $chunkSize = 1000, ?int $userId = null)
    {
        $this->modelClass = $modelClass;
        $this->filePath = $filePath;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $model = new $this->modelClass;

        if (!method_exists($model, 'getFillable')) {
            Log::error("Model {$this->modelClass} must have fillable attributes.");
            return;
        }

        $fillable = $model->getFillable();

        // Ensure we only attempt to insert columns that actually exist in the DB table
        $dbColumns = [];
        $dateLikeColumns = [];
        try {
            $dbColumns = Schema::getColumnListing($model->getTable());
            $fillable = array_values(array_intersect($fillable, $dbColumns));

            // ensure primary key is not part of fillable to avoid attempting to insert it
            try {
                $pkName = $model->getKeyName();
                if (!empty($pkName)) {
                    $pkLower = strtolower($pkName);
                    $fillable = array_values(array_filter($fillable, function ($c) use ($pkLower) {
                        return strtolower($c) !== $pkLower;
                    }));
                }
            } catch (\Throwable $_) {
                // ignore
            }

            // fetch column types so we can coerce dates
            $cols = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `" . $model->getTable() . "`");
            foreach ($cols as $c) {
                $field = $c->Field ?? $c['Field'] ?? null;
                $type = $c->Type ?? $c['Type'] ?? '';
                if ($field) {
                    $lower = strtolower($type);
                    if (str_contains($lower, 'date') || str_contains($lower, 'timestamp') || str_contains($lower, 'time')) {
                        $dateLikeColumns[$field] = true;
                    }
                }
            }
        } catch (\Throwable $e) {
            // if schema inspection fails, log and continue with original fillable
            Log::warning('Failed to inspect DB columns for ' . $this->modelClass . ': ' . $e->getMessage());
        }

        // اقرأ الملف كـ stream (بدون تحميل كل البيانات مرة واحدة)
        // notify start of storage
        try {
            Event::dispatch(new DataStorageMessage('سيتم تخزين البيانات'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage start message: ' . $e->getMessage());
        }

        $rows = SimpleExcelReader::create($this->filePath)->getRows();

        $buffer = [];
        $counter = 0;
        $headerMap = null; // map normalized header -> actual header key
        $totalRows = 0; // track total rows read

        foreach ($rows as $rowIndex => $row) {
            $totalRows++;

            // Row keys may be the header names (associative). Normalize on first row.
            if ($headerMap === null) {
                $headerMap = [];
                foreach (array_keys((array) $row) as $originalKey) {
                    $norm = Str::of($originalKey)->trim()->lower();
                    // convert spaces and dots to underscores
                    $norm = preg_replace('/[\s\.]+/', '_', (string) $norm);
                    $headerMap[$norm] = $originalKey;
                }

                // Log detected headers
                Log::debug('ImportDataJob detected headers: ' . json_encode($headerMap));

                // create reverse lookup from fillable -> header key if possible
                $fillableLookup = [];
                foreach ($fillable as $col) {
                    $colNorm = strtolower($col);
                    // try exact match
                    if (isset($headerMap[$colNorm])) {
                        $fillableLookup[$col] = $headerMap[$colNorm];
                        continue;
                    }
                    // try snake_case of header names
                    foreach ($headerMap as $hNorm => $orig) {
                        if ($hNorm === $colNorm || $hNorm === Str::snake($col)) {
                            $fillableLookup[$col] = $orig;
                            break;
                        }
                    }
                    // fallback: leave unmapped for now
                }

                // Log the fillable lookup mapping
                Log::debug('ImportDataJob fillable lookup: ' . json_encode($fillableLookup));
            }

            // تنظيف القيم: trim/null
            $cleaned = [];
            foreach ((array) $row as $k => $v) {
                if (is_string($v)) {
                    $v = trim($v);
                    if ($v === '' || strtolower($v) === 'null')
                        $v = null;
                }
                $cleaned[$k] = $v;
            }

            // Build a row aligned with $fillable using lookup when possible
            $prepared = [];
            foreach ($fillable as $col) {
                if (!empty($fillableLookup[$col])) {
                    $headerKey = $fillableLookup[$col];
                    $prepared[$col] = $cleaned[$headerKey] ?? null;
                } else {
                    // attempt to find header by normalized name
                    $found = null;
                    $colNorm = strtolower($col);
                    foreach ($headerMap as $hNorm => $origKey) {
                        if ($hNorm === $colNorm || $hNorm === Str::snake($col)) {
                            $found = $origKey;
                            break;
                        }
                    }
                    $prepared[$col] = $found ? ($cleaned[$found] ?? null) : null;
                }
            }

            // Set default values for common boolean columns if they are null
            if (isset($prepared['is_active']) && $prepared['is_active'] === null) {
                $prepared['is_active'] = true;
            }
            if (isset($prepared['is_included']) && $prepared['is_included'] === null) {
                $prepared['is_included'] = false;
            }

            // Handle max_occupancy conversion for Room model (e.g., "2A+1C" -> occupancy_details + numeric max_occupancy)
            if (isset($prepared['max_occupancy']) && is_string($prepared['max_occupancy'])) {
                $occupancyStr = trim($prepared['max_occupancy']);

                // Check if it contains letters (A for Adults, C for Children)
                if (preg_match('/[A-Za-z]/', $occupancyStr)) {
                    // Save original string to occupancy_details if that column exists in fillable
                    if (in_array('occupancy_details', $fillable)) {
                        $prepared['occupancy_details'] = $occupancyStr;
                    }

                    // Calculate total numeric value
                    $total = 0;
                    if (preg_match_all('/(\d+)[ACac]/', $occupancyStr, $matches)) {
                        $total = array_sum(array_map('intval', $matches[1]));
                    }

                    // Replace max_occupancy with numeric total
                    $prepared['max_occupancy'] = $total > 0 ? $total : 1;
                }
            }

            // Log first prepared row as sample
            if ($rowIndex === 0 || $totalRows === 1) {
                Log::debug('ImportDataJob sample prepared row: ' . json_encode($prepared));
            }

            // Coerce date-like columns (excel serial numbers or unparsable strings)
            foreach ($prepared as $kcol => $val) {
                if ($val === null)
                    continue;
                if (isset($dateLikeColumns[$kcol])) {
                    // Excel serial numbers are integers (e.g. 44561)
                    if (is_numeric($val) && intval($val) == $val) {
                        try {
                            $serial = intval($val);
                            // Excel to Unix timestamp: ($serial - 25569) * 86400
                            $timestamp = ($serial - 25569) * 86400;
                            // guard against negative timestamps
                            if ($timestamp > 0) {
                                $prepared[$kcol] = \Carbon\Carbon::createFromTimestampUTC($timestamp)->toDateTimeString();
                            } else {
                                $prepared[$kcol] = null;
                            }
                        } catch (\Throwable $e) {
                            $prepared[$kcol] = null;
                        }
                    } else {
                        // try parsing string dates robustly
                        try {
                            $prepared[$kcol] = \Carbon\Carbon::parse($val)->toDateTimeString();
                        } catch (\Throwable $e) {
                            // if parse fails, set null and log a debug entry
                            Log::debug("Failed to parse date for column {$kcol}: " . var_export($val, true));
                            $prepared[$kcol] = null;
                        }
                    }
                }
            }
            // prevent duplicate primary-key insertion (CSV might contain `id` column)
            try {
                $pk = $model->getKeyName();
                if (!empty($pk) && isset($prepared[$pk])) {
                    unset($prepared[$pk]);
                }
            } catch (\Throwable $_) {
                // ignore if model doesn't provide key name
            }


            // debug: log the resolved fillable columns and primary key
            try {
                $resolvedPk = null;
                try {
                    $resolvedPk = $model->getKeyName();
                } catch (\Throwable $_) {
                    $resolvedPk = null;
                }
                Log::debug('ImportDataJob resolved fillable: ' . implode(',', $fillable) . ' pk: ' . ($resolvedPk ?? 'NULL'));
            } catch (\Throwable $_) {
                // ignore logging failures
            }
            $buffer[] = $prepared;

            if (count($buffer) >= $this->chunkSize) {
                // defensive: remove any primary-key-like keys from buffer rows before insert
                $pk = null;
                try {
                    $pk = $model->getKeyName();
                } catch (\Throwable $_) {
                    $pk = null;
                }

                // Strong sanitization: only allow columns that are in $fillable
                // and always strip primary-key-like keys (id and model PK),
                // handling BOM/encoding/whitespace variants via normalization.
                $sanitized = [];
                // Ensure 'id' and model primary key are removed from allowed columns
                $normPkTmp = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                $allowed = array_values(array_filter($fillable, function ($c) use ($normPkTmp) {
                    $norm = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $c)));
                    if ($norm === 'id')
                        return false;
                    if ($normPkTmp && $norm === $normPkTmp)
                        return false;
                    return true;
                }));
                $normPk = $normPkTmp;
                $normAllowed = [];
                foreach ($allowed as $a) {
                    $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
                }

                foreach ($buffer as $row) {
                    $filtered = [];
                    foreach ($row as $origKey => $value) {
                        $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));

                        // drop any primary key-like column (explicit id or model pk)
                        if ($normKey === 'id' || ($normPk && $normKey === $normPk)) {
                            continue;
                        }

                        // if the original key exactly matches an allowed column, keep it
                        if (in_array($origKey, $allowed, true)) {
                            $filtered[$origKey] = $value;
                            continue;
                        }

                        // otherwise try to match by normalized names to an allowed column
                        foreach ($normAllowed as $allowedOrig => $allowedNorm) {
                            if ($normKey === $allowedNorm) {
                                $filtered[$allowedOrig] = $value;
                                break;
                            }
                        }
                    }
                    $sanitized[] = $filtered;
                }

                try {
                    // debug: log the columns we will insert for verification
                    if (!empty($sanitized)) {
                        Log::debug('Inserting chunk columns: ' . implode(',', array_keys((array) $sanitized[0])));
                        Log::debug('Allowed columns for insert: ' . implode(',', $allowed));
                        // Build final rows using only allowed columns (prevent any unexpected keys)
                        $finalRows = [];
                        foreach ($sanitized as $sr) {
                            $rowBuilt = [];
                            foreach ($allowed as $col) {
                                if (array_key_exists($col, $sr)) {
                                    $rowBuilt[$col] = $sr[$col];
                                    continue;
                                }
                                // case-insensitive fallback
                                foreach ($sr as $k => $v) {
                                    if (mb_strtolower(trim((string) $k)) === mb_strtolower(trim((string) $col))) {
                                        $rowBuilt[$col] = $v;
                                        break;
                                    }
                                }
                            }
                            $finalRows[] = $rowBuilt;
                        }
                        Log::debug('Final rows count before insert: ' . count($finalRows));
                        if (!empty($finalRows)) {
                            Log::debug('Sample final row: ' . json_encode($finalRows[0]));
                        }
                    } else {
                        $finalRows = [];
                    }
                    $this->modelClass::insert($finalRows);
                    $counter += count($finalRows);
                } catch (\Throwable $e) {
                    Log::warning('Bulk insert failed, falling back to per-row inserts: ' . $e->getMessage());
                    // notify error
                    try {
                        Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                    } catch (\Throwable $_) {
                        Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
                    }
                    foreach ($sanitized as $r) {
                        try {
                            // Ensure single-row is filtered the same way as chunks
                            $filtered = [];
                            $normPkSingle = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                            foreach ($r as $origKey => $value) {
                                $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                                if ($normKey === 'id' || ($normPkSingle && $normKey === $normPkSingle)) {
                                    continue;
                                }
                                if (in_array($origKey, $allowed ?? [], true)) {
                                    $filtered[$origKey] = $value;
                                    continue;
                                }
                                foreach ($normAllowed ?? [] as $allowedOrig => $allowedNorm) {
                                    if ($normKey === $allowedNorm) {
                                        $filtered[$allowedOrig] = $value;
                                        break;
                                    }
                                }
                            }
                            Log::debug('Inserting single row columns: ' . implode(',', array_keys((array) $filtered)));
                            if (!empty($filtered)) {
                                $this->modelClass::insert([$filtered]);
                                $counter++;
                            }
                        } catch (\Throwable $er) {
                            Log::warning('Skipping failing row during import: ' . json_encode($r) . ' Error: ' . $er->getMessage());
                        }
                    }
                }

                // broadcast progress update (non-blocking)
                try {
                    Event::dispatch(new ImportExportCompleted(__('main.import_progress', ['count' => number_format($counter)]), $this->userId));
                } catch (\Throwable $e) {
                    Log::warning('Failed to broadcast progress: ' . $e->getMessage());
                }

                $buffer = [];
            }
        }

        // remaining
        if (!empty($buffer)) {
            // sanitize final buffer similar to chunk handling
            $pk = null;
            try {
                $pk = $model->getKeyName();
            } catch (\Throwable $_) {
                $pk = null;
            }

            // Strong sanitization for final buffer: same behavior as chunk handling
            $sanitized = [];
            // Ensure 'id' and model primary key are removed from allowed columns
            $normPkTmp = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
            $allowed = array_values(array_filter($fillable, function ($c) use ($normPkTmp) {
                $norm = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $c)));
                if ($norm === 'id')
                    return false;
                if ($normPkTmp && $norm === $normPkTmp)
                    return false;
                return true;
            }));
            $normPk = $normPkTmp;
            $normAllowed = [];
            foreach ($allowed as $a) {
                $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
            }

            foreach ($buffer as $row) {
                $filtered = [];
                foreach ($row as $origKey => $value) {
                    $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                    if ($normKey === 'id' || ($normPk && $normKey === $normPk)) {
                        continue;
                    }
                    if (in_array($origKey, $allowed, true)) {
                        $filtered[$origKey] = $value;
                        continue;
                    }
                    foreach ($normAllowed as $allowedOrig => $allowedNorm) {
                        if ($normKey === $allowedNorm) {
                            $filtered[$allowedOrig] = $value;
                            break;
                        }
                    }
                }
                $sanitized[] = $filtered;
            }

            try {
                // Build final rows using only allowed columns for the final chunk
                $finalRows = [];
                foreach ($sanitized as $sr) {
                    $rowBuilt = [];
                    foreach ($allowed as $col) {
                        if (array_key_exists($col, $sr)) {
                            $rowBuilt[$col] = $sr[$col];
                            continue;
                        }
                        foreach ($sr as $k => $v) {
                            if (mb_strtolower(trim((string) $k)) === mb_strtolower(trim((string) $col))) {
                                $rowBuilt[$col] = $v;
                                break;
                            }
                        }
                    }
                    $finalRows[] = $rowBuilt;
                }
                $this->modelClass::insert($finalRows);
                $counter += count($finalRows);
            } catch (\Throwable $e) {
                Log::warning('Bulk insert failed on final chunk, falling back to per-row inserts: ' . $e->getMessage());
                try {
                    Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                } catch (\Throwable $_) {
                    Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
                }
                foreach ($sanitized as $r) {
                    try {
                        // ensure no PK present (normalized check)
                        foreach (array_keys($r) as $k) {
                            $normKey = preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $k)));
                            $normPk = $pk ? preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $pk))) : null;
                            if ($normPk && $normKey === $normPk) {
                                unset($r[$k]);
                                continue;
                            }
                            if ($normKey === 'id') {
                                unset($r[$k]);
                                continue;
                            }
                        }
                        $this->modelClass::insert([$r]);
                        $counter++;
                    } catch (\Throwable $er) {
                        Log::warning('Skipping failing row during import (final chunk): ' . json_encode($r) . ' Error: ' . $er->getMessage());
                    }
                }
            }
        }

        // Log summary
        Log::debug("ImportDataJob completed: Total rows read: {$totalRows}, Records inserted: {$counter}");

        // استخراج اسم الموديل بشكل أنظف
        $modelName = class_basename($this->modelClass);
        $modelNamePlural = \Illuminate\Support\Str::plural(strtolower($modelName));
        $modelNameAr = __('main.' . $modelNamePlural);

        // إرسال رسالة نجاح مفصلة
        $message = __('main.import_completed_successfully', [
            'model' => $modelNameAr,
            'count' => number_format($counter),
        ]);

        // في حالة عدم وجود ترجمة، استخدم رسالة افتراضية
        if (str_contains($message, 'main.import_completed_successfully')) {
            $message = "تم استيراد " . number_format($counter) . " سجل من {$modelNameAr} بنجاح!";
        }

        try {
            Event::dispatch(new ImportExportCompleted($message, $this->userId));
        } catch (\Throwable $e) {
            Log::warning('Failed to broadcast completion: ' . $e->getMessage());
        }
        // notify successful storage
        try {
            Event::dispatch(new DataStorageMessage('تم التخزين'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage success message: ' . $e->getMessage());
        }
    }
}