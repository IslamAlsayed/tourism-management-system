<?php

namespace App\Http\Requests\Cities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitiesRequest extends FormRequest
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
            'name_ar' => ['required', 'string', 'max:255'],
            // 'state_id' => ['required', 'exists:states,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'timezone' => ['required', 'string', 'max:255'],
            'wikiDataId' => ['nullable', 'string', 'max:255'],
            'population' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'is_independent' => ['nullable', 'boolean'],
            'is_developed' => ['nullable', 'boolean'],
            'is_landlocked' => ['nullable', 'boolean'],
            'flag' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}