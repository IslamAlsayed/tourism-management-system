<?php

namespace App\Http\Requests\Nationalities;

use Illuminate\Foundation\Http\FormRequest;

class NationalitiesUpdateRequest extends FormRequest
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
            'is_active' => ['nullable', 'boolean'],
            'region_id' => ['required', 'string', 'exists:regions,id'],
            'subregion_id' => ['required', 'string', 'exists:subregions,id'],
            'country_id' => ['required', 'string', 'exists:countries,id'],
            'state_id' => ['required', 'string', 'exists:states,id'],
            'city_id' => ['required', 'string', 'exists:cities,id'],
        ];
    }
}