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
            'price' => ['required', 'string', 'max:20'],
            'currency_id' => ['required', 'string', 'max:50', 'exists:currencies,id'],
            'region_id' => ['required', 'string', 'max:50', 'exists:regions,id'],
            'subregion_id' => ['required', 'string', 'max:50', 'exists:subregions,id'],
            'country_id' => ['required', 'string', 'max:50', 'exists:countries,id'],
            'state_id' => ['nullable', 'string', 'max:50', 'exists:states,id'],
            'multi_states' => ['nullable', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:50', 'exists:cities,id'],
            'multi_cities' => ['nullable', 'string', 'max:255'],
        ];
    }
}