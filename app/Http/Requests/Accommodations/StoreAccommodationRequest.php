<?php

namespace App\Http\Requests\Accommodations;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccommodationRequest extends FormRequest
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
            'description' => 'nullable|string|max:5000',

            // Type & Currency
            'type_id' => 'nullable|exists:types,id',
            'currency_id' => 'nullable|exists:currencies,id',

            // Seasons (Many-to-Many)
            'season_ids' => 'nullable|array',
            'season_ids.*' => 'exists:seasons,id',

            // Rooms (Many-to-Many)
            'room_ids' => 'nullable|array',
            'room_ids.*' => 'exists:rooms,id',

            // Meals (Many-to-Many)
            'meal_ids' => 'nullable|array',
            'meal_ids.*' => 'exists:meals,id',

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
        ];
    }
}