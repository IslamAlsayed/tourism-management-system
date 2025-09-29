<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::truncate();

        Setting::create([
            'app_name' => env('APP_NAME', 'laravel'),
            'app_url' => env('APP_URL', 'http://localhost'),
            'app_timezone' => env('APP_TIMEZONE', 'Africa/Cairo'),
            'app_language' => env('APP_LOCALE', 'en'),
            'app_version' => app()->version(),
            'app_php_version' => PHP_VERSION,
            'app_status' => env('APP_STATUS', true),
            'app_password_length' => env('APP_PASSWORD_LENGTH', 8),
            'app_session_lifetime' => env('SESSION_LIFETIME', 120),
            'app_password_confirmation' => true,
            'app_two_factor_authentication' => false,
            'app_backup_frequency' => 'weekly',
            'app_email_notifications' => false,
            'app_sms_notifications' => false,
            'app_push_notifications' => false,
            'app_notifications_new_user' => false,
            'app_notifications_data_update' => false,
            'app_notifications_system_report' => false,
            'app_notifications_security_update' => false,
        ]);
    }
}