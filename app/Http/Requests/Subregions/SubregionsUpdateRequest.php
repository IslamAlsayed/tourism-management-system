<?php

namespace App\Http\Requests\Subregions;

use Illuminate\Foundation\Http\FormRequest;

class SubregionsUpdateRequest extends FormRequest
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
            'wiki_data_id' => ['nullable', 'string', 'max:255'],
            'region_id' => ['nullable', 'string', 'exists:regions,id'],
        ];
    }
}