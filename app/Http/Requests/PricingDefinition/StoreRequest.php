<?php

namespace App\Http\Requests\PricingDefinition;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'key' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'modules' => 'nullable|array',
            'modules.*' => 'nullable|array',
        ];
    }
}
