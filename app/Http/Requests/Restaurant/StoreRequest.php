<?php

namespace App\Http\Requests\Restaurant;

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
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],

            'type_id' => ['required', 'string', 'max:50', 'exists:types,id'],
            'timezone_id' => ['nullable', 'string', 'exists:timezones,id'],
            'currency_id' => ['nullable', 'string', 'exists:currencies,id'],
            'region_id' => ['nullable', 'string', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'string', 'exists:subregions,id'],
            'country_id' => ['nullable', 'string', 'exists:countries,id'],
            'state_id' => ['nullable', 'string', 'exists:states,id'],
            'city_id' => ['nullable', 'string', 'exists:cities,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'cat' => ['nullable', 'string', 'max:255'],

            // Seasons Array
            'seasons' => 'nullable|array',
            'seasons.*.model_id' => 'nullable|string|max:255',
            'seasons.*.model_type' => 'nullable|string|max:255',
            'seasons.*.name' => 'nullable|string|max:255',
            'seasons.*.name_ar' => 'nullable|string|max:255',
            'seasons.*.season_from' => 'nullable|date',
            'seasons.*.season_to' => 'nullable|date|after:seasons.*.season_from',
            'seasons.*.is_active' => 'nullable|boolean',
            'seasons.*.description' => 'nullable|string|max:5000',
            'seasons.*.notes' => 'nullable|string|max:5000',

            // Meals Array
            'meals' => 'nullable|array',
            'meals.*.model_id' => 'nullable|string|max:255',
            'meals.*.model_type' => 'nullable|string|max:255',
            'meals.*.name' => 'nullable|string|max:255',
            'meals.*.name_ar' => 'nullable|string|max:255',
            'meals.*.currency_id' => 'nullable|exists:currencies,id',
            'meals.*.price' => 'nullable|numeric|min:0',
            'meals.*.is_included' => 'nullable|boolean',
            'meals.*.is_supplement' => 'nullable|boolean',
            'meals.*.is_active' => 'nullable|boolean',
            'meals.*.description' => 'nullable|string|max:5000',
            'meals.*.notes' => 'nullable|string|max:5000',

            // Supplements Array
            'supplements' => 'nullable|array',
            'supplements.*.model_id' => 'nullable|string|max:255',
            'supplements.*.model_type' => 'nullable|string|max:255',
            'supplements.*.name' => 'nullable|string|max:255',
            'supplements.*.name_ar' => 'nullable|string|max:255',
            'supplements.*.currency_id' => 'nullable|exists:currencies,id',
            'supplements.*.price' => 'nullable|numeric|min:0',
            'supplements.*.price_type' => 'nullable|string|in:per_person,per_room,per_night,one_time',
            'supplements.*.is_mandatory' => 'nullable|boolean',
            'supplements.*.is_active' => 'nullable|boolean',
            'supplements.*.description' => 'nullable|string|max:5000',
            'supplements.*.notes' => 'nullable|string|max:5000',

            'company_name' => ['nullable', 'string', 'max:255'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'phone_01' => ['nullable', 'string', 'max:20'],
            'phone_02' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'string', 'max:5'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email_01' => ['nullable', 'email', 'max:255'],
            'email_02' => ['nullable', 'email', 'max:255'],
            'box' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:50', 'unique:restaurants,postal_code'],
            'street' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            'is_active' => ['boolean'],
            'wheelchair_accessible' => ['boolean'],
            'free_wifi' => ['boolean'],
            'parking' => ['boolean'],
            'swimming_pool' => ['boolean'],
            'gym' => ['boolean'],
            'indoor' => ['boolean'],
            'outdoor' => ['boolean'],
            'spa' => ['boolean'],

            'description' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}