<?php

namespace App\Http\Requests\CrossingPort;

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
            'code' => ['nullable', 'string', 'max:12', 'unique:crossing_ports,code'],

            // Location information
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'address' => ['nullable', 'string', 'max:1000'],

            // Basic information
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:' . implode(',', array_keys(config('helpers.crossing_port_types')))],

            // Operating information
            'operating_days' => ['nullable', 'array'],
            'operating_days.*' => ['string', 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday'],
            'opening_time' => ['nullable'],
            'closing_time' => ['nullable'],
            'is_24_7' => ['nullable', 'boolean'],
            'is_commercial' => ['nullable', 'boolean'],
            'is_passenger' => ['nullable', 'boolean'],
            'is_international' => ['nullable', 'boolean'],

            // Visa and immigration policies
            'allows_visa_on_arrival' => ['nullable', 'boolean'],
            'nationality_policy' => 'nullable', // JSON string from Tagify
            'departure_tax' => ['nullable', 'numeric', 'min:0'],
            'departure_tax_currency_id' => ['nullable', 'integer', 'exists:currencies,id'],

            // Contact information
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],

            // Display and classification
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_major' => ['nullable', 'boolean'],

            // Visa requirements
            'visa_required' => ['nullable', 'boolean'],
            'visa_fee' => ['nullable', 'numeric', 'min:0'],
            'visa_fee_currency_id' => ['nullable', 'exists:currencies,id'],
            'visa_duration' => ['nullable', 'integer', 'min:1'],
            'visa_conditions' => ['nullable', 'string', 'max:1000'],
            'visa_application_url' => ['nullable', 'url', 'max:255'],
            'visa_policy_source' => ['nullable', 'url', 'max:255'],
            'visa_last_update' => ['nullable', 'date'],

            // Additional notes
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
