<?php

namespace App\Http\Requests\AccommodationSupplement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'nullable|string',
            'is_mandatory' => 'nullable|boolean',
            'applicable_date' => 'nullable|date',
            'accommodation_id' => 'nullable|integer|exists:accommodations,id',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ];
    }
}