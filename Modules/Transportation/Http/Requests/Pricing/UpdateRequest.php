<?php

namespace Modules\Transportation\Http\Requests\Pricing;

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
            'price' => ['nullable', 'integer', 'min:1'],
            'tax' => ['nullable', 'integer', 'min:0', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'company_id' => ['nullable', 'exists:transportations_companies,id'],
            'vehicle_type_id' => ['nullable', 'exists:transportations_vehicle_types,id'],
            'season_id' => ['nullable', 'exists:seasons,id'],
            'pricing_unit_id' => ['nullable', 'exists:pricing_definitions,id'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
        ];
    }
}
