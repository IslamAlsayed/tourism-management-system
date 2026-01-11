<?php

namespace App\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Events\ImportExportCompleted;
use App\Events\DataStorageMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected ?string $filename;
    protected int $chunkSize;
    protected array $hiddenColumns;
    protected bool $includeRelations;

    /**
     * @param string $modelClass  — full class path like App\Models\User::class
     * @param string|null $filename
     * @param int $chunkSize
     * @param array $hiddenColumns — columns to exclude from export (e.g., ['id', 'uuid'])
     * @param bool $includeRelations — whether to include relationship names in export
     */
    public function __construct(
        string $modelClass,
        ?string $filename = null,
        int $chunkSize = 5000,
        array $hiddenColumns = [],
        bool $includeRelations = true
    ) {
        $this->modelClass = $modelClass;
        $this->filename = $filename
            ?? generateUniqueFilename(Str::snake(Str::plural(class_basename($modelClass))))
            . '.' . config('app.excel_export_format', 'xlsx');
        $this->chunkSize = $chunkSize;
        $this->hiddenColumns = $hiddenColumns;
        $this->includeRelations = $includeRelations;
    }

    public function handle(): void
    {
        $model = new $this->modelClass;
        if (!method_exists($model, 'getFillable')) {
            Log::error("Model {$this->modelClass} must have fillable attributes.");
            return;
        }

        // Get fillable columns and filter out hidden ones
        $allColumns = $model->getFillable();
        $columns = array_values(array_filter($allColumns, function ($col) {
            return !in_array($col, $this->hiddenColumns);
        }));

        if (empty($columns)) {
            Log::error("Model {$this->modelClass} has no visible columns to export after filtering.");
            return;
        }

        // Get relationship names if method exists and includeRelations is true
        $relationNames = [];
        if ($this->includeRelations && method_exists($model, 'getRelationshipNames')) {
            try {
                $relationNames = $model->getRelationshipNames();
            } catch (\Throwable $e) {
                Log::debug('Failed to get relationship names: ' . $e->getMessage());
            }
        }

        // Prepare headers: only columns (no relationships)
        $headers = $columns;

        // Get casts to identify date columns
        $casts = method_exists($model, 'getCasts') ? $model->getCasts() : [];
        $dateColumns = [];
        foreach ($casts as $col => $type) {
            if (in_array($type, ['date', 'datetime', 'timestamp']) || str_starts_with($type, 'datetime:')) {
                $dateColumns[] = $col;
            }
        }

        // Also check common date column names
        $commonDateColumns = ['created_at', 'updated_at', 'deleted_at', 'date', 'applicable_date', 'start_date', 'end_date', 'season_date', 'season_date', 'birth_date', 'expiry_date'];
        foreach ($columns as $col) {
            if (in_array($col, $commonDateColumns) || str_ends_with($col, '_at') || str_ends_with($col, '_date')) {
                if (!in_array($col, $dateColumns)) {
                    $dateColumns[] = $col;
                }
            }
        }

        $folderName = Str::plural(strtolower(class_basename($this->modelClass)));
        $directory = "excels/exports/{$folderName}";
        Storage::disk('public')->makeDirectory($directory);
        $filePath = "{$directory}/{$this->filename}";
        $absolutePath = Storage::disk('public')->path($filePath);

        // Create writer and add simple header
        $writer = SimpleExcelWriter::create($absolutePath)->addHeader($headers);

        // Identify HTML columns (description, notes, etc.)
        $htmlColumns = array_filter($columns, function ($col) {
            return in_array($col, ['description', 'notes', 'content', 'body', 'details']);
        });

        // notify start of storage
        try {
            event(new DataStorageMessage('سيتم تخزين البيانات'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage start message: ' . $e->getMessage());
        }

        try {
            $totalRecords = 0;
            $query = $this->modelClass::query();

            $query->chunk($this->chunkSize, function ($records) use ($columns, $writer, &$totalRecords, $htmlColumns, $dateColumns) {
                foreach ($records as $record) {
                    $row = [];

                    // Add column values in exact order of headers
                    foreach ($columns as $column) {
                        $value = $record->$column ?? null;

                        // Convert arrays to comma-separated string
                        if (is_array($value)) {
                            $value = implode(', ', array_map('strval', $value));
                        }

                        // Convert objects to string
                        if (is_object($value)) {
                            // Try to convert to string (handles rich text objects, etc.)
                            $value = (string) $value;
                        }

                        // Format date/datetime columns
                        if (in_array($column, $dateColumns) && !empty($value)) {
                            try {
                                if ($value instanceof \Carbon\Carbon || $value instanceof \DateTime) {
                                    // Check if it's datetime or just date
                                    if ($value instanceof \Carbon\Carbon && $value->format('H:i:s') === '00:00:00') {
                                        $value = $value->format('Y-m-d');
                                    } else {
                                        $value = $value->format('Y-m-d H:i:s');
                                    }
                                } elseif (is_string($value)) {
                                    // Try to parse string dates
                                    $date = \Carbon\Carbon::parse($value);
                                    if ($date->format('H:i:s') === '00:00:00') {
                                        $value = $date->format('Y-m-d');
                                    } else {
                                        $value = $date->format('Y-m-d H:i:s');
                                    }
                                }
                            } catch (\Throwable $e) {
                                // Keep original value if parsing fails
                            }
                        }

                        // Clean HTML from specific columns
                        if (in_array($column, $htmlColumns) && !empty($value)) {
                            // Strip HTML tags and decode entities
                            $value = strip_tags($value);
                            $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            // Remove extra whitespace
                            $value = preg_replace('/\s+/', ' ', $value);
                            $value = trim($value);
                        }

                        // Format model_type column: App\Models\Accommodation -> accommodation
                        if ($column === 'model_type' && !empty($value) && is_string($value)) {
                            // Extract class name from full namespace
                            if (str_contains($value, '\\')) {
                                $value = strtolower(class_basename($value));
                            }
                        }

                        $row[] = $value;
                    }

                    $writer->addRow($row);
                    $totalRecords++;
                }
            });

            $writer->close();

            // Apply column width formatting using PhpSpreadsheet
            $this->formatExcelFile($absolutePath, count($headers));

            Log::info("Export completed: {$totalRecords} records exported for {$this->modelClass}");

            // successful storage
            try {
                event(new DataStorageMessage('تم التخزين'));
            } catch (\Throwable $e) {
                Log::debug('Failed to dispatch data-storage success message: ' . $e->getMessage());
            }

            event(new ImportExportCompleted("Export completed for {$this->modelClass}. {$totalRecords} records saved to: {$filePath}"));
        } catch (\Throwable $e) {
            Log::error('Export failed: ' . $e->getMessage());
            try {
                event(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
            } catch (\Throwable $_) {
                Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
            }
        }
    }

    /**
     * Format Excel file with proper column widths and styling
     */
    protected function formatExcelFile(string $filePath, int $columnCount): void
    {
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            // Style header row (row 1)
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'], // Professional blue
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];

            $sheet->getStyle('1:1')->applyFromArray($headerStyle);
            $sheet->getRowDimension(1)->setRowHeight(25);

            // Auto-size all columns
            for ($col = 1; $col <= $columnCount; $col++) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
            }

            // Set minimum and maximum column widths
            foreach ($sheet->getColumnIterator() as $column) {
                $columnLetter = $column->getColumnIndex();
                $calculatedWidth = $sheet->getColumnDimension($columnLetter)->getWidth();

                // Set minimum width of 12 and maximum width of 60
                if ($calculatedWidth < 12) {
                    $sheet->getColumnDimension($columnLetter)->setWidth(12);
                } elseif ($calculatedWidth > 60) {
                    $sheet->getColumnDimension($columnLetter)->setWidth(60);
                }
            }

            // Enable text wrapping for all data cells (not header)
            $lastRow = $sheet->getHighestRow();
            if ($lastRow > 1) {
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $lastRow)
                    ->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            }

            // Freeze first row (header)
            $sheet->freezePane('A2');

            // Add filter to header row
            $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

            // Save formatted file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($filePath);

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

        } catch (\Throwable $e) {
            Log::warning('Failed to format Excel file: ' . $e->getMessage());
        }
    }
}