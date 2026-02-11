<?php

namespace Modules\Tourists\Http\Requests\TouristSite;

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
            // ========== Basic Information ==========
            'code' => ['nullable', 'string', 'max:255', 'unique:tourist_sites,code'],
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'site_type' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'unesco_site' => ['nullable', 'boolean'],
            'supplier_type' => ['nullable', 'string', 'max:255'],
            'sites_theme' => ['nullable', 'string', 'max:255'],
            'supplier_name' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // ========== Location Information ==========
            'currency_id' => ['nullable', 'integer', 'exists:currencies,id'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'postal_code' => ['nullable', 'string', 'max:20'],

            // ========== Entry Fees ==========
            'entry_fee_adult' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_child' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_student' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_senior' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_group' => ['nullable', 'numeric', 'min:0'],
            'is_free_entry' => ['nullable', 'boolean'],
            'entry_fee_foreigner_adult' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_foreigner_child' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_arab_adult' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_arab_child' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_local_adult' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_local_child' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_resident_adult' => ['nullable', 'numeric', 'min:0'],
            'entry_fee_resident_child' => ['nullable', 'numeric', 'min:0'],

            // ========== Operating Hours ==========
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'operating_days' => ['nullable', 'array'],
            // 'special_hours' => ['nullable', 'json'],
            'is_24_7' => ['nullable', 'boolean'],

            // ========== Contact Information ==========
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],
            'fax' => ['nullable', 'string', 'max:20'],
            'contact_person' => ['nullable', 'string', 'max:255'],

            // ========== Facilities & Services ==========
            'wheelchair_accessible' => ['nullable', 'boolean'],
            'free_wifi' => ['nullable', 'boolean'],
            'parking' => ['nullable', 'boolean'],
            'restrooms' => ['nullable', 'boolean'],
            'restaurants' => ['nullable', 'boolean'],
            'gift_shop' => ['nullable', 'boolean'],
            'guided_tours' => ['nullable', 'boolean'],
            'audio_guide' => ['nullable', 'boolean'],
            'photography' => ['nullable', 'boolean'],
            'hiking' => ['nullable', 'boolean'],
            'swimming' => ['nullable', 'boolean'],
            'camping' => ['nullable', 'boolean'],
            'shopping' => ['nullable', 'boolean'],
            'dining' => ['nullable', 'boolean'],
            'entertainment' => ['nullable', 'boolean'],
            'educational_tours' => ['nullable', 'boolean'],
            'translation' => ['nullable', 'boolean'],
            'special_events' => ['nullable', 'boolean'],
            'group_bookings' => ['nullable', 'boolean'],
            'online_booking' => ['nullable', 'boolean'],
            'mobile_app' => ['nullable', 'boolean'],
            'virtual_tours' => ['nullable', 'boolean'],

            // ========== Additional Pricing ==========
            'local_guide_price' => ['nullable', 'numeric', 'min:0'],
            'club_car_price' => ['nullable', 'numeric', 'min:0'],
            'has_unified_ticket' => ['nullable', 'boolean'],

            // ========== Media & Content ==========
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],

            // ========== Visitor Information ==========
            'nearby_attractions' => ['nullable', 'string'],
            'average_rating' => ['nullable', 'numeric', 'between:0,5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'popularity_score' => ['nullable', 'integer', 'between:0,100'],
            'estimated_visit_duration' => ['nullable', 'integer', 'min:0'],
            'difficulty_level' => ['nullable', 'string'],
            'age_restrictions' => ['nullable', 'array'],
            'best_visit_time' => ['nullable', 'array'],

            // ========== Status & Metadata ==========
            'status' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'tags' => ['nullable', 'array'],

            // ========== Description & Notes ==========
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
