<?php

namespace App\Http\Requests\TourGuideType;

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
            'type' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency_id' => ['nullable', 'exists:currencies,id'],

            'region_id' => ['nullable', 'integer', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'integer', 'exists:subregions,id'],
            'country_id' => ['nullable', 'integer', 'exists:countries,id'],
            'state_id' => ['nullable', 'array'],
            'state_id.*' => ['integer', 'exists:states,id'],
            'all_states' => ['nullable', 'boolean'],
            'city_id' => ['nullable', 'array'],
            'city_id.*' => ['integer', 'exists:cities,id'],
            'all_cities' => ['nullable', 'boolean'],

            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}