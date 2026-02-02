<?php

namespace App\Http\Requests\City;

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

            'timezone_id' => ['nullable', 'exists:timezones,id'],
            'country_id' => ['nullable', 'exists:countries,id'],

            'state_id' => ['nullable'],
            'state_id.*' => ['integer', 'exists:states,id'],
            'all_states' => ['nullable'],

            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'wikiDataId' => ['nullable', 'string', 'max:255'],
            'population' => ['nullable', 'integer'],

            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],

            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
