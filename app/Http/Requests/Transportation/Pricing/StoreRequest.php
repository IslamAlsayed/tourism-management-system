<?php

namespace App\Http\Requests\Transportation\Pricing;

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
            'price' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'company_id' => ['required', 'exists:transportation_companies,id'],
            'vehicle_type_id' => ['required', 'exists:transportation_vehicle_types,id'],
            'season_id' => ['required', 'exists:seasons,id'],
            'pricing_unit_id' => ['required', 'exists:pricing_definitions,id'],
        ];
    }
}