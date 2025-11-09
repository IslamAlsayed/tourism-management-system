<?php

namespace App\Http\Requests\TouristSite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TouristSiteUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'site_type' => ['required', 'string', 'in:historical,natural,cultural,religious,recreational,archaeological,museum,park,other'],
            'category' => ['required', 'string', 'in:monument,landmark,attraction,site,facility'],

            // Location Information
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
            'currency' => ['nullable', 'string', 'max:3'],
            'is_free_entry' => ['nullable', 'boolean'],

            // Operating Hours
            'opening_time' => ['nullable', 'date_format:H:i'],
            'closing_time' => ['nullable', 'date_format:H:i'],
            'operating_days' => ['nullable', 'array'],
            'operating_days.*' => ['integer', 'between:1,7'],
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

            // Facilities & Activities & Services
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:100'],
            'activities' => ['nullable', 'array'],
            'activities.*' => ['string', 'max:100'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', 'max:100'],
            'has_parking' => ['nullable', 'boolean'],
            'has_restaurant' => ['nullable', 'boolean'],
            'has_gift_shop' => ['nullable', 'boolean'],
            'has_restrooms' => ['nullable', 'boolean'],
            'wheelchair_accessible' => ['nullable', 'boolean'],

            // Media & Resources
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'virtual_tour_url' => ['nullable', 'url', 'max:500'],

            // Ratings & Reviews (usually calculated, but can be set manually)
            'average_rating' => ['nullable', 'numeric', 'between:0,5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'popularity_score' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Visitor Information
            'estimated_visit_duration' => ['nullable', 'integer', 'min:1'], // in minutes
            'difficulty_level' => ['nullable', 'string', 'in:easy,moderate,challenging,extreme'],
            'age_restrictions' => ['nullable', 'json'],
            'best_visit_time' => ['nullable', 'array'],
            'best_visit_time.*' => ['string', 'max:50'],

            // Administrative
            'status' => ['nullable', 'string', 'in:active,inactive,maintenance,permanently_closed'],
            'is_featured' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('main.validation.name_required'),
            'type.required' => __('main.validation.type_required'),
            'category.required' => __('main.validation.category_required'),
            'latitude.between' => __('main.validation.latitude_range'),
            'longitude.between' => __('main.validation.longitude_range'),
            'main_image.image' => __('main.validation.main_image_format'),
            'main_image.max' => __('main.validation.main_image_size'),
            'gallery_images.*.image' => __('main.validation.gallery_image_format'),
            'gallery_images.*.max' => __('main.validation.gallery_image_size'),
        ];
    }

    /**
     * Get custom attribute names for validation.
     */
    public function attributes(): array
    {
        return [
            'name' => __('main.name'),
            'name_ar' => __('main.name_ar'),
            'type' => __('main.type'),
            'category' => __('main.category'),
            'latitude' => __('main.latitude'),
            'longitude' => __('main.longitude'),
            'main_image' => __('main.main_image'),
            'gallery_images' => __('main.gallery_images'),
        ];
    }
}