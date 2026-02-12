<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Entities\Setting;
use Modules\Core\Entities\User;
use Modules\Core\Http\Requests\Settings\UpdateRequest;

class SettingController extends Controller
{
    public function index()
    {
        return view('core::settings.index');
    }

    public function update(UpdateRequest $request, $id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.settings')]));
        }
        $validated = $request->validated();
        $validated = $request->safe()->except(['app_light_photo', 'app_dark_photo', 'app_mini_photo']);

        if ($request->has('app_light_photo')) {
            $this->uploadPhoto($request, $setting, 'app_light_photo', "logos");
        }
        if ($request->has('app_dark_photo')) {
            $this->uploadPhoto($request, $setting, 'app_dark_photo', "logos");
        }
        if ($request->has('app_mini_photo')) {
            $this->uploadPhoto($request, $setting, 'app_mini_photo', "logos");
        }

        $updated = $setting->update($validated);

        // Update user preferences if button_display_mode is sent
        if ($request->has('button_display_mode')) {
            $user = getActiveUser();
            $user->button_display_mode = $request->button_display_mode;
            $user->save();
        }

        if ($updated) {
            return redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.settings')]));
        }

        return redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.settings')]));
    }

    public function general()
    {
        $settings = Setting::first();
        return view('core::settings.general', compact('settings'));
    }

    public function security()
    {
        $settings = Setting::first();
        return view('core::settings.security', compact('settings'));
    }

    public function notifications()
    {
        $settings = Setting::first();
        return view('core::settings.notifications', compact('settings'));
    }

    public function backup()
    {
        $backupInfo = [
            'last_backup' => Cache::get('last_backup_date', __('messages.no_backup')),
            'backup_size' => $this->getBackupSize(),
            'auto_backup_enabled' => Cache::get('auto_backup_enabled', false),
            'backup_frequency' => Cache::get('backup_frequency', 'weekly'),
        ];

        $settings = Setting::first();
        return view('core::settings.backup', compact('settings', 'backupInfo'));
    }

    public function booking()
    {
        $settings = Setting::first();
        return view('core::settings.booking', compact('settings'));
    }

    public function integration()
    {
        $settings = Setting::first();
        $users = User::orderBy('name')->get(['name', 'email', 'id']);
        return view('core::settings.integration', compact('settings', 'users'));
    }

    public function system()
    {
        $settings = Setting::first();
        return view('core::settings.system', compact('settings'));
    }

    public function createBackup()
    {
        // منطق إنشاء النسخة الاحتياطية
        $timestamp = now()->format('Y-m-d_H-i-s');

        // هنا يمكن إضافة منطق النسخ الاحتياطي الفعلي
        Cache::put('last_backup_date', now()->format('Y-m-d H:i:s'));

        return back()->withSuccess(__('messages.backup_created_test'));
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
