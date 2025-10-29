<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Events\ImportExportCompleted;
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
    protected int $chunkSize;

    public function __construct(string $modelClass, string $filePath, int $chunkSize = 1000)
    {
        $this->modelClass = $modelClass;
        $this->filePath = $filePath;
        $this->chunkSize = $chunkSize;
    }

    public function handle(): void
    {
        $model = new $this->modelClass;

        if (!method_exists($model, 'getFillable')) {
            Log::error("Model {$this->modelClass} must have fillable attributes.");
            return;
        }

        $fillable = $model->getFillable();

        // اقرأ الملف كـ stream (بدون تحميل كل البيانات مرة واحدة)
        $rows = SimpleExcelReader::create($this->filePath)->getRows();

        $buffer = [];
        $counter = 0;

        foreach ($rows as $row) {
            // خُد القيم فقط اللي الموديل بيسمح بيها
            $filtered = array_intersect_key($row, array_flip($fillable));
            $buffer[] = $filtered;

            if (count($buffer) >= $this->chunkSize) {
                $this->modelClass::insert($buffer);
                $counter += count($buffer);
                $buffer = [];
            }
        }

        // باقي البيانات بعد آخر دفعة
        if (!empty($buffer)) {
            $this->modelClass::insert($buffer);
            $counter += count($buffer);
        }

        event(new ImportExportCompleted("Import completed for {$this->modelClass}. Total records imported: {$counter}"));
    }
}