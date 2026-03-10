<?php

namespace Modules\Tourists\Http\Requests\TouristService;

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
            // === 1. BASIC IDENTIFICATION ===
            'code' => ['nullable', 'string', Rule::unique('tourist_services', 'code')->ignore($touristServiceId)],
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'service_type' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'supplier_type' => ['nullable', 'string', 'max:255'],
            'supplier_name' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // === 2. LOCATION & GEOGRAPHY ===
            'currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'region_id' => ['nullable', 'integer', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'integer', 'exists:subregions,id'],
            'timezone_id' => ['nullable', 'integer', 'exists:timezones,id'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            // === 3. PRICING CONFIGURATION ===
            'pricing_model' => ['nullable', 'string', 'in:per_person,per_group'],
            'pricing_type' => ['nullable', 'string', 'in:flat,seasonal'],
            'pricing_unit' => ['nullable', 'string', 'max:100'],
            'pricing_unit_value' => ['nullable', 'integer', 'min:1'],
            'cost_adult' => ['nullable', 'numeric', 'min:0'],
            'cost_child' => ['nullable', 'numeric', 'min:0'],
            'price_adult' => ['nullable', 'numeric', 'min:0'],
            'price_child' => ['nullable', 'numeric', 'min:0'],
            'service_seasons' => ['nullable', 'array'],
            'seasonal_prices' => ['nullable', 'array'],
            'season_groups' => ['nullable', 'array'],
            'flat_start_date' => ['nullable', 'date_format:Y-m-d'],
            'flat_end_date' => ['nullable', 'date_format:Y-m-d'],
            'child_min_age' => ['nullable', 'integer', 'min:0', 'max:18'],
            'child_max_age' => ['nullable', 'integer', 'min:0', 'max:18'],

            // === 4. DETAILED PRICING (Legacy) ===
            'price_foreigner_adult' => ['nullable', 'numeric', 'min:0'],
            'price_foreigner_child' => ['nullable', 'numeric', 'min:0'],
            'price_arab_adult' => ['nullable', 'numeric', 'min:0'],
            'price_arab_child' => ['nullable', 'numeric', 'min:0'],
            'price_local_adult' => ['nullable', 'numeric', 'min:0'],
            'price_local_child' => ['nullable', 'numeric', 'min:0'],
            'price_resident_adult' => ['nullable', 'numeric', 'min:0'],
            'price_resident_child' => ['nullable', 'numeric', 'min:0'],

            // === 5. MODULES & INTEGRATION ===
            'target_modules' => ['nullable', 'array'],
            'target_modules.*' => ['nullable', 'string'],

            // === 6. TAXES & COMMISSION ===
            'is_tax_inclusive' => ['nullable', 'boolean'],
            'tax_configuration' => ['nullable', 'array'],
            'commission_configuration' => ['nullable', 'array'],

            // === 7. OPERATIONS ===
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'operating_days' => ['nullable', 'array'],
            'operating_days.*' => ['nullable', 'string'],
            'special_hours' => ['nullable', 'array'],
            'is_24_7' => ['nullable', 'boolean'],
            'min_participants' => ['nullable', 'integer', 'min:1'],
            'max_participants' => ['nullable', 'integer', 'min:1'],

            // === 8. CONTACT & FLAGS ===
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'booking_required' => ['nullable', 'boolean'],
            'cancellation_policy' => ['nullable', 'string'],
            'is_refundable' => ['nullable', 'boolean'],
            'is_mandatory' => ['nullable', 'boolean'],
            'is_free' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],

            // === 9. MEDIA & META ===
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'difficulty_level' => ['nullable', 'string', 'in:easy,moderate,hard'],
            'tags' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
