<?php

namespace Modules\Localization\Http\Requests\Currency;

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
            'code' => ['required', 'string', 'max:10', 'unique:currencies,code'],
            'name' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'symbol' => ['required', 'string', 'max:10'],
            'exchange_rate' => ['nullable', 'numeric', 'min:0'],
            'decimal_places' => ['nullable', 'integer', 'min:0', 'max:8'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'is_auto_update' => ['boolean'],
            'is_base_currency' => ['boolean'],
            'is_major_currency' => ['boolean'],
        ];
    }
}
