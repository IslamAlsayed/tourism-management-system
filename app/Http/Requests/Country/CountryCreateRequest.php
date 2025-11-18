<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryCreateRequest extends FormRequest
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
            'iso2' => ['required', 'string', 'unique:countries,iso2'],
            'iso3' => ['required', 'string', 'unique:countries,iso3'],
            'phone_code' => ['nullable', 'string'],
            'capital' => ['nullable', 'string', 'max:255'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'population' => ['nullable', 'integer'],
            'area' => ['nullable', 'numeric'],

            'region_id' => ['nullable', 'string', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'string', 'exists:subregions,id'],

            'state_id' => ['nullable'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'city_id' => ['nullable'],
            'city_id.*' => ['integer', 'exists:cities,id'],

            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'languages' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],
        ];
    }
}