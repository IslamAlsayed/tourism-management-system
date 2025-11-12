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
            // Basic information
            'code' => ['nullable', 'string', 'max:10', 'unique:crossing_ports,code,' . $crossingPortId],
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],

            // Location information
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable'],
            'state_id.*' => ['exists:states,id'],
            'city_id' => ['nullable'],
            'city_id.*' => ['exists:cities,id'],

            // Type and coordinates
            'type' => ['nullable', 'in:' . implode(',', array_keys(config('helpers.crossing_port_types')))],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'elevation' => ['nullable', 'string', 'max:50'],

            // Operating information
            'is_operational' => ['nullable', 'boolean'],
            'is_24_hours' => ['nullable', 'boolean'],
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i', 'after:opening_time'],
            'operating_days' => ['nullable', 'array'],
            'operating_days.*' => ['in:' . implode(',', array_keys(config('helpers.days')))],

            // Facilities and services
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:100'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:100'],

            // Contact information
            'phone' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],

            // Address
            'address' => ['nullable', 'string', 'max:500'],
            'postal_code' => ['nullable', 'string', 'max:20'],

            // Additional information
            'capacity' => ['nullable', 'integer', 'min:1'],
            'runway_info' => ['nullable', 'array'],
            'runway_info.length' => ['nullable', 'string', 'max:20'],
            'runway_info.width' => ['nullable', 'string', 'max:20'],
            'runway_info.surface' => ['nullable', 'string', 'max:50'],
            'runway_info.lighting' => ['nullable', 'boolean'],
            'customs_office' => ['nullable', 'string', 'max:255'],
            'immigration_office' => ['nullable', 'string', 'max:255'],

            // Status and notes
            'status' => ['nullable', 'in:' . implode(',', array_keys(config('helpers.crossing_port_statuses')))],
            'notes' => ['nullable', 'string', 'max:1000'],

            // Images and documents
            'images' => ['nullable', 'array'],
            'images.*' => ['string', 'max:255'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['string', 'max:255'],
        ];
    }

    // /**
    //  * Get custom validation messages.
    //  */
    // public function messages(): array
    // {
    //     return [
    //         'code.unique' => 'The crossing port code must be unique.',
    //         'name.required' => 'The crossing port name is required.',
    //         'type.required' => 'The crossing port type is required.',
    //         'type.in' => 'The selected crossing port type is invalid.',
    //         'latitude.between' => 'Latitude must be between -90 and 90.',
    //         'longitude.between' => 'Longitude must be between -180 and 180.',
    //         'closing_time.after' => 'Closing time must be after opening time.',
    //         'capacity.min' => 'Capacity must be at least 1.',
    //     ];
    // }

    // /**
    //  * Get custom attributes for validator errors.
    //  */
    // public function attributes(): array
    // {
    //     return [
    //         'code' => __('main.code'),
    //         'name' => __('main.name'),
    //         'name_ar' => __('main.name_ar'),
    //         'description' => __('main.description'),
    //         'description_ar' => __('main.description_ar'),
    //         'region_id' => __('main.region'),
    //         'subregion_id' => __('main.subregion'),
    //         'country_id' => __('main.country'),
    //         'state_id' => __('main.state'),
    //         'city_id' => __('main.city'),
    //         'type' => __('main.type'),
    //         'latitude' => __('main.latitude'),
    //         'longitude' => __('main.longitude'),
    //         'elevation' => __('main.elevation'),
    //         'is_operational' => __('main.operational'),
    //         'is_24_hours' => __('main.24_hours'),
    //         'opening_time' => __('main.opening_time'),
    //         'closing_time' => __('main.closing_time'),
    //         'operating_days' => __('main.operating_days'),
    //         'facilities' => __('main.facilities'),
    //         'services' => __('main.services'),
    //         'phone' => __('main.phone'),
    //         'fax' => __('main.fax'),
    //         'email' => __('main.email'),
    //         'website' => __('main.website'),
    //         'address' => __('main.address'),
    //         'address_ar' => __('main.address_ar'),
    //         'postal_code' => __('main.postal_code'),
    //         'capacity' => __('main.capacity'),
    //         'customs_office' => __('main.customs_office'),
    //         'immigration_office' => __('main.immigration_office'),
    //         'status' => __('main.status'),
    //         'notes' => __('main.notes'),
    //         'notes_ar' => __('main.notes_ar'),
    //     ];
    // }
}