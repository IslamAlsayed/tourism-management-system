<?php

namespace App\Http\Requests\AccommodationSupplement;

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
            'price' => 'required|numeric|min:0',
            'is_per_person' => 'required|boolean',
            'is_mandatory' => 'nullable|boolean',
            'applicable_date' => 'nullable|date',
            'accommodation_id' => 'required|integer|exists:accommodations,id',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ];
    }
}