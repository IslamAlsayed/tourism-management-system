<?php

namespace App\Http\Requests\State;

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

            'country_id' => ['nullable', 'string', 'exists:countries,id'],
            'city_id' => ['nullable'],
            'city_id.*' => ['integer', 'exists:cities,id'],
            'all_cities' => ['nullable'],

            'iso2' => ['required', 'string', 'min:2', 'max:3'],
            'iso3' => ['required', 'string', 'min:2', 'max:3'],
            'fips_code' => ['nullable', 'string', 'max:2'],
            'type' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'parent_id' => ['nullable', 'integer', 'exists:states,id'],

            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],

            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}