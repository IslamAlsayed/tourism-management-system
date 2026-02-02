<?php

namespace App\Http\Requests\Jeep;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Routes
            'route' => 'nullable|string|max:255',
            'route_ar' => 'nullable|string|max:255',
            'route_itinerary' => 'nullable', // JSON string from Tagify

            // Start/End Points (New)
            // 'start_point' => 'nullable|string|max:255',
            // 'end_point' => 'nullable|string|max:255',

            'origin_city_id' => 'nullable|exists:cities,id',
            'destination_city_id' => 'nullable|exists:cities,id',

            // Locations
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',

            'company_id' => 'nullable|exists:transportations_companies,id',

            // Trip Details
            'duration' => 'nullable|string|max:100',
            'distance' => 'nullable|string|max:100',
            'car_seats' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'currency_id' => 'nullable|exists:currencies,id',
            'price_type' => 'nullable|in:per_person,per_trip,per_vehicle,per_hour',

            // Vehicle Details
            'vehicle_model' => 'nullable|string|max:255',
            'model_year' => 'nullable|string|max:4',
            'license_plate' => 'nullable|string|max:50',

            // Media
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            // Seasons
            'seasons' => ['nullable', 'array'],
            'seasons.*.name' => ['nullable', 'string'],
            'seasons.*.start_date' => ['nullable', 'date'],
            'seasons.*.end_date' => ['nullable', 'date'],
            'seasons.*.price_local' => ['nullable', 'numeric'],
            'seasons.*.price_arab' => ['nullable', 'numeric'],
            'seasons.*.price_foreigner' => ['nullable', 'numeric'],

            // Nationality prices
            'seasons.*.nationality_prices' => ['nullable', 'array'],
            'seasons.*.nationality_prices.*.nationality_id' => ['nullable', 'exists:nationalities,id'],
            'seasons.*.nationality_prices.*.price_type' => ['nullable', 'string'],
            'seasons.*.nationality_prices.*.price' => ['nullable', 'numeric'],

            // Status
            'status' => 'nullable|in:active,maintenance,retired',

            // Features
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'has_ac' => 'boolean',
            'has_driver' => 'boolean',
            'has_camping_gear' => 'boolean',
            'is_4x4' => 'boolean',

            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
