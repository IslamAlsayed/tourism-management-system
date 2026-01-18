<?php

namespace App\Http\Requests\TouristService;

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
        $touristServiceId = $this->route('tourist-service') ?? $this->route('id');

        return [
            // Foreign Keys
            'site_id' => ['nullable', 'integer', 'exists:tourist_sites,id'],
            'currency_id' => ['nullable', 'integer', 'exists:currencies,id'],

            // Service Configuration
            'include_unified_ticket' => ['nullable', 'boolean'],
            'total_day_visit' => ['nullable', 'numeric', 'min:0'],

            // Pricing - Foreigners
            'per_adult_foreigners' => ['nullable', 'numeric', 'min:0'],
            'per_child_foreigners' => ['nullable', 'numeric', 'min:0'],

            // Pricing - Local
            'per_adult_local' => ['nullable', 'numeric', 'min:0'],
            'per_child_local' => ['nullable', 'numeric', 'min:0'],

            // Pricing - Arab
            'per_adult_arab' => ['nullable', 'numeric', 'min:0'],
            'per_child_arab' => ['nullable', 'numeric', 'min:0'],

            // Pricing - Residents
            'per_adult_residents' => ['nullable', 'numeric', 'min:0'],
            'per_child_residents' => ['nullable', 'numeric', 'min:0'],

            // Non-accommodated Visitors
            'non_accommodated_visitors_adult' => ['nullable', 'numeric', 'min:0'],
            'non_accommodated_visitors_child' => ['nullable', 'numeric', 'min:0'],

            // Operating Hours
            'summer_opening_time' => ['nullable', 'date_format:H:i'],
            'summer_closing_time' => ['nullable', 'date_format:H:i'],
            'winter_opening_time' => ['nullable', 'date_format:H:i'],
            'winter_closing_time' => ['nullable', 'date_format:H:i'],
            'operating_days' => ['nullable', 'array', 'distinct'],
            'operating_days.*' => ['nullable', 'string'],
            'annual_holidays' => ['nullable', 'array'],
            'annual_holidays.*' => ['nullable', 'date_format:Y-m-d'],
            // 'special_schedules' => ['nullable', 'array'],

            // Day Off & Holidays
            'day_off' => ['nullable', 'array', 'distinct'],
            'day_off.*' => ['nullable', 'string'],
            'yearly_holidays' => ['nullable', 'array'],
            'yearly_holidays.*' => ['nullable', 'string'],

            // Contact Information
            'phone' => ['nullable', 'string', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'mobile_01' => ['nullable', 'string', 'max:255'],
            'mobile_02' => ['nullable', 'string', 'max:255'],
            'person_name_01' => ['nullable', 'string', 'max:255'],
            'person_name_02' => ['nullable', 'string', 'max:255'],
            'email_01' => ['nullable', 'email'],
            'email_02' => ['nullable', 'email'],
            'website' => ['nullable', 'url'],

            // Local Guide
            'local_guide_available' => ['nullable', 'boolean'],
            'local_guide_not_available' => ['nullable', 'boolean'],
            'local_guide_fees_01' => ['nullable', 'numeric', 'min:0'],
            'local_guide_fees_02' => ['nullable', 'numeric', 'min:0'],
            'local_guide_fees_03' => ['nullable', 'numeric', 'min:0'],
            'local_guide_fees_04' => ['nullable', 'numeric', 'min:0'],
            'local_guide_fees_05' => ['nullable', 'numeric', 'min:0'],

            // Payment Methods
            'credit_cards' => ['nullable', 'boolean'],

            // Club Cars
            'club_cars_available' => ['nullable', 'boolean'],
            'club_car_prices_01' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_02' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_03' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_04' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_05' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_06' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_07' => ['nullable', 'numeric', 'min:0'],
            'club_car_prices_08' => ['nullable', 'numeric', 'min:0'],

            // Additional Fields
            'ext1' => ['nullable', 'string', 'max:255'],
            'ext2' => ['nullable', 'string', 'max:255'],
            'ext3' => ['nullable', 'string', 'max:255'],

            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}