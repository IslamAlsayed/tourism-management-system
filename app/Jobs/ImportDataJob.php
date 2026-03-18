<?php

namespace App\Jobs;

use App\Events\DataStorageMessage;
use App\Events\ImportExportCompleted;
use App\Services\TransportationDataImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Accommodations\Entities\Type;
use Modules\CRM\Entities\Client;
use Modules\Geography\Entities\City;
use Modules\Geography\Entities\Country;
use Modules\Geography\Entities\Region;
use Modules\Geography\Entities\State;
use Modules\Geography\Entities\Subregion;
use Modules\Transportation\Entities\Company;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;

    protected string $filePath;

    protected ?int $userId;

    protected int $chunkSize;

    protected array $pendingTransportationContacts = [];

    protected array $transportationCompanyUuidMap = [];

    protected array $tourGuideTypePivotData = []; // Store pivot data for TourGuideType

    protected array $tourGuideLanguagePivotData = []; // Store pivot data for TourGuide

    protected ?string $historyUuid;

    protected string $source;

    public function __construct(string $modelClass, string $filePath, int $chunkSize = 1000, ?int $userId = null, string $source = 'file', ?string $historyUuid = null)
    {
        $this->modelClass = $modelClass;
        $this->filePath = $filePath;
        $this->chunkSize = $chunkSize;
        $this->userId = $userId;
        $this->source = $source;
        $this->historyUuid = $historyUuid;
    }

    public function handle(): void
    {
        set_time_limit(300); // Allow sufficient time for large imports
        
        $totalRecords = 0;
        try {
            $totalRecords = SimpleExcelReader::create($this->filePath)->getRows()->count();
        } catch (\Throwable $e) {
            Log::warning("Could not count total rows for progress: " . $e->getMessage());
        }

        if ($this->historyUuid) {
            \App\Models\ImportHistory::where('uuid', $this->historyUuid)->update([
                'status' => 'processing',
                'total_records' => $totalRecords > 0 ? $totalRecords : null,
                'processed_records' => 0,
            ]);
        }
        $model = new $this->modelClass;

        if (! method_exists($model, 'getFillable')) {
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
            // HOWEVER, we will allow 'id' and 'uuid' specifically for data integrity if provided in Excel
            try {
                $pkName = $model->getKeyName();
                if (! empty($pkName)) {
                    $pkLower = strtolower($pkName);
                    // We'll keep it in our internal list to look for in Excel, but it's handled separately
                }
            } catch (\Throwable $_) {
                // ignore
            }

            // fetch column types so we can coerce dates
            $cols = \Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM `'.$model->getTable().'`');
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
            Log::warning('Failed to inspect DB columns for '.$this->modelClass.': '.$e->getMessage());
        }

        // اقرأ الملف كـ stream (بدون تحميل كل البيانات مرة واحدة)
        // notify start of storage
        try {
            Event::dispatch(new DataStorageMessage('سيتم تخزين البيانات'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage start message: '.$e->getMessage());
        }

        $rows = SimpleExcelReader::create($this->filePath)
            ->getRows();

        $buffer = [];
        $counter = 0;
        $headerMap = null; // map normalized header -> actual header key
        $totalRows = 0; // track total rows read
        $lookupCache = []; // To prevent N+1 queries during import

        foreach ($rows as $rowIndex => $row) {
            $totalRows++;

            // Check for cancellation periodically
            if ($this->historyUuid && $totalRows % 100 === 0) {
                $currentStatus = \App\Models\ImportHistory::where('uuid', $this->historyUuid)->value('status');
                if ($currentStatus === 'failed') {
                    Log::info("Import job {$this->historyUuid} was canceled by the user.");
                    return; // Abort job completely
                }
            }

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
                Log::debug('ImportDataJob detected headers: '.json_encode($headerMap));

                // create reverse lookup from fillable -> header key if possible
                // also include 'id' and 'uuid' in the search
                $searchableCols = array_merge($fillable, ['id', 'uuid']);
                $fillableLookup = [];
                foreach ($searchableCols as $col) {
                    $colNorm = strtolower($col);
                    $foundIdAlias = false;

                    // Aliases for 'id' to ensure row numbering from Excel acts as ID
                    if ($col === 'id') {
                        $modelBaseName = strtolower(class_basename($this->modelClass));
                        $idAliases = ['#', 'no', 'no.', 'number', 'الرقم', 'رقم', 'id', "{$modelBaseName}_id"];
                        foreach ($headerMap as $hNorm => $orig) {
                            if (in_array($hNorm, $idAliases)) {
                                $fillableLookup['id'] = $orig;
                                $foundIdAlias = true;
                                break;
                            }
                        }
                        if ($foundIdAlias) {
                            continue;
                        }
                    }

                    // try exact match
                    if (isset($headerMap[$colNorm])) {
                        $fillableLookup[$col] = $headerMap[$colNorm];

                        continue;
                    }

                    // Smart alias mapping for common columns
                    $modelBaseName = strtolower(class_basename($this->modelClass));
                    if ($col === 'name') {
                        $aliases = [
                            "{$modelBaseName}_en", "{$modelBaseName}_name", 'name_en', 'en',
                            'guide_name_en', 'guidename_en', 'guidenameenglish', 'guide_name',
                            'nameenglish', 'name_english', 'english_name', 'englishname',
                            'continent_name', 'subregion_name', 'sub_region_name', 'country_name', 'state_name', 'city_name', 'name', 'englishname',
                        ];
                        foreach ($aliases as $alias) {
                            if (isset($headerMap[$alias])) {
                                $fillableLookup[$col] = $headerMap[$alias];

                                continue 2;
                            }
                        }
                    }
                    if ($col === 'name_ar') {
                        $aliases = [
                            "{$modelBaseName}_ar", 'ar',
                            'guide_name_ar', 'guidename_ar', 'guidenamearbic', 'guidenamarabic',
                            'namearabic', 'name_arabic', 'arabic_name', 'arabicname', 'name_ar',
                            'continent_name_arabic', 'subregion_arabic', 'sub_region_arabic', 'country_arabic', 'state_arabic', 'city_arabic',
                            'continent_name_ar', 'subregion_name_arabic', 'sub_region_name_arabic', 'arabicname', 'namearabic',
                        ];
                        foreach ($aliases as $alias) {
                            if (isset($headerMap[$alias])) {
                                $fillableLookup[$col] = $headerMap[$alias];

                                continue 2;
                            }
                        }
                    }

                    // tourism_ministry_code aliases
                    if ($col === 'tourism_ministry_code') {
                        $aliases = ['tourism_ministry_id', 'tourismministryid', 'ministry_code', 'ministrycode', 'ministry_id'];
                        foreach ($aliases as $alias) {
                            if (isset($headerMap[$alias])) {
                                $fillableLookup[$col] = $headerMap[$alias];

                                continue 2;
                            }
                        }
                    }

                    // Special alias for curancy_id -> currency_id which is misspelled in their sheet
                    if ($col === 'currency_id') {
                        $aliases = ['curancy_id', 'currency', 'curancy'];
                        foreach ($aliases as $alias) {
                            if (isset($headerMap[$alias])) {
                                $fillableLookup[$col] = $headerMap[$alias];

                                continue 2;
                            }
                        }
                    }

                    // TourGuide specific aliases
                    if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                        if ($col === 'birth_date') {
                            $aliases = ['dob', 'date_of_birth', 'birthdate', 'birth_date', 'تاريخ_الميلاد'];
                            foreach ($aliases as $alias) {
                                if (isset($headerMap[$alias])) {
                                    $fillableLookup[$col] = $headerMap[$alias];

                                    continue 2;
                                }
                            }
                        }
                        if ($col === 'home_city' || $col === 'city_id') {
                            $aliases = ['home_city', 'city', 'cities', 'city_id', 'مدينة_السكن', 'المدينة'];
                            foreach ($aliases as $alias) {
                                if (isset($headerMap[$alias])) {
                                    $fillableLookup[$col] = $headerMap[$alias];

                                    continue 2;
                                }
                            }
                        }
                        if ($col === 'state_id') {
                            $aliases = ['state', 'states', 'state_id', 'governorate', 'المحافظة'];
                            foreach ($aliases as $alias) {
                                if (isset($headerMap[$alias])) {
                                    $fillableLookup[$col] = $headerMap[$alias];

                                    continue 2;
                                }
                            }
                        }
                        if ($col === 'guide_type_id') {
                            $aliases = ['guide_type', 'type', 'category', 'guide_type_id', 'نوع_الدليل'];
                            foreach ($aliases as $alias) {
                                if (isset($headerMap[$alias])) {
                                    $fillableLookup[$col] = $headerMap[$alias];

                                    continue 2;
                                }
                            }
                        }
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
                Log::debug('ImportDataJob fillable lookup: '.json_encode($fillableLookup));
            }

            // تنظيف القيم: trim/null
            $cleaned = [];
            foreach ((array) $row as $k => $v) {
                if (is_string($v)) {
                    $v = trim($v);
                    if ($v === '' || strtolower($v) === 'null') {
                        $v = null;
                    }
                }
                $cleaned[$k] = $v;
            }

            // Capture TourGuideType pivot data BEFORE filtering by fillable
            // This is necessary because state_id and city_id are NOT columns in tour_guide_types table
            if ($this->modelClass === \Modules\TourGuides\Entities\TourGuideType::class) {
                $pivotData = [];
                // Extract state_id and city_id with aliases and smart resolution
                $stateValue = null;
                $cityValue = null;
                foreach ($headerMap as $normKey => $origKey) {
                    if (in_array($normKey, ['state_id', 'state', 'states', 'states_name']) && isset($cleaned[$origKey])) {
                        $stateValue = $cleaned[$origKey];
                    }
                    if (in_array($normKey, ['city_id', 'city', 'cities', 'home_city', 'cities_id']) && isset($cleaned[$origKey])) {
                        $cityValue = $cleaned[$origKey];
                    }
                }

                if ($stateValue !== null) {
                    if (is_numeric($stateValue)) {
                        $pivotData['state_id'] = str_replace(['[', ']', ' '], '', (string) $stateValue);
                    } else {
                        // resolve by name
                        $searchTerm = trim((string) $stateValue);
                        $state = \Modules\Geography\Entities\State::where('name', $searchTerm)->orWhere('name_ar', $searchTerm)->first();
                        if ($state) {
                            $pivotData['state_id'] = $state->id;
                        }
                    }
                }

                if ($cityValue !== null) {
                    if (is_numeric($cityValue)) {
                        $pivotData['city_id'] = str_replace(['[', ']', ' '], '', (string) $cityValue);
                    } else {
                        // resolve by name
                        $searchTerm = trim((string) $cityValue);
                        $city = \Modules\Geography\Entities\City::where('name', $searchTerm)->orWhere('name_ar', $searchTerm)->first();
                        if ($city) {
                            $pivotData['city_id'] = $city->id;
                        }
                    }
                }
                // Try to get identifying info (including row index as fallback)
                foreach ($headerMap as $normKey => $origKey) {
                    if ($normKey === 'uuid' && isset($cleaned[$origKey])) {
                        $pivotData['uuid'] = $cleaned[$origKey];
                    }
                    if ($normKey === 'type' && isset($cleaned[$origKey])) {
                        $pivotData['type'] = $cleaned[$origKey];
                    }
                }
                // Add row index to ensure we can match even if UUID is missing
                $pivotData['row_index'] = $totalRows;
                $this->tourGuideTypePivotData[] = $pivotData;
                Log::debug('Captured TourGuideType pivot data: '.json_encode($pivotData));
            }

            // Build a row aligned with $fillable using lookup when possible
            // Include 'id' and 'uuid' if found in Excel
            $prepared = [];
            $potentialCols = array_merge($fillable, ['id', 'uuid']);
            foreach ($potentialCols as $col) {
                if (! empty($fillableLookup[$col])) {
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
            // Remove null ID/UUID if they weren't in the original excel to avoid issues
            if (isset($prepared['id']) && $prepared['id'] === null) {
                unset($prepared['id']);
            }
            if (isset($prepared['uuid']) && $prepared['uuid'] === null) {
                unset($prepared['uuid']);
            }

            // Extract Guide Languages (comma separated) for TourGuideLanguage pivot relations
            if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                $langColumnExists = null;
                foreach ($headerMap as $normKey => $origKey) {
                    if (in_array($normKey, ['guide_languages', 'languages', 'guidelanguages'])) {
                        $langColumnExists = $origKey;
                        break;
                    }
                }
                if ($langColumnExists && isset($cleaned[$langColumnExists]) && ! empty($cleaned[$langColumnExists])) {
                    $langString = $cleaned[$langColumnExists];
                    // Example: "Spanish،French،Italian،English" OR "Spanish,French,English"
                    $langStrNorm = str_replace('،', ',', $langString); // replace arabic comma
                    $langArray = array_map('trim', explode(',', $langStrNorm));
                    $langIds = [];
                    foreach ($langArray as $langName) {
                        if (empty($langName)) {
                            continue;
                        }
                        // Match or create the Language dynamically. Assuming \Modules\Localization\Entities\Language
                        $lk = mb_strtolower($langName);
                        $langRec = \Modules\Localization\Entities\Language::whereRaw('LOWER(name) = ?', [$lk])
                            ->orWhereRaw('LOWER(name_ar) = ?', [$lk])
                            ->first();

                        if (! $langRec) {
                            // Generate a safe unique code
                            $baseCode = substr($lk, 0, 2);
                            if (strlen($baseCode) < 2) {
                                $baseCode = 'l' . rand(1, 9);
                            }
                            // ensure ascii chars for code (if arabic, default to AR+rand)
                            if (!preg_match('/^[a-z0-9]+$/i', $baseCode)) {
                                $baseCode = 'ar' . rand(10, 99);
                            }

                            $uniqueCode = $baseCode;
                            $counterCode = 1;
                            while (\Modules\Localization\Entities\Language::where('code', $uniqueCode)->exists()) {
                                $uniqueCode = $baseCode . $counterCode;
                                $counterCode++;
                            }

                            $langRec = \Modules\Localization\Entities\Language::create([
                                'name' => $langName,
                                'name_ar' => $langName, // No auto translation mechanism readily available, store as is
                                'code' => $uniqueCode,
                                'is_active' => true,
                            ]);
                        }
                        if ($langRec) {
                            $langIds[] = $langRec->id;
                        }
                    }

                    if (! empty($langIds)) {
                        // Create pivot array linking row_index or uuid to languages
                        $pivotData = [
                            'row_index' => $totalRows,
                            'language_ids' => array_unique($langIds),
                        ];
                        if (isset($prepared['uuid'])) {
                            $pivotData['uuid'] = $prepared['uuid'];
                        }
                        $this->tourGuideLanguagePivotData[] = $pivotData;
                        Log::debug('Captured TourGuide Language pivot data: '.json_encode($pivotData));
                    }
                }
            }

            // Robustly parse boolean fields natively
            $booleanFields = ['is_active', 'is_included'];
            foreach ($booleanFields as $boolField) {
                if (array_key_exists($boolField, $prepared)) {
                    $val = $prepared[$boolField];
                    if ($val === null || $val === '') {
                        // Setup default logic: is_active defaults to true, is_included defaults to false
                        $prepared[$boolField] = ($boolField === 'is_active');
                    } else {
                        // Cast '1', '0', 'true', 'false', 'yes', 'no', 'active', 'inactive' safely
                        $valStr = strtolower(trim((string) $val));
                        $truthy = ['1', 'true', 'yes', 'active', 'y', 't'];
                        $falsy = ['0', 'false', 'no', 'inactive', 'n', 'f'];

                        if (in_array($valStr, $truthy, true)) {
                            $prepared[$boolField] = true;
                        } elseif (in_array($valStr, $falsy, true)) {
                            $prepared[$boolField] = false;
                        } else {
                            // Fallback to strict boolean cast if unknown string
                            $prepared[$boolField] = (bool) $val;
                        }
                    }
                }
            }

            // Normalize gender values (e.g., 'M' → 'male', 'F' → 'female')
            if (array_key_exists('gender', $prepared) && $prepared['gender'] !== null) {
                $genderVal = strtolower(trim((string) $prepared['gender']));
                $maleAliases = ['m', 'male', 'man', 'ذكر', 'رجل'];
                $femaleAliases = ['f', 'female', 'woman', 'أنثى', 'امرأة'];

                if (in_array($genderVal, $maleAliases, true)) {
                    $prepared['gender'] = 'male';
                } elseif (in_array($genderVal, $femaleAliases, true)) {
                    $prepared['gender'] = 'female';
                } else {
                    // Unknown gender value (e.g., '?') — set to null
                    $prepared['gender'] = null;
                    Log::debug("Unrecognized gender value '{$genderVal}' set to null");
                }
            }

            // Generate UUID if column exists in fillable and value is empty/null
            if (in_array('uuid', $fillable) && empty($prepared['uuid'])) {
                $prepared['uuid'] = (string) Str::uuid();
            }

            // Generate code for Client model if column exists and value is empty
            if ($this->modelClass === Client::class && in_array('code', $fillable) && empty($prepared['code'])) {
                $prepared['code'] = generateCode('CLT-', 5);
                Log::debug("Auto-generated Client code: {$prepared['code']}");
            }

            // Convert model_type from simple name to full namespace
            // e.g., "accommodation" -> "App\Models\Accommodation"
            // e.g., "transportation-company" -> Company"
            if (in_array('model_type', $fillable) && ! empty($prepared['model_type'])) {
                $modelType = trim((string) $prepared['model_type']);

                // If it doesn't contain backslash, assume it's a simple name
                if (! str_contains($modelType, '\\')) {
                    // Convert kebab-case, snake_case, or lowercase to StudlyCase
                    $className = Str::studly(str_replace(['-', '_'], ' ', $modelType));
                    $prepared['model_type'] = "App\\Models\\{$className}";
                    Log::debug("Converted model_type '{$modelType}' to '{$prepared['model_type']}'");
                }
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

            // Normalize price_type to snake_case if exists
            if (isset($prepared['price_type'])) {
                $priceTypeStr = trim((string) $prepared['price_type']);
                $prepared['price_type'] = Str::snake($priceTypeStr);
                Log::debug("Normalized price_type to '{$prepared['price_type']}'");
            }

            // Smart timezone_id lookup: if value is text, search by name/abbreviation
            if (
                in_array('timezone_id', $fillable) && ! empty($prepared['timezone_id']) ||
                in_array('timezone', $fillable) && ! empty($prepared['timezone'])
            ) {
                $timezoneValue = $prepared['timezone_id'] ?? $prepared['timezone'];

                // If not numeric, try to find timezone by name intelligently
                if (! is_numeric($timezoneValue)) {
                    try {
                        $searchTerm = trim((string) $timezoneValue);
                        $cacheKey = 'timezone_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['timezone_id'] = $lookupCache[$cacheKey];
                        } else {
                            // Try exact match first (name, name_ar, or abbreviation)
                            $timezone = \Modules\Localization\Entities\Timezone::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->orWhere('abbreviation', $searchTerm)
                                ->first();

                            // If not found, try case-insensitive partial match
                            if (! $timezone) {
                                try {
                                    $timezone = \Modules\Localization\Entities\Timezone::where('name', 'LIKE', "%{$searchTerm}%")
                                        ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                                        ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                        ->orWhere('abbreviation', 'LIKE', "%{$searchTerm}%")
                                        ->first();
                                    Log::info("Created new timezone: '{$searchTerm}' with ID: {$timezone->id}");
                                } catch (\Throwable $createError) {
                                    Log::warning("Failed to create new timezone '{$searchTerm}': ".$createError->getMessage());
                                    $prepared['timezone_id'] = null;
                                }
                            }

                            if ($timezone) {
                                $prepared['timezone_id'] = $timezone->id;
                                $lookupCache[$cacheKey] = $timezone->id;
                                Log::debug("Resolved timezone '{$searchTerm}' to ID: {$timezone->id} ({$timezone->name})");
                            } else {
                                Log::warning("Could not resolve timezone: '{$searchTerm}' - setting to null");
                                $prepared['timezone_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve timezone: '.$e->getMessage());
                        $prepared['timezone_id'] = null;
                    }
                }
            } else {
                $prepared['timezone_id'] = 1;
            }

            // Smart language_id lookup: if value is text, search by name/code
            if (in_array('language_id', $fillable) && ! empty($prepared['language_id'])) {
                $languageValue = $prepared['language_id'];

                if (! is_numeric($languageValue)) {
                    try {
                        $searchTerm = trim((string) $languageValue);
                        $cacheKey = 'language_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['language_id'] = $lookupCache[$cacheKey];
                        } else {
                            // Try exact match first (name, name_ar, code, or iso_code)
                            $language = \Modules\Localization\Entities\Language::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->orWhere('code', $searchTerm)
                                ->orWhere('iso_code', $searchTerm)
                                ->first();

                            // If not found, try partial match
                            if (! $language) {
                                $language = \Modules\Localization\Entities\Language::where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                    ->first();
                            }

                            if ($language) {
                                $prepared['language_id'] = $language->id;
                                $lookupCache[$cacheKey] = $language->id;
                                Log::debug("Resolved language '{$searchTerm}' to ID: {$language->id} ({$language->name})");
                            } else {
                                Log::warning("Could not resolve language: '{$searchTerm}' - setting to null");
                                $prepared['language_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve language: '.$e->getMessage());
                        $prepared['language_id'] = null;
                    }
                }
            }

            // Smart currency lookup: searches by ID, name, or code
            $currencyKeys = ['currency_id', 'currency', 'curancy_id'];
            $currencyResolved = false;
            foreach ($currencyKeys as $ck) {
                if (array_key_exists($ck, $prepared) && $prepared[$ck] !== null) {
                    $val = $prepared[$ck];
                    if (is_numeric($val) && $val > 0) {
                        $prepared['currency_id'] = (int) $val;
                    } elseif (is_string($val)) {
                        $valTrim = strtolower(trim($val));
                        $cacheKey = 'currency_' . md5($valTrim);

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['currency_id'] = $lookupCache[$cacheKey];
                        } else {
                            // Lookup by name, code, or symbol
                            $cObj = \Modules\Localization\Entities\Currency::where('name', 'like', "%{$valTrim}%")
                                ->orWhere('name_ar', 'like', "%{$valTrim}%")
                                ->orWhere('code', 'like', "%{$valTrim}%")
                                ->orWhere('symbol', 'like', "%{$valTrim}%")
                                ->first();

                            // If matching fails by exact name, we default to 138 (JOD)
                            $prepared['currency_id'] = $cObj ? $cObj->id : 138;
                            $lookupCache[$cacheKey] = $prepared['currency_id'];
                        }
                    } else {
                        $prepared['currency_id'] = 138; // Default fallback to Jordanian Dinar
                    }
                    $currencyResolved = true;
                    // Unset alias keys if they aren't 'currency_id'
                    if ($ck !== 'currency_id') {
                        unset($prepared[$ck]);
                    }
                    break;
                }
            }

            // Always assign default currency if column is completely missing
            if (! $currencyResolved && in_array('currency_id', $fillable)) {
                $prepared['currency_id'] = 138;
            }

            // Smart birth_date and age mapping for TourGuides
            if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                $dateKeys = ['birth_date', 'birth_year', 'birthyear', 'birthdate'];
                foreach ($dateKeys as $dk) {
                    if (isset($prepared[$dk]) && ! empty($prepared[$dk])) {
                        $val = $prepared[$dk];
                        try {
                            if (is_numeric($val) && (int) $val > 1900 && (int) $val < 2100) {
                                // Assume it's just a year
                                $prepared['birth_date'] = (int) $val.'-01-01';
                            } else {
                                $prepared['birth_date'] = \Carbon\Carbon::parse((string) $val)->format('Y-m-d');
                            }
                            // Calculate age
                            $prepared['age'] = \Carbon\Carbon::parse($prepared['birth_date'])->age;
                        } catch (\Throwable $e) {
                            Log::warning("Failed to parse birth_date from '{$val}': ".$e->getMessage());
                        }
                        if ($dk !== 'birth_date') {
                            unset($prepared[$dk]);
                        }
                        break;
                    }
                }

                // Smart guide_type_id lookup by name
                if (in_array('guide_type_id', $fillable) && ! empty($prepared['guide_type_id'])) {
                    $typeValue = $prepared['guide_type_id'];
                    if (! is_numeric($typeValue)) {
                        $searchTerm = trim((string) $typeValue);
                        $cacheKey = 'guide_type_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['guide_type_id'] = $lookupCache[$cacheKey];
                        } else {
                            $type = \Modules\TourGuides\Entities\TourGuideType::where('type', $searchTerm)
                                ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                                ->first();
                            if ($type) {
                                $prepared['guide_type_id'] = $type->id;
                                $lookupCache[$cacheKey] = $type->id;
                            } else {
                                $prepared['guide_type_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    }
                }

                // Smart state_id lookup by name
                if (in_array('state_id', $fillable) && ! empty($prepared['state_id'])) {
                    $stateValue = $prepared['state_id'];
                    if (! is_numeric($stateValue)) {
                        $searchTerm = trim((string) $stateValue);
                        $cacheKey = 'state_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['state_id'] = $lookupCache[$cacheKey];
                        } else {
                            $state = \Modules\Geography\Entities\State::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->first();
                            if ($state) {
                                $prepared['state_id'] = $state->id;
                                $lookupCache[$cacheKey] = $state->id;
                            } else {
                                $prepared['state_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    }
                }

                // Smart city_id lookup by name
                if (in_array('city_id', $fillable) && ! empty($prepared['city_id'])) {
                    $cityValue = $prepared['city_id'];
                    if (! is_numeric($cityValue)) {
                        $searchTerm = trim((string) $cityValue);
                        $cacheKey = 'city_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['city_id'] = $lookupCache[$cacheKey];
                        } else {
                            $city = \Modules\Geography\Entities\City::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->first();
                            if ($city) {
                                $prepared['city_id'] = $city->id;
                                $lookupCache[$cacheKey] = $city->id;
                            } else {
                                $prepared['city_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    }
                }

                // Smart country_id lookup by name
                if (in_array('country_id', $fillable) && ! empty($prepared['country_id'])) {
                    $countryValue = $prepared['country_id'];
                    if (! is_numeric($countryValue)) {
                        $searchTerm = trim((string) $countryValue);
                        $cacheKey = 'country_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['country_id'] = $lookupCache[$cacheKey];
                        } else {
                            $country = \Modules\Geography\Entities\Country::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->first();
                            if ($country) {
                                $prepared['country_id'] = $country->id;
                                $lookupCache[$cacheKey] = $country->id;
                            } else {
                                $prepared['country_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    }
                }
            }

            // Extract Guide Languages (comma separated) for TourGuideLanguage pivot relations
            if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                $langColumnExists = null;
                foreach ($headerMap as $normKey => $origKey) {
                    if (in_array($normKey, ['guide_languages', 'languages', 'guidelanguages'])) {
                        $langColumnExists = $origKey;
                        break;
                    }
                }
                if ($langColumnExists && isset($cleaned[$langColumnExists]) && ! empty($cleaned[$langColumnExists])) {
                    $langString = $cleaned[$langColumnExists];
                    // Example: "Spanish،French،Italian،English" OR "Spanish,French,English"
                    $langStrNorm = str_replace('،', ',', $langString); // replace arabic comma
                    $langArray = array_map('trim', explode(',', $langStrNorm));
                    $langIds = [];
                    foreach ($langArray as $langName) {
                        if (empty($langName)) {
                            continue;
                        }
                        // Match or create the Language dynamically. Assuming \Modules\Localization\Entities\Language
                        $lk = mb_strtolower($langName);
                        $cacheKey = 'language_code_' . md5($lk);
                        
                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $langIds[] = $lookupCache[$cacheKey];
                            continue;
                        }
                        
                        $langRec = \Modules\Localization\Entities\Language::whereRaw('LOWER(name) = ?', [$lk])
                            ->orWhereRaw('LOWER(name_ar) = ?', [$lk])
                            ->first();

                        if (! $langRec) {
                            $langRec = \Modules\Localization\Entities\Language::create([
                                'name' => $langName,
                                'name_ar' => $langName, // No auto translation mechanism readily available, store as is
                                'code' => substr($lk, 0, 2),
                                'is_active' => true,
                            ]);
                        }
                        if ($langRec) {
                            $langIds[] = $langRec->id;
                            $lookupCache[$cacheKey] = $langRec->id;
                        }
                    }

                    if (! empty($langIds)) {
                        $pivotData = [
                            'row_index' => $totalRows,
                            'language_ids' => array_unique($langIds),
                        ];
                        if (isset($prepared['uuid'])) {
                            $pivotData['uuid'] = $prepared['uuid'];
                        }
                        $this->tourGuideLanguagePivotData[] = $pivotData;
                        Log::debug('Captured TourGuide Language pivot data: '.json_encode($pivotData));
                    }
                }
            }

            // Smart type_id lookup: if value is text, search by name/code, or create if not found
            // Also supports 'type' column as alias for 'type_id'
            // Handles both numeric IDs and text names
            if (in_array('type_id', $fillable)) {
                // Check if type_id exists in prepared data, otherwise try 'type' column from Excel
                $typeValue = null;

                if (! empty($prepared['type_id'])) {
                    $typeValue = $prepared['type_id'];
                } else {
                    // Try to find 'type' column in cleaned data (Excel might have 'type' instead of 'type_id')
                    foreach ($headerMap as $normKey => $origKey) {
                        if ($normKey === 'type' && isset($cleaned[$origKey])) {
                            $typeValue = $cleaned[$origKey];
                            Log::debug("Using 'type' column value for type_id: {$typeValue}");
                            break;
                        }
                    }
                }

                // Process the type value if it exists
                if (! empty($typeValue)) {
                    // If it's numeric, use it as ID directly
                    if (is_numeric($typeValue)) {
                        $prepared['type_id'] = (int) $typeValue;
                        Log::debug("Using numeric type_id: {$typeValue}");
                    } else {
                        // If it's text, search for it in the database
                        try {
                            $searchTerm = trim((string) $typeValue);
                            $cacheKey = 'type_' . md5(strtolower($searchTerm));

                            if (array_key_exists($cacheKey, $lookupCache)) {
                                $prepared['type_id'] = $lookupCache[$cacheKey];
                            } else {
                                // Try exact match first (name, name_ar)
                                $type = Type::where('name', $searchTerm)
                                    ->orWhere('name_ar', $searchTerm)
                                    ->first();

                                // If not found, try partial match
                                if (! $type) {
                                    $type = Type::where('name', 'LIKE', "%{$searchTerm}%")
                                        ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                        ->first();
                                }

                                // If still not found, create new type
                                if (! $type) {
                                    try {
                                        $type = Type::create(['name' => $searchTerm, 'name_ar' => $searchTerm]);
                                        Log::info("Created new type: '{$searchTerm}' with ID: {$type->id}");
                                    } catch (\Throwable $createError) {
                                        Log::warning("Failed to create new type '{$searchTerm}': ".$createError->getMessage());
                                        $prepared['type_id'] = null;
                                    }
                                }

                                if ($type) {
                                    $prepared['type_id'] = $type->id;
                                    $lookupCache[$cacheKey] = $type->id;
                                    Log::debug("Resolved type '{$searchTerm}' to ID: {$type->id} ({$type->name})");
                                } else {
                                    Log::warning("Could not resolve or create type: '{$searchTerm}' - setting to null");
                                    $prepared['type_id'] = null;
                                    $lookupCache[$cacheKey] = null;
                                }
                            }
                        } catch (\Throwable $e) {
                            Log::warning('Failed to resolve type: '.$e->getMessage());
                            $prepared['type_id'] = null;
                        }
                    }
                }
            }

            // Smart region_id lookup: if value is text, search by name
            if (in_array('region_id', $fillable) && ! empty($prepared['region_id'])) {
                $regionValue = $prepared['region_id'];

                if (! is_numeric($regionValue)) {
                    try {
                        $searchTerm = trim((string) $regionValue);
                        $cacheKey = 'region_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['region_id'] = $lookupCache[$cacheKey];
                        } else {
                            $region = Region::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                ->first();

                            if ($region) {
                                $prepared['region_id'] = $region->id;
                                $lookupCache[$cacheKey] = $region->id;
                                Log::debug("Resolved region '{$searchTerm}' to ID: {$region->id} ({$region->name})");
                            } else {
                                Log::warning("Could not resolve region: '{$searchTerm}' - setting to null");
                                $prepared['region_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve region: '.$e->getMessage());
                        $prepared['region_id'] = null;
                    }
                }
            }

            // Smart subregion_id lookup: if value is text, search by name
            if (in_array('subregion_id', $fillable) && ! empty($prepared['subregion_id'])) {
                $subregionValue = $prepared['subregion_id'];

                if (! is_numeric($subregionValue)) {
                    try {
                        $searchTerm = trim((string) $subregionValue);
                        $cacheKey = 'subregion_' . md5(strtolower($searchTerm));

                        if (array_key_exists($cacheKey, $lookupCache)) {
                            $prepared['subregion_id'] = $lookupCache[$cacheKey];
                        } else {
                            $subregion = Subregion::where('name', $searchTerm)
                                ->orWhere('name_ar', $searchTerm)
                                ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                                ->first();

                            if ($subregion) {
                                $prepared['subregion_id'] = $subregion->id;
                                $lookupCache[$cacheKey] = $subregion->id;
                                Log::debug("Resolved subregion '{$searchTerm}' to ID: {$subregion->id} ({$subregion->name})");
                            } else {
                                Log::warning("Could not resolve subregion: '{$searchTerm}' - setting to null");
                                $prepared['subregion_id'] = null;
                                $lookupCache[$cacheKey] = null;
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Failed to resolve subregion: '.$e->getMessage());
                        $prepared['subregion_id'] = null;
                    }
                }
            }

            $country = null;
            // Resolve country_id (text → id)
            if (in_array('country_id', $fillable) && ! empty($prepared['country_id'])) {
                try {
                    $countryValue = $prepared['country_id'];

                    if (is_numeric($countryValue)) {
                        $country = Country::find($countryValue);
                    } else {
                        $searchTerm = trim((string) $countryValue);

                        $country = Country::query()
                            ->where('name', $searchTerm)
                            ->orWhere('name_ar', $searchTerm)
                            ->orWhere('iso2', $searchTerm)
                            ->orWhere('iso3', $searchTerm)
                            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('name_ar', 'LIKE', "%{$searchTerm}%")
                            ->first();

                        if ($country) {
                            $prepared['country_id'] = $country->id;
                            Log::debug("Resolved country '{$searchTerm}' to ID {$country->id} ({$country->name})");
                        } else {
                            Log::warning("Could not resolve country '{$searchTerm}', setting country_id to null");
                            $prepared['country_id'] = null;
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('Country resolution failed: '.$e->getMessage());
                    $prepared['country_id'] = null;
                }
            }

            // Auto-fill region & subregion from resolved country
            if ($country) {
                if (in_array('region_id', $fillable) && empty($prepared['region_id']) && $country->region_id) {
                    $prepared['region_id'] = $country->region_id;
                    Log::debug("Auto-filled region_id from country: {$country->region_id}");
                }

                if (in_array('subregion_id', $fillable) && empty($prepared['subregion_id']) && $country->subregion_id) {
                    $prepared['subregion_id'] = $country->subregion_id;
                    Log::debug("Auto-filled subregion_id from country: {$country->subregion_id}");
                }
            }

            // Auto-fill country_id and state_id from city if not provided
            if (! empty($prepared['city_id']) && is_numeric($prepared['city_id'])) {
                try {
                    $city = City::find($prepared['city_id']);

                    // If country_id is missing, get it from city
                    if (in_array('country_id', $fillable) && empty($prepared['country_id'])) {
                        if ($city && $city->country_id) {
                            $prepared['country_id'] = $city->country_id;
                            Log::debug("Auto-filled country_id from city: {$city->country_id}");
                        }
                    }

                    // If state_id is missing, get it from city
                    if (in_array('state_id', $fillable) && empty($prepared['state_id'])) {
                        if ($city && $city->state_id) {
                            $prepared['state_id'] = $city->state_id;
                            Log::debug("Auto-filled state_id from city: {$city->state_id}");
                        }
                    }
                } catch (\Throwable $e) {
                    Log::debug('Failed to auto-fill country/state from city: '.$e->getMessage());
                }
            }

            // Auto-fill country_id from state if not provided (fallback)
            if (! empty($prepared['state_id']) && is_numeric($prepared['state_id']) && empty($prepared['country_id'])) {
                try {
                    if (in_array('country_id', $fillable)) {
                        $state = State::find($prepared['state_id']);
                        if ($state && $state->country_id) {
                            $prepared['country_id'] = $state->country_id;
                            Log::debug("Auto-filled country_id from state: {$state->country_id}");
                        }
                    }
                } catch (\Throwable $e) {
                    Log::debug('Failed to auto-fill country from state: '.$e->getMessage());
                }
            }

            // Log first prepared row as sample
            if ($rowIndex === 0 || $totalRows === 1) {
                Log::debug('ImportDataJob sample prepared row: '.json_encode($prepared));
            }

            // Coerce date-like columns (excel serial numbers or unparsable strings)
            foreach ($prepared as $kcol => $val) {
                if ($val === null) {
                    continue;
                }

                // Skip non-date columns that might be mistakenly identified as dates
                $skipColumns = ['price_type', 'contact_person', 'type', 'status', 'category'];
                if (in_array($kcol, $skipColumns)) {
                    continue;
                }

                if (isset($dateLikeColumns[$kcol])) {
                    // Excel serial numbers are integers (e.g. 44561)
                    if (is_numeric($val) && intval($val) == $val) {
                        try {
                            $serial = intval($val);
                            // Excel to Unix timestamp: ($serial - 25569) * 86400
                            $timestamp = ($serial - 25569) * 86400;
                            // guard against negative timestamps
                            if ($timestamp > 0) {
                                $prepared[$kcol] = \Carbon\Carbon::createFromTimestampUTC($timestamp)
                                    ->toDateTimeString();
                            } else {
                                $prepared[$kcol] = null;
                            }
                        } catch (\Throwable $e) {
                            $prepared[$kcol] = null;
                        }
                    } else {
                        // try parsing string dates robustly
                        try {
                            $prepared[$kcol] = \Carbon\Carbon::parse($val)
                                ->toDateTimeString();
                        } catch (\Throwable $e) {
                            // if parse fails, set null and log a debug entry
                            Log::debug("Failed to parse date for column {$kcol}: ".var_export($val, true));
                            $prepared[$kcol] = null;
                        }
                    }
                }
            }

            // Capture transportation company contact details for separate table
            if ($this->modelClass === Company::class) {
                $contactRow = TransportationDataImporter::extractContactData($prepared, $cleaned);
                if (! empty($contactRow)) {
                    $this->pendingTransportationContacts[] = $contactRow;
                }
            }

            // prevent duplicate primary-key insertion (CSV might contain `id` column)
            // UNLESS it's explicitly provided and we want to keep it.
            // We'll keep it in $prepared for now and handle it during insert/upsert.

            // debug: log the resolved fillable columns and primary key
            try {
                $resolvedPk = null;
                try {
                    $resolvedPk = $model->getKeyName();
                } catch (\Throwable $_) {
                    $resolvedPk = null;
                }
                Log::debug('ImportDataJob resolved fillable: '.implode(',', $fillable).' pk: '.($resolvedPk ?? 'NULL'));
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
                // and optionally 'id'/'uuid' if present in the Excel and DB.
                // handling BOM/encoding/whitespace variants via normalization.
                $sanitized = [];
                // We'll allow 'id' and 'uuid' if they exist in the DB columns
                $allowed = array_values(array_intersect(array_merge($fillable, ['id', 'uuid']), $dbColumns ?? []));

                $normPk = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                $normAllowed = [];
                foreach ($allowed as $a) {
                    $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
                }

                foreach ($buffer as $row) {
                    $filtered = [];
                    foreach ($row as $origKey => $value) {
                        $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));

                        // drop any primary key-like column (explicit id or model pk)
                        // EXCEPTION: if it's in $allowed, we KEEP it (it was added to $allowed in previous step)
                        if (($normKey === 'id' || ($normPk && $normKey === $normPk)) && ! in_array($origKey, $allowed, true)) {
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
                    if (! empty($sanitized)) {
                        Log::debug('Inserting chunk columns: '.implode(',', array_keys((array) $sanitized[0])));
                        Log::debug('Allowed columns for insert: '.implode(',', $allowed));
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
                        Log::debug('Final rows count before insert: '.count($finalRows));
                        if (! empty($finalRows)) {
                            Log::debug('Sample final row: '.json_encode($finalRows[0]));
                        }
                    } else {
                        $finalRows = [];
                    }

                    // Use service for transportation companies to handle duplicates
                    if ($this->modelClass === Company::class) {
                        $chunkUuidMap = null;
                        TransportationDataImporter::upsertCompanies($finalRows, $chunkUuidMap);
                        $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $chunkUuidMap ?? []);
                        $counter += count($finalRows);
                    } else {
                        // Extract columns that should be updated on duplicate (all allowed columns except UUID/ID)
                        $updateColumns = array_filter($allowed, fn ($col) => ! in_array($col, ['id', 'uuid']));

                        // Determine unique key for upsert
                        $uniqueBy = ['name'];
                        if (! empty($finalRows) && isset($finalRows[0]['id'])) {
                            $uniqueBy = ['id'];
                        } elseif (! empty($finalRows) && isset($finalRows[0]['uuid'])) {
                            $uniqueBy = ['uuid'];
                        } elseif ($this->modelClass === \Modules\TourGuides\Entities\TourGuideType::class && ! empty($finalRows) && isset($finalRows[0]['type'])) {
                            $uniqueBy = ['type'];
                        }

                        // Use upsert to insert new records and update existing ones for most models
                        // For TourGuide, bypass bulk upsert due to MySQL deadlock issues on multiple unique keys
                        if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                            throw new \Exception('Bypassing bulk upsert for TourGuide to prevent MySQL deadlocks. Using per-row fallback.');
                        }

                        $this->modelClass::upsert(
                            $finalRows,
                            $uniqueBy,
                            $updateColumns
                        );
                        $counter += count($finalRows);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Bulk insert failed, falling back to per-row inserts: '.$e->getMessage());
                    // notify error
                    try {
                        Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                    } catch (\Throwable $_) {
                        Log::debug('Failed to dispatch data-storage error message: '.$_->getMessage());
                    }
                    foreach ($sanitized as $r) {
                        try {
                            // Ensure single-row is filtered the same way as chunks
                            $filtered = [];
                            $normPkSingle = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
                            foreach ($r as $origKey => $value) {
                                $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                                // Keep 'id' if it's in $allowed (preserves Excel IDs for FK integrity)
                                if (($normKey === 'id' || ($normPkSingle && $normKey === $normPkSingle)) && ! in_array($origKey, $allowed ?? [], true)) {
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
                            Log::debug('Inserting single row columns: '.implode(',', array_keys((array) $filtered)));
                            if (! empty($filtered)) {
                                if ($this->modelClass === Company::class) {
                                    $rowUuidMap = null;
                                    TransportationDataImporter::upsertCompanies([$filtered], $rowUuidMap);
                                    $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $rowUuidMap ?? []);
                                } else {
                                    $updateCols = array_filter(array_keys($filtered), fn ($col) => ! in_array($col, ['id', 'uuid']));
                                    $uniqueKeyString = isset($filtered['id']) ? 'id' : (isset($filtered['uuid']) ? 'uuid' : (isset($filtered['type']) && $this->modelClass === \Modules\TourGuides\Entities\TourGuideType::class ? 'type' : 'name'));

                                // Safer fallback using updateOrCreate instead of upsert to avoid duplicate key locks
                                    $matchCondition = [$uniqueKeyString => $filtered[$uniqueKeyString]];
                                    
                                    $query = $this->modelClass::withoutGlobalScopes();
                                    if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($this->modelClass))) {
                                        $query = $query->withTrashed();
                                    }
                                    
                                    $this->modelClass::withoutEvents(function () use ($query, $matchCondition, $filtered, $updateCols) {
                                        $query->updateOrCreate(
                                            $matchCondition,
                                            \Illuminate\Support\Arr::only($filtered, $updateCols)
                                        );
                                    });
                                }
                                $counter++;
                            }
                        } catch (\Throwable $er) {
                            Log::warning('Skipping failing row during import: '.json_encode($r).' Error: '.$er->getMessage());
                        }
                    }
                }

                // broadcast progress update (non-blocking)
                try {
                    Event::dispatch(new ImportExportCompleted(__('main.import_progress', ['count' => number_format($counter)]), $this->userId));
                } catch (\Throwable $e) {
                    Log::warning('Failed to broadcast progress: '.$e->getMessage());
                }

                if ($this->historyUuid) {
                    try {
                        \App\Models\ImportHistory::where('uuid', $this->historyUuid)->update([
                            'processed_records' => $totalRows
                        ]);
                    } catch (\Throwable $e) {
                        Log::debug('Failed to update processed_records: '.$e->getMessage());
                    }
                }

                $buffer = [];
            }
        }

        // Final buffer handling for remaining rows
        // remaining
        if (! empty($buffer)) {
            // sanitize final buffer similar to chunk handling
            $pk = null;
            try {
                $pk = $model->getKeyName();
            } catch (\Throwable $_) {
                $pk = null;
            }

            // Strong sanitization for final buffer: same behavior as chunk handling
            $sanitized = [];
            // We'll allow 'id' and 'uuid' if they exist in the DB columns
            $allowed = array_values(array_intersect(array_merge($fillable, ['id', 'uuid']), $dbColumns ?? []));
            $normPk = $pk ? preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $pk))) : null;
            $normAllowed = [];
            foreach ($allowed as $a) {
                $normAllowed[$a] = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $a)));
            }

            foreach ($buffer as $row) {
                $filtered = [];
                foreach ($row as $origKey => $value) {
                    $normKey = preg_replace('/[^a-z0-9_]/u', '', mb_strtolower(trim((string) $origKey)));
                    // drop any primary key-like column (explicit id or model pk)
                    // EXCEPTION: if it's in $allowed, we KEEP it
                    if (($normKey === 'id' || ($normPk && $normKey === $normPk)) && ! in_array($origKey, $allowed, true)) {
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
                // if ($this->modelClass === Company::class) {
                //     // $this->modelClass::updateOrCreate($finalRows);
                //     $this->modelClass::updateOrCreate(['name' => $type['name']], $finalRows);
                // } else {

                // Use service for transportation companies to handle duplicates
                if ($this->modelClass === Company::class) {
                    $chunkUuidMap = null;
                    TransportationDataImporter::upsertCompanies($finalRows, $chunkUuidMap);
                    $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $chunkUuidMap ?? []);
                    $counter += count($finalRows);
                } else {
                    // Extract columns that should be updated on duplicate (all allowed columns except UUID/ID)
                    $updateColumnsFinal = array_filter($allowed, fn ($col) => ! in_array($col, ['id', 'uuid']));

                    // Determine unique key for upsert
                    $uniqueByFinal = ['name'];
                    if (! empty($finalRows) && isset($finalRows[0]['id'])) {
                        $uniqueByFinal = ['id'];
                    } elseif (! empty($finalRows) && isset($finalRows[0]['uuid'])) {
                        $uniqueByFinal = ['uuid'];
                    }

                    if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
                        throw new \Exception('Bypassing bulk upsert for TourGuide final chunk to prevent MySQL deadlocks.');
                    }

                    $this->modelClass::upsert(
                        $finalRows,
                        $uniqueByFinal,
                        $updateColumnsFinal
                    );
                    $counter += count($finalRows);
                }
                // }
            } catch (\Throwable $e) {
                Log::warning('Bulk insert failed on final chunk, falling back to per-row inserts: '.$e->getMessage());
                try {
                    Event::dispatch(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
                } catch (\Throwable $_) {
                    Log::debug('Failed to dispatch data-storage error message: '.$_->getMessage());
                }
                foreach ($sanitized as $r) {
                    try {
                        // Preserve 'id' from Excel for FK integrity — only remove if not in allowed
                        foreach (array_keys($r) as $k) {
                            $normKey = preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $k)));
                            // Only remove PK if it's NOT in the allowed list
                            if (! in_array($k, $allowed ?? [], true)) {
                                $normPk = $pk ? preg_replace('/[^a-z0-9_]/', '', strtolower(trim((string) $pk))) : null;
                                if (($normPk && $normKey === $normPk) || $normKey === 'id') {
                                    unset($r[$k]);

                                    continue;
                                }
                            }
                        }
                        if ($this->modelClass === Company::class) {
                            $rowUuidMap = null;
                            TransportationDataImporter::upsertCompanies([$r], $rowUuidMap);
                            $this->transportationCompanyUuidMap = array_merge($this->transportationCompanyUuidMap, $rowUuidMap ?? []);
                        } else {
                            $updateCols = array_filter(array_keys($r), fn ($col) => ! in_array($col, ['id', 'uuid']));
                            $uniqueKeyString = isset($r['id']) ? 'id' : (isset($r['uuid']) ? 'uuid' : 'name');

                            // Safer fallback using updateOrCreate instead of upsert to avoid duplicate key locks
                            $matchCondition = [$uniqueKeyString => $r[$uniqueKeyString]];
                            
                            $query = $this->modelClass::withoutGlobalScopes();
                            if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($this->modelClass))) {
                                $query = $query->withTrashed();
                            }
                            
                            $this->modelClass::withoutEvents(function () use ($query, $matchCondition, $r, $updateCols) {
                                $query->updateOrCreate(
                                    $matchCondition,
                                    \Illuminate\Support\Arr::only($r, $updateCols)
                                );
                            });
                        }
                        $counter++;
                    } catch (\Throwable $er) {
                        Log::warning('Skipping failing row during import (final chunk): '.json_encode($r).' Error: '.$er->getMessage());
                    }
                }
            }
        }

        if ($this->modelClass === Company::class) {
            TransportationDataImporter::processPendingContacts($this->pendingTransportationContacts, $this->transportationCompanyUuidMap);
            Log::debug('Transportation import completed: '.count($this->transportationCompanyUuidMap).' UUID mappings, '.count($this->pendingTransportationContacts).' contacts processed');
        }

        // Sync TourGuideType relationships (states and cities)
        if ($this->modelClass === \Modules\TourGuides\Entities\TourGuideType::class) {
            $this->syncTourGuideTypeRelationships();
        }

        // Sync TourGuide relationships (languages)
        if ($this->modelClass === \Modules\TourGuides\Entities\TourGuide::class) {
            $this->syncTourGuideLanguageRelationships();
        }

        // Log summary
        Log::debug("ImportDataJob completed: Total rows read: {$totalRows}, Records inserted: {$counter}");

        // Save statistics to import_settings
        try {
            \App\Models\ImportSetting::updateOrCreate(
                ['model_type' => $this->modelClass],
                [
                    'last_import_count' => $counter,
                    'last_imported_at' => now(),
                ]
            );

            // Update history
            if ($this->historyUuid) {
                \App\Models\ImportHistory::where('uuid', $this->historyUuid)->update([
                    'status' => 'completed',
                    'record_count' => $counter,
                    'processed_records' => $totalRows,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to save import statistics: '.$e->getMessage());
        }

        // Auto-sync relationships after importing specific models
        // $this->syncRelationshipsAfterImport($model);

        // استخراج اسم الموديل بشكل أنظف
        $modelName = class_basename($this->modelClass);
        $modelNamePlural = \Illuminate\Support\Str::plural(strtolower($modelName));
        $modelNameAr = __('main.'.$modelNamePlural);

        // إرسال رسالة نجاح مفصلة
        $message = __('main.import_completed_successfully', [
            'model' => $modelNameAr,
            'count' => number_format($counter),
        ]);

        // في حالة عدم وجود ترجمة، استخدم رسالة افتراضية
        if (str_contains($message, 'main.import_completed_successfully')) {
            $message = 'تم استيراد '.number_format($counter)." سجل من {$modelNameAr} بنجاح!";
        }

        try {
            Event::dispatch(new ImportExportCompleted($message, $this->userId));
        } catch (\Throwable $e) {
            Log::warning('Failed to broadcast completion: '.$e->getMessage());
        }
        // notify successful storage
        try {
            Event::dispatch(new DataStorageMessage('تم التخزين'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage success message: '.$e->getMessage());
        }
    }

    protected function upsertTransportationCompanies(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        try {
            // For transportation companies, use upsert based on name + country_id
            // This prevents duplicates with same name in same country
            foreach ($rows as $row) {
                // Build match criteria: name + country_id if country_id exists
                $matchCriteria = ['name' => $row['name'] ?? null];
                if (! empty($row['country_id'])) {
                    $matchCriteria['country_id'] = $row['country_id'];
                }

                // Filter out empty match criteria
                $matchCriteria = array_filter($matchCriteria, function ($v) {
                    return $v !== null && $v !== '';
                });

                if (empty($matchCriteria)) {
                    // If no match criteria, just insert
                    Company::create($row);

                    continue;
                }

                // Prepare update data (exclude match criteria)
                $updateData = array_diff_key($row, $matchCriteria);

                // Use updateOrCreate to handle duplicates
                Company::updateOrCreate(
                    $matchCriteria,
                    $updateData
                );

                Log::debug('Upserted transportation company with criteria: '.json_encode($matchCriteria));
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to upsert transportation companies: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Auto-sync many-to-many relationships after importing specific models
     */
    protected function syncRelationshipsAfterImport($model): void
    {
        try {
            $modelClass = get_class($model);
            $tableName = $model->getTable();

            // Handle Country model: sync states and cities based on country_id
            if ($modelClass === 'App\\Models\\Country' || $tableName === 'countries') {
                Log::info('Auto-syncing states and cities for imported countries...');

                $countries = Country::all();
                $syncedStates = 0;
                $syncedCities = 0;

                foreach ($countries as $country) {
                    // Sync states that belong to this country
                    $stateIds = State::where('country_id', $country->id)
                        ->pluck('id')
                        ->toArray();
                    if (! empty($stateIds)) {
                        $country->states()
                            ->sync($stateIds);
                        $syncedStates += count($stateIds);
                    }

                    // Sync cities that belong to states of this country
                    $cityIds = City::whereIn('state_id', $stateIds)
                        ->pluck('id')
                        ->toArray();
                    if (! empty($cityIds)) {
                        $country->cities()
                            ->sync($cityIds);
                        $syncedCities += count($cityIds);
                    }
                }

                Log::info("Auto-sync completed: {$syncedStates} states and {$syncedCities} cities synced to countries.");
            }

            // Add more model-specific sync logic here as needed
            // Example: if ($modelClass === 'App\\Models\\State') { ... }

        } catch (\Throwable $e) {
            Log::warning('Failed to auto-sync relationships: '.$e->getMessage());
        }
    }

    /**
     * Sync TourGuideType states and cities from imported data
     */
    protected function syncTourGuideTypeRelationships(): void
    {
        try {
            if (empty($this->tourGuideTypePivotData)) {
                Log::info('No TourGuideType pivot data to sync.');

                return;
            }

            Log::info('Syncing TourGuideType states and cities from import...');

            $syncedStates = 0;
            $syncedCities = 0;

            // Get all tour guide types ordered by ID (should match import order)
            $allTypes = \Modules\TourGuides\Entities\TourGuideType::orderBy('id')->get();

            foreach ($this->tourGuideTypePivotData as $pivotData) {
                // Find the TourGuideType by UUID, type name, or row index
                $type = null;

                if (! empty($pivotData['uuid'])) {
                    $type = \Modules\TourGuides\Entities\TourGuideType::where('uuid', $pivotData['uuid'])->first();
                }

                if (! $type && ! empty($pivotData['type'])) {
                    $type = \Modules\TourGuides\Entities\TourGuideType::where('type', $pivotData['type'])->first();
                }

                // Fallback: use row index to match (since records are inserted in order)
                if (! $type && isset($pivotData['row_index'])) {
                    $index = $pivotData['row_index'] - 1; // Convert to 0-based index
                    if (isset($allTypes[$index])) {
                        $type = $allTypes[$index];
                        Log::debug("Matched TourGuideType by row index: {$index}");
                    }
                }

                if (! $type) {
                    Log::warning('Could not find TourGuideType for pivot sync: '.json_encode($pivotData));

                    continue;
                }

                // Handle state_id
                if (! empty($pivotData['state_id'])) {
                    // Handle comma-separated IDs or single ID
                    $stateIds = is_string($pivotData['state_id'])
                        ? array_filter(array_map('trim', explode(',', $pivotData['state_id'])))
                        : [$pivotData['state_id']];
                    $stateIds = array_filter($stateIds, 'is_numeric');

                    if (! empty($stateIds)) {
                        $type->states()->sync($stateIds);
                        $syncedStates += count($stateIds);
                        Log::debug('Synced '.count($stateIds).' states ('.implode(',', $stateIds).") for TourGuideType ID: {$type->id}, Type: {$type->type}");
                    }
                }

                // Handle city_id
                if (! empty($pivotData['city_id'])) {
                    // Handle comma-separated IDs or single ID
                    $cityIds = is_string($pivotData['city_id'])
                        ? array_filter(array_map('trim', explode(',', $pivotData['city_id'])))
                        : [$pivotData['city_id']];
                    $cityIds = array_filter($cityIds, 'is_numeric');

                    if (! empty($cityIds)) {
                        $type->cities()->sync($cityIds);
                        $syncedCities += count($cityIds);
                        Log::debug('Synced '.count($cityIds).' cities ('.implode(',', $cityIds).") for TourGuideType ID: {$type->id}, Type: {$type->type}");
                    }
                }
            }

            Log::info("TourGuideType sync completed: {$syncedStates} state relationships and {$syncedCities} city relationships synced.");
        } catch (\Throwable $e) {
            Log::warning('Failed to sync TourGuideType relationships: '.$e->getMessage());
            Log::warning('Stack trace: '.$e->getTraceAsString());
        }
    }

    /**
     * Sync TourGuideLanguage languages from imported data
     */
    protected function syncTourGuideLanguageRelationships(): void
    {
        try {
            if (empty($this->tourGuideLanguagePivotData)) {
                Log::info('No TourGuideLanguage pivot data to sync.');

                return;
            }

            Log::info('Syncing TourGuideLanguage from import...');

            $syncedLanguages = 0;
            // Get all tour guides ordered by ID (should match import order roughly if new, or identifiable by uuid)
            $allGuides = \Modules\TourGuides\Entities\TourGuide::orderBy('id')->get();

            foreach ($this->tourGuideLanguagePivotData as $pivotData) {
                $guide = null;

                if (! empty($pivotData['uuid'])) {
                    $guide = \Modules\TourGuides\Entities\TourGuide::where('uuid', $pivotData['uuid'])->first();
                }

                // Fallback: use row index to match
                if (! $guide && isset($pivotData['row_index'])) {
                    $index = $pivotData['row_index'] - 1; // Convert to 0-based index
                    if (isset($allGuides[$index])) {
                        $guide = $allGuides[$index];
                    }
                }

                if (! $guide) {
                    Log::warning('Could not find TourGuide for language pivot sync: '.json_encode($pivotData));

                    continue;
                }

                if (! empty($pivotData['language_ids'])) {
                    $languageIds = array_filter($pivotData['language_ids'], 'is_numeric');
                    if (! empty($languageIds)) {
                        $guide->tourGuideLanguages()->delete(); // Clear old pivots to avoid duplicates
                        foreach ($languageIds as $langId) {
                            \Modules\TourGuides\Entities\TourGuideLanguage::create([
                                'tour_guide_id' => $guide->id,
                                'language_id' => $langId,
                            ]);
                        }
                        $syncedLanguages += count($languageIds);
                    }
                }
            }

            Log::info("TourGuideLanguage sync completed: {$syncedLanguages} language relationships synced.");
        } catch (\Throwable $e) {
            Log::warning('Failed to sync TourGuideLanguage relationships: '.$e->getMessage());
        }
    }

    public function failed(\Throwable $exception): void
    {
        if (isset($this->historyUuid) && $this->historyUuid) {
            \App\Models\ImportHistory::where('uuid', $this->historyUuid)->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
        }
    }
}
