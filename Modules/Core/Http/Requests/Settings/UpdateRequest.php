<?php

namespace Modules\Core\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the setting is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => ['nullable', 'string'],
            'app_url' => ['nullable', 'url'],
            'app_timezone' => ['nullable', 'string'],
            'app_language' => ['nullable', 'string'],
            'app_version' => ['nullable', 'string'],
            'app_php_version' => ['nullable', 'string'],
            'app_columns_length' => ['nullable', 'integer'],
            'app_light_photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
            'app_dark_photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
            'app_mini_photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg,ico'],
            'app_status' => ['nullable', 'boolean'],
            'app_minimum_password_length' => ['nullable', 'integer', 'min:' . config('app.app_minimum_password_length', 8), 'max:' . config('app.app_minimum_password_length', 8)],
            'app_session_lifetime' => [
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    $user = getActiveUser();

                    // Admin and superadmin can set any value: 0 (unlimited/one year) or any duration
                    if (in_array($user->role, ['superadmin', 'admin'])) {
                        return;
                    }

                    // Regular users: must be 0 (unlimited) or >= 5 minutes
                    if ($value < 5) {
                        $fail(__('messages.session_lifetime_min_5'));
                    }
                },
            ],
            'app_password_confirmation' => ['nullable', 'boolean'],
            'app_two_factor_authentication' => ['nullable', 'boolean'],
            'app_backup_frequency' => ['nullable', 'string', 'in:daily,weekly,monthly'],
            'app_auto_backup' => ['nullable', 'boolean'],
            'app_ably_key' => ['nullable', 'string'],
            'app_email_notifications' => ['nullable', 'boolean'],
            'app_sms_notifications' => ['nullable', 'boolean'],
            'app_push_notifications' => ['nullable', 'boolean'],
            'app_notifications_new_record' => ['nullable', 'boolean'],
            'app_notifications_data_updates' => ['nullable', 'boolean'],
            'app_notifications_data_deletes' => ['nullable', 'boolean'],
            'app_notifications_system_reports' => ['nullable', 'boolean'],
            'app_notifications_security_updates' => ['nullable', 'boolean'],
            'app_paginate_count' => ['nullable', 'integer', 'min:1'],
            'app_free_cancellation_days' => ['nullable', 'integer', 'min:0'],
            'app_min_advance_booking_days' => ['nullable', 'integer', 'min:0'],
            'app_default_currency' => ['nullable', 'string'],
            'app_default_tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'app_service_fee_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'app_minimum_deposit_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'app_payment_grace_period_days' => ['nullable', 'integer', 'min:0'],
            'app_new_deals_duration_days' => ['nullable', 'integer', 'min:0'],
            'app_smart_search_enabled' => ['nullable', 'boolean'],
            'app_max_login_attempts' => ['nullable', 'integer', 'min:1'],
            'app_ip_ban_duration_minutes' => ['nullable', 'integer', 'min:0'],
            'app_activity_log_enabled' => ['nullable', 'boolean'],
            'app_activity_log_retention_days' => ['nullable', 'integer', 'min:0'],
            'app_maintenance_mode' => ['nullable', 'boolean'],
            'app_maintenance_message' => ['nullable', 'string'],
            'app_google_maps_key' => ['nullable', 'string'],
            'app_smtp_host' => ['nullable', 'string'],
            'app_smtp_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'app_smtp_username' => ['nullable', 'string'],
            'app_smtp_password' => ['nullable', 'string'],
            'app_sidebar_width' => ['nullable', 'integer', 'min:100'],
            'app_show_uuid_column' => ['nullable', 'boolean'],
            'app_display_menu_labels' => ['nullable', 'boolean'],
        ];
    }
}
