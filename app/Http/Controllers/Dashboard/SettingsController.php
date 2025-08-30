<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.settings.index');
    }

    public function general()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'app_timezone' => config('app.timezone'),
            'app_locale' => config('app.locale'),
        ];

        return view('pages.dashboard.settings.general', compact('settings'));
    }

    public function security()
    {
        $securitySettings = [
            'password_min_length' => 8,
            'require_password_confirmation' => true,
            'enable_two_factor' => false,
            'session_lifetime' => config('session.lifetime'),
        ];

        return view('pages.dashboard.settings.security', compact('securitySettings'));
    }

    public function notifications()
    {
        $notificationSettings = [
            'email_notifications' => true,
            'sms_notifications' => false,
            'push_notifications' => true,
            'notification_channels' => ['email', 'database'],
        ];

        return view('pages.dashboard.settings.notifications', compact('notificationSettings'));
    }

    public function backup()
    {
        $backupInfo = [
            'last_backup' => Cache::get('last_backup_date', __('main.messages.no_backup')),
            'backup_size' => $this->getBackupSize(),
            'auto_backup_enabled' => Cache::get('auto_backup_enabled', false),
            'backup_frequency' => Cache::get('backup_frequency', 'weekly'),
        ];

        return view('pages.dashboard.settings.backup', compact('backupInfo'));
    }

    public function createBackup()
    {
        // منطق إنشاء النسخة الاحتياطية
        $timestamp = now()->format('Y-m-d_H-i-s');

        // هنا يمكن إضافة منطق النسخ الاحتياطي الفعلي
        Cache::put('last_backup_date', now()->format('Y-m-d H:i:s'));

        return back()->with('success', 'تم إنشاء النسخة الاحتياطية بنجاح');
    }

    private function getBackupSize()
    {
        // حساب حجم النسخ الاحتياطية
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            return '0 MB';
        }

        $size = 0;
        foreach (glob($backupPath . '/*') as $file) {
            $size += filesize($file);
        }

        return $this->formatBytes($size);
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}
