<?php

namespace App\Http\Requests\TouristSite;

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
        $touristSiteId = $this->route('tourist_site') ?? $this->route('id');

        return [
            'site_code' => ['nullable', 'string', 'max:50', Rule::unique('tourist_sites', 'site_code')->ignore($touristSiteId)],

            // Basic Information
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'site_type' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],

            // Location Information
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],

            // Geographical Details
            'address' => ['nullable', 'string'],
            'address_ar' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'postal_code' => ['nullable', 'string', 'max:20'],

            // Entry Information
            'entry_fee_adult' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'entry_fee_child' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'entry_fee_student' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'entry_fee_senior' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'entry_fee_group' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'is_free_entry' => ['nullable', 'boolean'],

            // Operating Hours
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'operating_days' => ['nullable', 'array'],
            'operating_days.*' => ['string', 'between:1,7'],
            'special_hours' => ['nullable', 'json'],
            'is_24_hours' => ['nullable', 'boolean'],

            // Contact Information
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],

            // Facilities
            'wheelchair_accessible' => ['nullable', 'boolean'],
            'free_wifi' => ['nullable', 'boolean'],
            'parking' => ['nullable', 'boolean'],
            'restrooms' => ['nullable', 'boolean'],
            'restaurants' => ['nullable', 'boolean'],
            'gift_shop' => ['nullable', 'boolean'],
            'guided_tours' => ['nullable', 'boolean'],
            'audio_guide' => ['nullable', 'boolean'],

            // Activities
            'photography' => ['nullable', 'boolean'],
            'hiking' => ['nullable', 'boolean'],
            'swimming' => ['nullable', 'boolean'],
            'camping' => ['nullable', 'boolean'],
            'shopping' => ['nullable', 'boolean'],
            'dining' => ['nullable', 'boolean'],
            'entertainment' => ['nullable', 'boolean'],
            'educational_tours' => ['nullable', 'boolean'],

            // Services
            'translation' => ['nullable', 'boolean'],
            'special_events' => ['nullable', 'boolean'],
            'group_bookings' => ['nullable', 'boolean'],
            'online_booking' => ['nullable', 'boolean'],
            'mobile_app' => ['nullable', 'boolean'],
            'virtual_tours' => ['nullable', 'boolean'],

            // Accessibility & Amenities
            'has_parking' => ['nullable', 'boolean'],
            'has_restaurant' => ['nullable', 'boolean'],
            'has_gift_shop' => ['nullable', 'boolean'],
            'has_restrooms' => ['nullable', 'boolean'],

            // Media & Resources
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],

            // Ratings & Reviews
            'average_rating' => ['nullable', 'numeric', 'between:0,5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'popularity_score' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Visitor Information
            'estimated_visit_duration' => ['nullable', 'integer', 'min:1'],
            'difficulty_level' => ['nullable', 'string'],
            'age_restrictions' => ['nullable', 'json'],
            'best_visit_time' => ['nullable', 'array'],
            'best_visit_time.*' => ['string', 'max:50'],

            // Administrative
            'status' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ];
    }
}