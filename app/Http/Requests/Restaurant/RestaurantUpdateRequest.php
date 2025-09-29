<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantUpdateRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'city_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'region_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'subregion_id' => ['nullable', 'string', 'max:50', 'exists:restaurants,id'],
            'type' => ['nullable', 'string', 'max:255'], // modify as needed
            'company_name_ar' => ['nullable', 'string', 'max:255'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'phone_01' => ['nullable', 'string', 'max:20'],
            'phone_02' => ['nullable', 'string', 'max:20'],
            'fax' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'numeric', 'between:1,5'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email_01' => ['nullable', 'email', 'max:255', 'exists:restaurants,email_01'],
            'email_02' => ['nullable', 'email', 'max:255', 'exists:restaurants,email_02'],
            'box' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:50'],
            'street' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url'],
            'notes' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'wheelchair_accessible' => ['boolean'],
            'free_wifi' => ['boolean'],
            'parking' => ['boolean'],
            'swimming_pool' => ['boolean'],
            'gym' => ['boolean'],
            'indoor' => ['boolean'],
            'outdoor' => ['boolean'],
            'spa' => ['boolean'],
        ];
    }
}