<?php

namespace App\Http\Requests\Accommodations;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // يمكن إضافة صلاحيات هنا لاحقاً
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Basic Information
            'name' => 'required|string|max:255|unique:accommodations,name',
            'name_ar' => 'nullable|string|max:255',
            'classification' => 'nullable|string|max:255',
            'stars' => 'nullable|integer|min:1|max:5',

            // Type & Currency
            'type_id' => 'nullable|exists:types,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'timezone_id' => 'nullable|exists:timezones,id',

            // Seasons Array
            'seasons' => 'nullable|array',
            'seasons.*.name' => 'required|string|max:255',
            'seasons.*.name_ar' => 'nullable|string|max:255',
            'seasons.*.season_from' => 'required|date',
            'seasons.*.season_to' => 'required|date|after:seasons.*.season_from',
            'seasons.*.notes' => 'nullable|string|max:5000',
            'seasons.*.is_active' => 'nullable|boolean',

            // Rooms Array
            'rooms' => 'nullable|array',
            'rooms.*.name' => 'required|string|max:255',
            'rooms.*.name_ar' => 'nullable|string|max:255',
            'rooms.*.max_occupancy' => 'nullable|integer|min:1',
            'rooms.*.occupancy_details' => 'nullable|string|max:500',
            'rooms.*.currency_id' => 'required|exists:currencies,id',
            'rooms.*.price_per_person_double' => 'required|numeric|min:0',
            'rooms.*.single_room_supplement' => 'nullable|numeric|min:0',
            'rooms.*.triple_room_discount' => 'nullable|numeric|min:0',
            'rooms.*.third_person_price' => 'nullable|numeric|min:0',
            'rooms.*.extra_bed_price' => 'nullable|numeric|min:0',
            'rooms.*.sea_view_supplement' => 'nullable|numeric|min:0',
            'rooms.*.is_active' => 'nullable|boolean',
            'rooms.*.notes' => 'nullable|string|max:5000',

            // Meals Array
            'meals' => 'nullable|array',
            'meals.*.name' => 'required|string|max:255',
            'meals.*.name_ar' => 'nullable|string|max:255',
            'meals.*.currency_id' => 'required|exists:currencies,id',
            'meals.*.price' => 'required|numeric|min:0',
            'meals.*.is_included' => 'nullable|boolean',
            'meals.*.is_supplement' => 'nullable|boolean',
            'meals.*.is_active' => 'nullable|boolean',
            'meals.*.notes' => 'nullable|string|max:5000',

            // Supplements Array
            'supplements' => 'nullable|array',
            'supplements.*.name' => 'required|string|max:255',
            'supplements.*.name_ar' => 'nullable|string|max:255',
            'supplements.*.currency_id' => 'required|exists:currencies,id',
            'supplements.*.price' => 'required|numeric|min:0',
            'supplements.*.price_type' => 'nullable|string|in:per_person,per_room,per_night,one_time',
            'supplements.*.is_mandatory' => 'nullable|boolean',
            'supplements.*.is_active' => 'nullable|boolean',
            'supplements.*.notes' => 'nullable|string|max:5000',

            // Contact Information
            'general_mobile' => 'nullable|string|max:20',
            'general_email' => 'nullable|email|max:255',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:20',

            // Contact Person
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'contact_mobile' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',

            // Location
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'region_id' => 'nullable|exists:regions,id',
            'subregion_id' => 'nullable|exists:subregions,id',
            'street' => 'nullable|string|max:500',
            'box' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

            // Contract
            'contract_file_path' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:5000',
        ];
    }
}