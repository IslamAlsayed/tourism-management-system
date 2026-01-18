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
            'app_minimum_password_length' => env('APP_MINIMUM_PASSWORD_LENGTH', 8),
            'app_session_lifetime' => env('SESSION_LIFETIME', 120),
            'app_password_confirmation' => true,
            'app_two_factor_authentication' => false,
            'app_backup_frequency' => 'weekly',
            'app_ably_key' => 'YfoutQ.0ANKLQ:l9mrZvEjJGo07yZsKnU8XU33MkgnlX9k7JfmsQUKJe4', // islam's key
            'app_google_maps_key' => 'AIzaSyBPeqtH6bhY7Keyhj10E9IAO2j6siQLBoU', // islam's key
            'app_email_notifications' => true,
            'app_sms_notifications' => false,
            'app_push_notifications' => true,
            'app_notifications_new_record' => true,
            'app_notifications_data_updates' => true,
            'app_notifications_data_deletes' => true,
            'app_notifications_system_reports' => false,
            'app_notifications_security_updates' => false,
        ]);
    }
}