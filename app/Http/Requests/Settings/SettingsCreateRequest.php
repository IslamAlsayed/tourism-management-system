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
            'app_name' => ['required', 'string'],
            'app_url' => ['required', 'url'],
            'app_timezone' => ['required', 'string'],
            'app_language' => ['required', 'string'],
            'app_version' => ['required', 'string'],
            'app_php_version' => ['required', 'string'],
            'photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
            'app_status' => ['nullable', 'boolean'],
            'app_password_length' => ['required', 'integer'],
            'app_session_lifetime' => ['required', 'integer'],
            'app_password_confirmation' => ['nullable', 'boolean'],
            'app_two_factor_authentication' => ['nullable', 'boolean'],
            'app_backup_frequency' => ['required', 'string', 'in:daily,weekly,monthly'],
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