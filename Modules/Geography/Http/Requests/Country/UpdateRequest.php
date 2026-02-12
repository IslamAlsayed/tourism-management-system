<?php

namespace Modules\Geography\Http\Requests\Country;

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
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'iso2' => ['nullable', 'string', 'min:2', 'max:3'],
            'iso3' => ['nullable', 'string', 'min:2', 'max:3'],
            'numeric_code' => ['nullable', 'integer'],
            'phone_code' => ['nullable', 'string'],
            'capital' => ['nullable', 'string', 'max:255'],
            'tld' => ['nullable', 'string', 'max:10'],
            'native' => ['nullable', 'string', 'max:255'],
            'continent' => ['nullable', 'string', 'max:100'],
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'language_id' => ['nullable', 'exists:languages,id'],
            'population' => ['nullable', 'integer'],
            'area' => ['nullable', 'numeric'],

            'region_id' => ['nullable', 'integer', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'integer', 'exists:subregions,id'],

            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}