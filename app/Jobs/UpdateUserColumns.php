<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateUserColumns implements ShouldQueue
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
                $hasCreatedBy = Schema::hasColumn($tableName, 'created_by');
                $hasUpdatedBy = Schema::hasColumn($tableName, 'updated_by');

                if ($hasCreatedBy || $hasUpdatedBy) {
                    $updateData = [];

                    if ($hasCreatedBy) {
                        $updateData['created_by'] = 2;
                    }

                    if ($hasUpdatedBy) {
                        $updateData['updated_by'] = 2;
                    }

                    if (!empty($updateData)) {
                        DB::table($tableName)->update($updateData);
                        Log::info("✓ تم تحديث أعمدة المستخدم في جدول: {$tableName}");
                    }
                }
            } catch (\Exception $e) {
                Log::warning("✗ خطأ في تحديث جدول {$tableName}: " . $e->getMessage());
            }
        }

        Log::info("✓ تم إكمال تحديث كل أعمدة المستخدم في قاعدة البيانات");
    }
}
