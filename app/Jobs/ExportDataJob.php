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

    /**
     * @param string $modelClass  — full class path like App\Models\User::class
     * @param string|null $filename
     * @param int $chunkSize
     */
    public function __construct(string $modelClass, ?string $filename = null, int $chunkSize = 5000)
    {
        $this->modelClass = $modelClass;
        $this->filename = $filename
            ?? generateUniqueFilename(Str::snake(Str::plural(class_basename($modelClass))))
            . '.' . config('app.excel_export_format', 'xlsx');
        $this->chunkSize = $chunkSize;
    }

    public function handle(): void
    {
        $model = new $this->modelClass;
        if (!method_exists($model, 'getFillable')) {
            Log::error("Model {$this->modelClass} must have fillable attributes.");
            return;
        }
        $columns = $model->getFillable();
        if (empty($columns)) {
            Log::error("Model {$this->modelClass} has no fillable attributes defined.");
            return;
        }
        $folderName = Str::plural(strtolower(class_basename($this->modelClass)));
        $directory = "excels/exports/{$folderName}";
        Storage::disk('public')->makeDirectory($directory);
        $filePath = "{$directory}/{$this->filename}";
        $absolutePath = Storage::disk('public')->path($filePath);
        $writer = SimpleExcelWriter::create($absolutePath)->addHeader($columns);

        // notify start of storage
        try {
            event(new DataStorageMessage('سيتم تخزين البيانات'));
        } catch (\Throwable $e) {
            Log::debug('Failed to dispatch data-storage start message: ' . $e->getMessage());
        }

        try {
            $this->modelClass::query()->chunk($this->chunkSize, function ($records) use ($columns, $writer) {
                foreach ($records as $record) {
                    $row = [];
                    foreach ($columns as $column) {
                        $row[$column] = $record->$column ?? null;
                    }
                    $writer->addRow($row);
                }
            });
            $writer->close();

            // successful storage
            try {
                event(new DataStorageMessage('تم التخزين'));
            } catch (\Throwable $e) {
                Log::debug('Failed to dispatch data-storage success message: ' . $e->getMessage());
            }

            event(new ImportExportCompleted("Export completed for {$this->modelClass}. File saved to: {$filePath}"));
        } catch (\Throwable $e) {
            Log::error('Export failed: ' . $e->getMessage());
            try {
                event(new DataStorageMessage('حدث خطأ أثناء التخزين', $e->getMessage()));
            } catch (\Throwable $_) {
                Log::debug('Failed to dispatch data-storage error message: ' . $_->getMessage());
            }
        }
    }
}