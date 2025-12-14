<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasSearch, HasUuid;

    protected $fillable = [
        'id',
        'uuid',
        'app_name',
        'app_url',
        'app_timezone',
        'app_language',
        'app_version',
        'app_php_version',
        'app_columns_length',
        'photo',
        'app_status',
        'app_minimum_password_length',
        'app_session_lifetime',
        'app_password_confirmation',
        'app_two_factor_authentication',
        'app_backup_frequency',
        'app_auto_backup',
        // Ably Settings
        'app_ably_key',
        'app_email_notifications',
        'app_push_notifications',
        'app_sms_notifications',
        'app_notifications_new_record',
        'app_notifications_data_updates',
        'app_notifications_data_deletes',
        'app_notifications_system_reports',
        'app_notifications_security_updates',
        'app_paginate_count',
        // Google Maps Settings
        'app_google_maps_key',
        // Booking Settings
        'app_free_cancellation_days',
        'app_min_advance_booking_days',
        'app_default_currency',
        'app_default_tax_rate',
        'app_service_fee_percentage',
        // Payment Settings
        'app_minimum_deposit_percentage',
        'app_payment_grace_period_days',
        // Display Settings
        'app_new_deals_duration_days',
        'app_smart_search_enabled',
        // Security Settings
        'app_max_login_attempts',
        'app_ip_ban_duration_minutes',
        // Activity Log Settings
        'app_activity_log_enabled',
        'app_activity_log_retention_days',
        // Maintenance Mode
        'app_maintenance_mode',
        'app_maintenance_message',
        // SMTP Settings
        'app_smtp_host',
        'app_smtp_port',
        'app_smtp_username',
        'app_smtp_password',
        'app_sidebar_width',
        'app_show_uuid_column',
    ];
}