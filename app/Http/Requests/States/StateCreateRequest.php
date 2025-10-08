<?php

namespace App\Http\Requests\States;

use Illuminate\Foundation\Http\FormRequest;

class StateCreateRequest extends FormRequest
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
            'iso2' => ['required', 'string', 'min:2', 'max:2', 'unique:countries,iso2'],
            'iso3' => ['required', 'string', 'min:3', 'max:3', 'unique:countries,iso3'],
            'fips_code' => ['nullable', 'string', 'max:2'],
            'type' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:states,id'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
        ];
    }
}