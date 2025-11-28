<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingsCreateRequest extends FormRequest
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
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'app_status' => ['nullable', 'boolean'],
            'app_minimum_password_length' => ['nullable', 'integer', 'min:' . config('app.app_minimum_password_length', 8), 'max:' . config('app.app_minimum_password_length', 8)],
            'app_session_lifetime' => ['nullable', 'integer'],
            'app_password_confirmation' => ['nullable', 'boolean'],
            'app_two_factor_authentication' => ['nullable', 'boolean'],
            'app_backup_frequency' => ['nullable', 'string', 'in:daily,weekly,monthly'],
            'app_auto_backup' => ['nullable', 'boolean'],
            'app_email_notifications' => ['nullable', 'boolean'],
            'app_sms_notifications' => ['nullable', 'boolean'],
            'app_push_notifications' => ['nullable', 'boolean'],
            'app_notifications_new_user' => ['nullable', 'boolean'],
            'app_notifications_data_update' => ['nullable', 'boolean'],
            'app_notifications_system_report' => ['nullable', 'boolean'],
            'app_notifications_security_update' => ['nullable', 'boolean'],
        ];
    }
}