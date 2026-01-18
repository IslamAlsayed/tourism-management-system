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
        return [
            // Location
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],

            // Site Information
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'site_type' => ['nullable', 'string', 'max:255'],
            'unesco_site' => ['nullable', 'boolean'],
            'supplier_type' => ['nullable', 'string', 'max:255'],
            'sites_theme' => ['nullable', 'string', 'max:255'],
            'supplier_name' => ['nullable', 'string', 'max:255'],

            // Coordinates
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            // Descriptions
            'description' => ['nullable', 'string'],
            'nearby_attractions' => ['nullable', 'string'],

            // Images
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            // Status
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}