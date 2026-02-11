<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

trait ExportsData
{
    public array $selectedIds = [];
    public bool $selectPage = false;
    public array $selectedActivity = [];

    /**
     * Export selected model records to PDF.
     *
     * @param array $selectedIds
     * @param string $modelClass — full class name (e.g. Modules\Core\Entities\User::class)
     * @param array|null $columns — columns to include (keys order). If null uses model fillable.
     * @param string|null $filenamePrefix
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|null
     */
    public function exportSelectedPdfForModel(array $selectedIds, string $modelClass, ?array $columns = null, ?string $filenamePrefix = null)
    {
        try {
            if (empty($selectedIds)) {
                // try to notify caller (Livewire) if available
                if (method_exists($this, 'dispatch')) {
                    $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.no_records_selected')]);
                    return null;
                }
                session()->flash('error', __('messages.no_records_selected'));
                return null;
            }

            $model = new $modelClass;

            // determine columns
            if (empty($columns)) {
                if (method_exists($model, 'getFillable')) {
                    $columns = $model->getFillable();
                } else {
                    // fallback to common attributes
                    $columns = ['id'];
                }
            }

            $rows = $modelClass::whereIn('id', $selectedIds)->get(['*']);

            // filename
            $prefix = $filenamePrefix ?: Str::snake(Str::plural(class_basename($modelClass)));
            $filename = generateUniqueFilename($prefix) . '.pdf';

            // choose orientation and font size based on column count to avoid overflow
            $colCount = is_array($columns) ? count($columns) : 0;
            $orientation = $colCount > 6 ? 'landscape' : 'portrait';
            // reduce font size when many columns
            if ($colCount > 12) {
                $fontSize = 7;
            } elseif ($colCount > 8) {
                $fontSize = 8;
            } elseif ($colCount > 6) {
                $fontSize = 9;
            } else {
                $fontSize = 11;
            }

            // render PDF
            $pdf = PDF::loadView('exports.generic_pdf', [
                'title' => __(Str::plural(class_basename($modelClass))),
                'columns' => $columns,
                'rows' => $rows,
                'fontSize' => $fontSize,
            ])->setPaper('a4', $orientation);

            // storage
            $folderName = Str::plural(strtolower(class_basename($modelClass)));
            $directory = "pdfs/exports/{$folderName}";
            Storage::disk('public')->makeDirectory($directory);
            $filePath = "{$directory}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            $pdf->save($absolutePath);

            if (file_exists($absolutePath)) {
                return response()->download($absolutePath, $filename, ['Content-Type' => 'application/pdf']);
            }

            if (method_exists($this, 'dispatch')) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.operation_failed')]);
                return null;
            }

            session()->flash('error', __('messages.operation_failed'));
            return null;
        } catch (\Throwable $e) {
            Log::error('Export PDF failed: ' . $e->getMessage());
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.operation_failed') . ' ' . $e->getMessage(), 'pin' => 'pin']);
                return null;
            }

            session()->flash('error', __('messages.operation_failed'));
            return null;
        }
    }

    /**
     * Export selected model records to Excel/CSV.
     * @param array $selectedIds
     * @param string $modelClass — full class name (
     * @param array|null $columns — columns to include (keys order). If null uses model fillable.
     * @param string|null $filenamePrefix
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|null
     */
    public function exportSelectedExcelForModel(array $selectedIds, string $modelClass, ?array $columns = null, ?string $filenamePrefix = null, string $extension = 'csv')
    {
        // Normalize selected IDs
        $selectedIds = is_array($selectedIds) ? $selectedIds : (array) $selectedIds;
        $selectedIds = array_values(array_filter(array_map('trim', $selectedIds), function ($v) {
            return $v !== '' && $v !== null;
        }));
        $selectedIds = array_map('intval', $selectedIds);
        $selectedIds = array_values(array_filter($selectedIds, function ($v) {
            return $v > 0;
        }));

        if (empty($selectedIds)) {
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.no_records_selected')]);
                return null;
            }
            session()->flash('error', __('messages.no_records_selected'));
            return null;
        }

        // prepare filename
        $filename = generateUniqueFilename($filenamePrefix) . '.' . $extension;

        try {
            $model = new $modelClass;

            // determine columns
            if (empty($columns)) {
                if (method_exists($model, 'getFillable')) {
                    $columns = $model->getFillable();
                } else {
                    $columns = ['id'];
                }
            }

            // Normalize keys (support ['a','b'] or ['a' => 'Label'])
            $colKeys = [];
            $colLabels = [];
            foreach ($columns as $k => $v) {
                if (is_int($k)) {
                    $colKeys[] = $v;
                    $colLabels[] = __('main.' . $v) === 'main.' . $v ? ucfirst(str_replace('_', ' ', $v)) : __('main.' . $v);
                } else {
                    $colKeys[] = $k;
                    $colLabels[] = $v;
                }
            }

            $folderName = Str::plural(strtolower(class_basename($modelClass)));
            $directory = "excels/exports/{$folderName}";
            Storage::disk('public')->makeDirectory($directory);
            $filePath = "{$directory}/{$filename}";
            $absolutePath = Storage::disk('public')->path($filePath);

            // Create writer and add header (use labels for header)
            $writer = \Spatie\SimpleExcel\SimpleExcelWriter::create($absolutePath)->addHeader($colLabels);

            // Fetch only selected rows and write them
            $query = $modelClass::whereIn('id', $selectedIds);
            $rows = $query->get();
            foreach ($rows as $row) {
                $out = [];
                foreach ($colKeys as $ck) {
                    $val = data_get($row, $ck);
                    if ($val instanceof \Illuminate\Support\Collection) {
                        $cell = $val->pluck('name')->filter()->implode(', ');
                        if ($cell === '') {
                            $cell = $val->pluck('title')->filter()->implode(', ');
                        }
                        if ($cell === '') {
                            $cell = $val->pluck('id')->filter()->implode(', ');
                        }
                    } elseif (is_object($val)) {
                        if (isset($val->name) && $val->name !== null) {
                            $cell = $val->name;
                        } elseif (isset($val->title) && $val->title !== null) {
                            $cell = $val->title;
                        } else {
                            $cell = (string) $val;
                        }
                    } else {
                        $cell = $val;
                    }
                    $out[] = $cell;
                }
                $writer->addRow($out);
            }
            $writer->close();

            if (file_exists($absolutePath)) {
                return response()->download($absolutePath, $filename, [
                    'Content-Type' => $extension == 'csv' ? 'text/csv' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ]);
            }

            if (method_exists($this, 'dispatch')) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.operation_failed')]);
                return null;
            }
            session()->flash('error', __('messages.operation_failed'));
            return null;
        } catch (\Throwable $e) {
            Log::error('Export failed: ' . $e->getMessage());
            if (method_exists($this, 'dispatch')) {
                $this->dispatch('show-toast', ['type' => 'error', 'message' => __('messages.operation_failed') . ' ' . $e->getMessage(), 'pin' => 'pin']);
                return null;
            }
            session()->flash('error', __('messages.operation_failed'));
            return null;
        }
    }
}
