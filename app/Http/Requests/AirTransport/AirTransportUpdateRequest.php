<?php

namespace App\Http\Requests\AirTransport;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AirTransportUpdateRequest extends FormRequest
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
        $airTransport = $this->route('air_transport');

        return [
            // Basic Information
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:3', 'unique:air_transports,code,' . $airTransport->id],
            'description' => ['nullable', 'string'],

            // Type and Category
            'type' => ['required', 'in:' . implode(',', array_keys(config('helpers.air_transport_types')))],
            'service_type' => ['required', 'in:' . implode(',', array_keys(config('helpers.air_transport_service_types')))],

            // Operational Information
            'is_active' => ['boolean'],
            'is_international' => ['boolean'],
            'is_domestic' => ['boolean'],
            'established_date' => ['nullable', 'date', 'before_or_equal:today'],
            'hub_airport' => ['nullable', 'string', 'max:10'],

            // Fleet Information
            'fleet_size' => ['nullable', 'integer', 'min:0', 'max:1000'],
            'aircraft_types' => ['nullable', 'string'],
            'passenger_capacity' => ['nullable', 'integer', 'min:0'],
            'cargo_capacity' => ['nullable', 'integer', 'min:0'],

            // Contact Information
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'booking_phone' => ['nullable', 'string', 'max:20'],
            'customer_service_phone' => ['nullable', 'string', 'max:20'],

            // Address Information
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],

            // Geographic Information
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            // Location Relationships
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],

            // Business Information
            'license_number' => ['nullable', 'string', 'max:50'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'certifications' => ['nullable', 'string'],
            'destinations' => ['nullable', 'string'],

            // Service Information
            'services' => ['nullable', 'string'],
            'cabin_classes' => ['nullable', 'string'],
            'has_frequent_flyer' => ['boolean'],
            'frequent_flyer_program' => ['nullable', 'string', 'max:100'],

            // Financial Information
            'annual_revenue' => ['nullable', 'numeric', 'min:0'],
            'annual_passengers' => ['nullable', 'integer', 'min:0'],
            'on_time_performance' => ['nullable', 'numeric', 'between:0,100'],

            // Safety and Quality
            'safety_rating' => ['nullable', 'numeric', 'between:0,10'],
            'safety_rating_agency' => ['nullable', 'string', 'max:100'],
            'accident_count' => ['nullable', 'integer', 'min:0'],
            'last_safety_audit' => ['nullable', 'date', 'before_or_equal:today'],

            // Alliance and Partnerships
            'alliance' => ['nullable', 'string', 'max:50'],
            'partnerships' => ['nullable', 'string'],
            'codeshare_agreements' => ['nullable', 'string'],

            // Status and Notes
            'status' => ['required', 'in:'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('main.name')]),
            'code.required' => __('validation.required', ['attribute' => __('main.code')]),
            'code.unique' => __('validation.unique', ['attribute' => __('main.code')]),
            'type.required' => __('validation.required', ['attribute' => __('main.type')]),
            'type.in' => __('validation.in', ['attribute' => __('main.type')]),
            'service_type.required' => __('validation.required', ['attribute' => __('main.service_type')]),
            'service_type.in' => __('validation.in', ['attribute' => __('main.service_type')]),
            'status.required' => __('validation.required', ['attribute' => __('main.status')]),
            'status.in' => __('validation.in', ['attribute' => __('main.status')]),
            'email.email' => __('validation.email', ['attribute' => __('main.email')]),
            'website.url' => __('validation.url', ['attribute' => __('main.website')]),
            'established_date.date' => __('validation.date', ['attribute' => __('main.established_date')]),
            'established_date.before_or_equal' => __('validation.before_or_equal', ['attribute' => __('main.established_date'), 'date' => 'today']),
            'latitude.between' => __('validation.between.numeric', ['attribute' => __('main.latitude'), 'min' => -90, 'max' => 90]),
            'longitude.between' => __('validation.between.numeric', ['attribute' => __('main.longitude'), 'min' => -180, 'max' => 180]),
            'fleet_size.integer' => __('validation.integer', ['attribute' => __('main.fleet_size')]),
            'fleet_size.min' => __('validation.min.numeric', ['attribute' => __('main.fleet_size'), 'min' => 0]),
            'passenger_capacity.integer' => __('validation.integer', ['attribute' => __('main.passenger_capacity')]),
            'passenger_capacity.min' => __('validation.min.numeric', ['attribute' => __('main.passenger_capacity'), 'min' => 0]),
            'cargo_capacity.integer' => __('validation.integer', ['attribute' => __('main.cargo_capacity')]),
            'cargo_capacity.min' => __('validation.min.numeric', ['attribute' => __('main.cargo_capacity'), 'min' => 0]),
            'on_time_performance.between' => __('validation.between.numeric', ['attribute' => __('main.on_time_performance'), 'min' => 0, 'max' => 100]),
            'safety_rating.between' => __('validation.between.numeric', ['attribute' => __('main.safety_rating'), 'min' => 0, 'max' => 10]),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => __('main.name'),
            'name_ar' => __('main.name_ar'),
            'code' => __('main.code'),
            'description' => __('main.description'),
            'description_ar' => __('main.description_ar'),
            'type' => __('main.type'),
            'service_type' => __('main.service_type'),
            'is_active' => __('main.is_active'),
            'is_international' => __('main.is_international'),
            'is_domestic' => __('main.is_domestic'),
            'established_date' => __('main.established_date'),
            'hub_airport' => __('main.hub_airport'),
            'fleet_size' => __('main.fleet_size'),
            'aircraft_types' => __('main.aircraft_types'),
            'passenger_capacity' => __('main.passenger_capacity'),
            'cargo_capacity' => __('main.cargo_capacity'),
            'phone' => __('main.phone'),
            'email' => __('main.email'),
            'website' => __('main.website'),
            'booking_phone' => __('main.booking_phone'),
            'customer_service_phone' => __('main.customer_service_phone'),
            'address' => __('main.address'),
            'address_ar' => __('main.address_ar'),
            'city' => __('main.city'),
            'postal_code' => __('main.postal_code'),
            'latitude' => __('main.latitude'),
            'longitude' => __('main.longitude'),
            'region_id' => __('main.region'),
            'subregion_id' => __('main.subregion'),
            'country_id' => __('main.country'),
            'state_id' => __('main.state'),
            'city_id' => __('main.city'),
            'license_number' => __('main.license_number'),
            'tax_number' => __('main.tax_number'),
            'certifications' => __('main.certifications'),
            'destinations' => __('main.destinations'),
            'services' => __('main.services'),
            'cabin_classes' => __('main.cabin_classes'),
            'has_frequent_flyer' => __('main.has_frequent_flyer'),
            'frequent_flyer_program' => __('main.frequent_flyer_program'),
            'annual_revenue' => __('main.annual_revenue'),
            'annual_passengers' => __('main.annual_passengers'),
            'on_time_performance' => __('main.on_time_performance'),
            'safety_rating' => __('main.safety_rating'),
            'safety_rating_agency' => __('main.safety_rating_agency'),
            'accident_count' => __('main.accident_count'),
            'last_safety_audit' => __('main.last_safety_audit'),
            'alliance' => __('main.alliance'),
            'partnerships' => __('main.partnerships'),
            'codeshare_agreements' => __('main.codeshare_agreements'),
            'status' => __('main.status'),
            'notes' => __('main.notes'),
            'notes_ar' => __('main.notes_ar'),
        ];
    }
}