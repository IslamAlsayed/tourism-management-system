<?php

namespace App\Http\Requests\TouristService;

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
            'id' => ['sometimes', 'integer'],
            'code' => ['nullable', 'string', 'max:255', 'unique:tourist_services,code'],
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'region_id' => ['nullable', 'integer', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'integer', 'exists:subregions,id'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'site_type' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'translation' => ['nullable', 'boolean'],
            'special_events' => ['nullable', 'boolean'],
            'group_bookings' => ['nullable', 'boolean'],
            'online_booking' => ['nullable', 'boolean'],
            'mobile_app' => ['nullable', 'boolean'],
            'virtual_tours' => ['nullable', 'boolean'],
            'has_parking' => ['nullable', 'boolean'],
            'has_restaurant' => ['nullable', 'boolean'],
            'has_gift_shop' => ['nullable', 'boolean'],
            'has_restrooms' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'virtual_tour_url' => ['nullable', 'string', 'max:500'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'total_reviews' => ['nullable', 'integer', 'min:0'],
            'popularity_score' => ['nullable', 'integer', 'min:0'],
            'estimated_visit_duration' => ['nullable', 'integer', 'min:0'],
            'difficulty_level' => ['nullable', 'string', 'max:255'],
            'age_restrictions' => ['nullable', 'json'],
            'best_visit_time' => ['nullable', 'json'],
            'tags' => ['nullable', 'array'],
            'address' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'zone' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'block' => ['nullable', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'floor' => ['nullable', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'directions' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'telegram' => ['nullable', 'string', 'max:255'],
            'snapchat' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'ticket_type' => ['nullable', 'string', 'max:255'],
            'ticket_price' => ['nullable', 'numeric'],
            'ticket_price_children' => ['nullable', 'numeric'],
            'ticket_price_students' => ['nullable', 'numeric'],
            'ticket_price_seniors' => ['nullable', 'numeric'],
            'ticket_price_groups' => ['nullable', 'numeric'],
            'ticket_options' => ['nullable', 'json'],
            'discounts' => ['nullable', 'json'],
            'special_offers' => ['nullable', 'json'],
            'opening_hours' => ['nullable', 'json'],
            'holiday_hours' => ['nullable', 'json'],
            'closed_dates' => ['nullable', 'json'],
            'event_schedules' => ['nullable', 'json'],
            'facilities' => ['nullable', 'json'],
            'accessibility_features' => ['nullable', 'json'],
            'safety_features' => ['nullable', 'json'],
            'health_measures' => ['nullable', 'json'],
            'covid_measures' => ['nullable', 'json'],
            'services' => ['nullable', 'json'],
            'activities' => ['nullable', 'json'],
            'events' => ['nullable', 'json'],
            'workshops' => ['nullable', 'json'],
            'tours' => ['nullable', 'json'],
            'programs' => ['nullable', 'json'],
            'packages' => ['nullable', 'json'],
            'media_files' => ['nullable', 'json'],
            'documents' => ['nullable', 'json'],
            'links' => ['nullable', 'json'],
            'brochures' => ['nullable', 'json'],
            'menus' => ['nullable', 'json'],
            'maps' => ['nullable', 'json'],
            'translations' => ['nullable', 'json'],
            'custom_fields' => ['nullable', 'json'],
            'extra' => ['nullable', 'json'],
            'slug' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'json'],
            'last_imported_at' => ['nullable', 'date'],
            'last_exported_at' => ['nullable', 'date'],
            'import_metadata' => ['nullable', 'json'],
            'export_metadata' => ['nullable', 'json'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_verified' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'created_by' => ['nullable', 'integer'],
            'updated_by' => ['nullable', 'integer'],
        ];
    }
}