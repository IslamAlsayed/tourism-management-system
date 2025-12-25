<?php

namespace App\Http\Requests\Airline;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $airline = $this->route('airline');

        return [
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'icao' => ['nullable', 'string', 'max:4', Rule::unique('airlines', 'icao')->ignore($airline)],
            'iata' => ['nullable', 'string', 'max:3', Rule::unique('airlines', 'iata')->ignore($airline)],
            'lid' => ['nullable', 'string', 'max:10'],
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
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}