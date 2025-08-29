<?php

namespace App\Http\Requests\Countries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountriesRequest extends FormRequest
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
            'name_ar' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'iso2' => ['required', 'string', 'max:2', 'unique:countries,iso2,' . $this->route('country')],
            'iso3' => ['required', 'string', 'max:3', 'unique:countries,iso3,' . $this->route('country')],
            'phone_code' => ['nullable', 'string'],
            'capital' => ['nullable', 'string', 'max:255'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'population' => ['nullable', 'integer'],
            'area' => ['nullable', 'numeric'],
            'continent' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'languages' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'flag' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],
        ];
    }
}