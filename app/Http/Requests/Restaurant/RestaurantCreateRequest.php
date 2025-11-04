<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantCreateRequest extends FormRequest
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

            'region_id' => ['required', 'string', 'exists:regions,id'],
            'subregion_id' => ['required', 'string', 'exists:subregions,id'],
            'country_id' => ['required', 'string', 'exists:countries,id'],

            'state_id' => ['required'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'city_id' => ['required'],
            'city_id.*' => ['integer', 'exists:cities,id'],

            'company_name_ar' => ['nullable', 'string', 'max:255'],
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
            'photo' => ['nullable', 'max:2048', 'mimes:png,jpg,jpeg,gif,svg'],
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