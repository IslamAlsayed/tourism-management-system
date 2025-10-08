<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\PhotoUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Settings\SettingsUpdateRequest;

class SettingsController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('pages.settings.index');
    }

    public function update(SettingsUpdateRequest $request, $id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            return redirect()->back()->with('error', __('main.messages.not_found_this_type', ['type' => __('main.settings')]));
        }
        $validated = $request->validated();
        $validated = $request->safe()->except(['app_light_photo', 'app_dark_photo', 'app_mini_photo']);

        $this->uploadPhoto($request, $setting, 'app_light_photo', "logos");
        $this->uploadPhoto($request, $setting, 'app_dark_photo', "logos");
        $this->uploadPhoto($request, $setting, 'app_mini_photo', "logos");

        $updated = $setting->update($validated);

        if ($updated) {
            return redirect()->back()->with('success', __('main.messages.type_updated', ['type' => __('main.settings')]));
        }

        return redirect()->back()->with('error', __('main.messages.type_update_failed', ['type' => __('main.settings')]));
    }

    public function general()
    {
        $settings = Setting::first();
        return view('pages.settings.general', compact('settings'));
    }

    public function security()
    {
        $settings = Setting::first();
        return view('pages.settings.security', compact('settings'));
    }

    public function notifications()
    {
        $settings = Setting::first();
        return view('pages.settings.notifications', compact('settings'));
    }

    public function backup()
    {
        $backupInfo = [
            'last_backup' => Cache::get('last_backup_date', __('main.messages.no_backup')),
            'backup_size' => $this->getBackupSize(),
            'auto_backup_enabled' => Cache::get('auto_backup_enabled', false),
            'backup_frequency' => Cache::get('backup_frequency', 'weekly'),
        ];

        $settings = Setting::first();
        return view('pages.settings.backup', compact('settings', 'backupInfo'));
    }

    public function createBackup()
    {
        // منطق إنشاء النسخة الاحتياطية
        $timestamp = now()->format('Y-m-d_H-i-s');

        // هنا يمكن إضافة منطق النسخ الاحتياطي الفعلي
        Cache::put('last_backup_date', now()->format('Y-m-d H:i:s'));

        return back()->with('success', 'تم إنشاء النسخة الاحتياطية بنجاح، ولكن تجربة وليس بشكل فعلي!');
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