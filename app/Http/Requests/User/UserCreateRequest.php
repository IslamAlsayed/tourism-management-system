<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'bio' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'user_code' => ['nullable', 'string', 'max:50', 'unique:users,user_code'],
            'employee_id' => ['nullable', 'string', 'max:50', 'unique:users,employee_id'],
            'hire_date' => ['nullable', 'date'],
            'department' => ['nullable', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'preferred_language' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'preferences' => ['nullable', 'json'],
            'email_verified_at' => ['nullable', 'date'],
            'is_admin' => ['boolean'],
            'avatar_url' => ['nullable', 'url'],
            'is_active' => ['boolean'],
            'is_verified' => ['boolean'],
            'force_password_change' => ['boolean'],
            'last_login_at' => ['nullable', 'date'],
            'last_login_ip' => ['nullable', 'ip'],
            'notes' => ['nullable', 'string', 'max:500'],
            'created_by' => ['nullable', 'integer', 'exists:users,id'],
            'updated_by' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}