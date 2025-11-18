<?php

namespace App\Http\Requests\CrossingPort;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CrossingPortUpdateRequest extends FormRequest
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
        $crossingPortId = $this->route('crossing_port') ?? $this->route('id');

        return [
            // Location information
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable'],
            'state_id.*' => ['exists:states,id'],
            'city_id' => ['nullable'],
            'city_id.*' => ['exists:cities,id'],

            // Basic information
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:' . implode(',', array_keys(config('helpers.crossing_port_types')))],
            'code' => ['nullable', 'string', 'max:10', Rule::unique('crossing_ports', 'code')->ignore($crossingPortId)],
            'description' => ['nullable', 'string', 'max:1000'],

            // Geographic coordinates
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            // Operating information
            'operating_hours' => ['nullable', 'string', 'max:255'],
            'is_24_7' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'is_commercial' => ['nullable', 'boolean'],
            'is_passenger' => ['nullable', 'boolean'],
            'is_international' => ['nullable', 'boolean'],

            // Visa and immigration policies
            'allows_visa_on_arrival' => ['nullable', 'boolean'],
            'nationality_policy' => ['nullable', 'array'],
            'departure_tax' => ['nullable', 'numeric', 'min:0'],
            'departure_tax_currency' => ['nullable', 'string', 'size:3'],

            // Contact information
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],

            // Display and classification
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_major' => ['nullable', 'boolean'],

            // Visa requirements
            'visa_required' => ['nullable', 'boolean'],
            'visa_fee' => ['nullable', 'numeric', 'min:0'],
            'visa_fee_currency' => ['nullable', 'string', 'size:3'],
            'visa_duration' => ['nullable', 'integer', 'min:1'],
            'visa_conditions' => ['nullable', 'string', 'max:1000'],
            'visa_application_url' => ['nullable', 'url', 'max:255'],
            'visa_policy_source' => ['nullable', 'url', 'max:255'],
            'visa_last_update' => ['nullable', 'date'],

            // Additional notes
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'code.unique' => __('main.the crossing port code must be unique.'),
            'name.required' => __('main.the crossing port name is required.'),
            'type.required' => __('main.the crossing port type is required.'),
            'type.in' => __('main.the selected crossing port type is invalid.'),
            'latitude.between' => __('main.latitude must be between -90 and 90.'),
            'longitude.between' => __('main.longitude must be between -180 and 180.'),
            'closing_time.after' => __('main.closing time must be after opening time.'),
            'capacity.min' => __('main.capacity must be at least 1.'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'code' => __('main.code'),
            'name' => __('main.name'),
            'name_ar' => __('main.name_ar'),
            'description' => __('main.description'),
            'description_ar' => __('main.description_ar'),
            'region_id' => __('main.region'),
            'subregion_id' => __('main.subregion'),
            'country_id' => __('main.country'),
            'state_id' => __('main.state'),
            'city_id' => __('main.city'),
            'type' => __('main.type'),
            'latitude' => __('main.latitude'),
            'longitude' => __('main.longitude'),
            'elevation' => __('main.elevation'),
            'is_operational' => __('main.operational'),
            'is_24_hours' => __('main.24_hours'),
            'opening_time' => __('main.opening_time'),
            'closing_time' => __('main.closing_time'),
            'operating_days' => __('main.operating_days'),
            'facilities' => __('main.facilities'),
            'services' => __('main.services'),
            'phone' => __('main.phone'),
            'fax' => __('main.fax'),
            'email' => __('main.email'),
            'website' => __('main.website'),
            'address' => __('main.address'),
            'address_ar' => __('main.address_ar'),
            'postal_code' => __('main.postal_code'),
            'capacity' => __('main.capacity'),
            'customs_office' => __('main.customs_office'),
            'immigration_office' => __('main.immigration_office'),
            'status' => __('main.status'),
            'notes' => __('main.notes'),
            'notes_ar' => __('main.notes_ar'),
        ];
    }
}