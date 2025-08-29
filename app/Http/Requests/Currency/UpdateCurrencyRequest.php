<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:10', 'unique:currencies,code,' . $this->route('currency') . ',id'],
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'symbol' => ['required', 'string', 'max:10'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
            'decimal_places' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_major_currency' => ['boolean'],
            'is_base_currency' => ['boolean'],
            // 'sort_order' => ['required', 'integer', 'min:0'],
        ];
    }
}