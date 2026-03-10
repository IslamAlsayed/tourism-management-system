<?php

namespace Modules\Geography\Http\Requests\State;

use Illuminate\Validation\Rule;
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
            'name' => ['nullable', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],

            'country_id' => ['nullable', 'string', 'exists:countries,id'],

            'iso2' => ['nullable', 'string', 'min:2', 'max:3'],
            'iso3' => ['nullable', 'string', 'min:2', 'max:3'],
            'fips_code' => ['nullable', 'string', 'max:2'],
            'type' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'integer'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'parent_id' => ['nullable', 'integer', 'exists:states,id'],
            'photo' => new \App\Rules\PhotoRules(),
            // 'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            'is_active' => ['boolean'],
            'is_independent' => ['boolean'],
            'is_developed' => ['boolean'],
            'is_landlocked' => ['boolean'],

            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
