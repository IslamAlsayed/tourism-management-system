<?php

namespace App\Http\Requests\Transportation\Company;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'nullable|string|max:255|unique:accommodations,name',
            'name_ar' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'postal_code' => 'nullable|string|max:20',
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            // Contact
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',

            // Location
            'currency_id' => 'nullable|exists:currencies,id',
            'region_id' => 'nullable|exists:regions,id',
            'subregion_id' => 'nullable|exists:subregions,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'street' => 'nullable|string|max:500',
            'box' => 'nullable|string|max:50',

            'is_active' => 'boolean',
            'description' => 'nullable|string|max:5000',
            'notes' => 'nullable|string|max:5000',
        ];
    }
}