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

            'region_id' => ['nullable', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'exists:subregions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],

            'all_states' => ['nullable', 'in:0,1'],
            'state_id' => ['nullable', 'array'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'all_cities' => ['nullable', 'in:0,1'],
            'city_id' => ['nullable', 'array'],
            'city_id.*' => ['integer', 'exists:cities,id'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'max:1000'],
            'notes' => ['nullable', 'max:1000'],
        ];
    }
}