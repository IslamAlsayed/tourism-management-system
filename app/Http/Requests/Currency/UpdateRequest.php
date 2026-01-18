<?php

namespace App\Http\Requests\Currency;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code' => ['nullable', 'string', 'max:10', Rule::unique('currencies', 'code')->ignore($this->route('currency'))],
            'name' => ['nullable', 'string', 'max:255'],
            'symbol' => ['nullable', 'string', 'max:10'],
            'is_active' => ['boolean'],
            'auto_update_rate' => ['boolean'],
        ];
    }
}