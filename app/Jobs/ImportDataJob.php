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
            // تنظيف البيانات: إزالة المسافات الزائدة وتحويل القيم الفارغة
            $row = array_map(function ($value) {
                if (is_string($value)) {
                    $value = trim($value);
                    // تحويل القيم الفارغة أو "null" إلى null حقيقي
                    if ($value === '' || strtolower($value) === 'null') {
                        return null;
                    }
                }
                return $value;
            }, $row);

            // خُد القيم فقط اللي الموديل بيسمح بيها (تجاهل الأعمدة الزائدة)
            $filtered = array_intersect_key($row, array_flip($fillable));

            // إضافة الأعمدة الناقصة بقيمة null
            foreach ($fillable as $column) {
                if (!array_key_exists($column, $filtered)) {
                    $filtered[$column] = null;
                }
            }

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

        event(new ImportExportCompleted($message));
    }
}