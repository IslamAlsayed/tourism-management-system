<?php

namespace Modules\Core\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
