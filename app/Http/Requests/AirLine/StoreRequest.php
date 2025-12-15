<?php

namespace App\Http\Requests\Airline;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // Airport Codes
            'icao' => ['nullable', 'string', 'max:4', 'unique:air_transports,icao'],
            'iata' => ['nullable', 'string', 'max:3', 'unique:air_transports,iata'],
            'lid' => ['nullable', 'string', 'max:10'],

            // Airport Names
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],

            // Airport Type
            'subd' => ['nullable', 'string', 'max:50'],

            // Location Relationships
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],

            // Geographic Information
            'elevation' => ['nullable', 'numeric'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            // Contact Information
            'local_phone_number' => ['nullable', 'string', 'max:20'],
            'international_phone_number' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'icao.unique' => __('validation.unique', ['attribute' => __('main.icao')]),
            'iata.unique' => __('validation.unique', ['attribute' => __('main.iata')]),
            'name.required' => __('validation.required', ['attribute' => __('main.name')]),
            'website.url' => __('validation.url', ['attribute' => __('main.website')]),
            'latitude.between' => __('validation.between.numeric', ['attribute' => __('main.latitude'), 'min' => -90, 'max' => 90]),
            'longitude.between' => __('validation.between.numeric', ['attribute' => __('main.longitude'), 'min' => -180, 'max' => 180]),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'icao' => __('main.icao'),
            'iata' => __('main.iata'),
            'lid' => __('main.lid'),
            'name' => __('main.name'),
            'name_ar' => __('main.name_ar'),
            'subd' => __('main.subd'),
            'timezone_id' => __('main.timezone'),
            'region_id' => __('main.region'),
            'subregion_id' => __('main.subregion'),
            'country_id' => __('main.country'),
            'state_id' => __('main.state'),
            'city_id' => __('main.city'),
            'elevation' => __('main.elevation'),
            'latitude' => __('main.latitude'),
            'longitude' => __('main.longitude'),
            'local_phone_number' => __('main.local_phone_number'),
            'international_phone_number' => __('main.international_phone_number'),
            'website' => __('main.website'),
        ];
    }
}