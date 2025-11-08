<?php

namespace App\Listeners;

use App\Events\ImportExportCompleted;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NotifyUserAfterImport
{
    public function handle(ImportExportCompleted $event): void
    {
        // تخزين الرسالة في الـ Cache لمدة 5 دقائق
        $cacheKey = 'import_export_message_' . now()->timestamp;

        Cache::put($cacheKey, [
            'message' => $event->message,
            'type' => 'success',
            'timestamp' => now()->toDateTimeString(),
        ], now()->addMinutes(5));

        // إضافة المفتاح إلى قائمة الرسائل
        $messageKeys = Cache::get('import_export_keys', []);
        $messageKeys[] = $cacheKey;
        Cache::put('import_export_keys', $messageKeys, now()->addMinutes(5));

        // Dispatch event using event helper
        // event('show-toast', ['type' => 'success', 'message' => $event->message, 'title' => 'Success', 'emoji' => '✅']);

        Log::info('Import/Export completed: ' . $event->message);
    }
}