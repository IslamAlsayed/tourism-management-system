<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'hire_date' => ['nullable', 'date'],
            'department' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'preferred_language' => ['nullable', 'string', 'max:255'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'preferences' => ['nullable', 'string', 'max:255'],
            'email_verified_at' => ['nullable', 'date'],
            'is_admin' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'force_password_change' => ['nullable', 'boolean'],
            'last_login_at' => ['nullable', 'date'],
            'last_login_ip' => ['nullable', 'string', 'max:45'],
            'notes' => ['nullable', 'string'],
            'created_by' => ['nullable', 'string', 'max:255'],
            'updated_by' => ['nullable', 'string', 'max:255'],
        ];
    }
}