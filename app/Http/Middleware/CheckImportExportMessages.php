<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckImportExportMessages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من وجود رسائل مكتملة
        $messageKeys = Cache::get('import_export_keys', []);

        if (!empty($messageKeys)) {
            foreach ($messageKeys as $key) {
                $messageData = Cache::get($key);

                if ($messageData) {
                    // إضافة الرسالة إلى الـ session
                    session()->flash('success', $messageData['message']);

                    // حذف الرسالة من الـ Cache
                    Cache::forget($key);
                }
            }

            // تنظيف قائمة المفاتيح
            Cache::forget('import_export_keys');
        }

        return $next($request);
    }
}
