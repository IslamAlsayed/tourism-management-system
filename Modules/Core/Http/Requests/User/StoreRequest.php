<?php

namespace Modules\Core\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            // Basic Information
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            // Personal Information
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],

            // Employment Information
            'employee_id' => ['nullable', 'string', 'max:50'],
            'hire_date' => ['nullable', 'date'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],

            // Settings & Preferences
            'user_status' => ['nullable', 'string', 'max:50'],
            'preferred_language' => ['nullable', 'string', 'max:10'],
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'preferences' => ['nullable', 'string', 'max:500'],
            'button_display_mode' => ['nullable', 'string', 'in:icon,text,both'],

            // Status Flags
            'role' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'force_password_change' => ['nullable', 'boolean'],

            // Other fields
            'email_verified_at' => ['nullable', 'date'],
            'last_login_at' => ['nullable', 'date'],
            'last_login_ip' => ['nullable', 'ip'],
            'created_by' => ['nullable', 'integer', 'exists:users,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],

            // Notes
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
