<?php

namespace App\Http\Requests\Settings;

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
                    if ($value > 0 && $value < 5) {
                        $fail(__('validation.session_lifetime_min_5_or_0'));
                    }
                },
            ],
            'app_password_confirmation' => ['nullable', 'boolean'],
            'app_two_factor_authentication' => ['nullable', 'boolean'],
            'app_backup_frequency' => ['nullable', 'string', 'in:daily,weekly,monthly'],
            'app_auto_backup' => ['nullable', 'boolean'],
            'app_email_notifications' => ['nullable', 'boolean'],
            'app_sms_notifications' => ['nullable', 'boolean'],
            'app_push_notifications' => ['nullable', 'boolean'],
            'app_notifications_new_record' => ['nullable', 'boolean'],
            'app_notifications_data_updates' => ['nullable', 'boolean'],
            'app_notifications_data_deletes' => ['nullable', 'boolean'],
            'app_notifications_system_reports' => ['nullable', 'boolean'],
            'app_notifications_security_updates' => ['nullable', 'boolean'],
        ];
    }
}