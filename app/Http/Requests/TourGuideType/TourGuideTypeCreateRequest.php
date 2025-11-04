<?php

namespace App\Http\Requests\TourGuideType;

use Illuminate\Foundation\Http\FormRequest;

class TourGuideTypeCreateRequest extends FormRequest
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
            'type' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency_id' => ['required', 'exists:currencies,id'],

            'region_id' => ['required', 'exists:regions,id'],
            'subregion_id' => ['required', 'exists:subregions,id'],
            'country_id' => ['required', 'exists:countries,id'],

            'all_states' => ['nullable', 'in:0,1'],
            'state_id' => ['nullable', 'array'],
            'state_id.*' => ['integer', 'exists:states,id'],

            'all_cities' => ['nullable', 'in:0,1'],
            'city_id' => ['nullable', 'array'],
            'city_id.*' => ['integer', 'exists:cities,id'],
        ];
    }
}