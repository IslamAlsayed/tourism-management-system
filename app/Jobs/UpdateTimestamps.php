<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateTimestamps implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // الحصول على كل الجداول في قاعدة البيانات
        $tables = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()");

        foreach ($tables as $table) {
            $tableName = $table->TABLE_NAME;

            try {
                // التحقق من وجود الأعمدة
                $hasCreatedAt = Schema::hasColumn($tableName, 'created_at');
                $hasUpdatedAt = Schema::hasColumn($tableName, 'updated_at');

                if ($hasCreatedAt || $hasUpdatedAt) {
                    $updateData = [];

                    if ($hasCreatedAt) {
                        $updateData['created_at'] = now();
                    }

                    if ($hasUpdatedAt) {
                        $updateData['updated_at'] = now();
                    }

                    if (!empty($updateData)) {
                        DB::table($tableName)->update($updateData);
                        Log::info("✓ تم تحديث أعمدة الوقت في جدول: {$tableName}");
                    }
                }
            } catch (\Exception $e) {
                Log::warning("✗ خطأ في تحديث جدول {$tableName}: " . $e->getMessage());
            }
        }

        Log::info("✓ تم إكمال تحديث كل الأعمدة في قاعدة البيانات");
    }
}
