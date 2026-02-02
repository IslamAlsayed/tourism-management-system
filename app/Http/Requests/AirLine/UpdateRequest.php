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
            // Airline Identification
            'iata_code' => ['nullable', 'string', 'max:4', Rule::unique('airlines', 'iata_code')->ignore($airline)],
            'icao_code' => ['nullable', 'string', 'max:3', Rule::unique('airlines', 'icao_code')->ignore($airline)],
            'parent_airline_icao_code' => ['nullable', 'string', 'max:4'],

            // Airline Names & Branding
            'marketing_name' => ['nullable', 'string', 'max:255'],
            'official_full_name' => ['nullable', 'string', 'max:255'],
            'alliance' => ['nullable', 'string', 'max:255'],
            'frequent_flyer_program_name' => ['nullable', 'string', 'max:255'],

            // Airline Classification
            'airline_type' => ['nullable', 'string', 'max:255'],
            'airline_type_code' => ['nullable', 'string', 'max:10'],
            'is_lowcost' => ['nullable', 'boolean'],

            // Home Country Information
            'airline_home_country' => ['nullable', 'string', 'max:255'],
            'airline_home_country_alpha_2_code' => ['nullable', 'string', 'max:2'],
            'airline_home_country_alpha_3_code' => ['nullable', 'string', 'max:3'],
            'airline_home_city_iata_code' => ['nullable', 'string', 'max:3'],

            // Organization Details
            'year_of_foundation' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'email' => ['nullable', 'email', 'max:255'],
            'official_website' => ['nullable', 'url', 'max:500'],
            'baggage_policy_url' => ['nullable', 'url', 'max:500'],
            'web_check_in_url' => ['nullable', 'url', 'max:500'],

            // Contact Information
            'local_phone_number' => ['nullable', 'string', 'max:20'],
            'international_phone_number' => ['nullable', 'string', 'max:20'],

            // Location Relationships
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],

            // Additional Information
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
