<?php

namespace App\Http\Requests\Transportation\RouteAssignment;

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
            'route_id' => 'required|exists:transportations_routes,id',
            'company_id' => 'required|exists:transportations_companies,id',
            'vehicle_type_id' => 'nullable|exists:transportations_vehicle_types,id',
            'currency_id' => 'required|exists:currencies,id',

            // Pricing
            'base_price' => 'nullable|numeric|min:0|max:9999999.99',
            'price_per_km' => 'nullable|numeric|min:0|max:9999999.99',
            'price_per_person' => 'nullable|numeric|min:0|max:9999999.99',

            // Schedule
            'available_days' => 'nullable|array',
            'available_days.*' => 'integer|between:0,6',
            'departure_time' => 'nullable',
            'arrival_time' => 'nullable|after:departure_time',
            'frequency_per_day' => 'nullable|integer|min:1|max:50',

            // Operational
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',

            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'route_id.required' => 'Route is required',
            'company_id.required' => 'Company is required',
            'currency_id.required' => 'Currency is required',
            'arrival_time.after' => 'Arrival time must be after departure time',
            'valid_to.after_or_equal' => 'Valid to date must be after or equal to valid from date',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('available_days') && is_array($this->available_days)) {
            $this->merge([
                'available_days' => array_values(array_map('intval', $this->available_days))
            ]);
        }
    }
}