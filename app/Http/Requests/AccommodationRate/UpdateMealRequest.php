<?php

namespace App\Http\Requests\AccommodationRate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accommodation_id' => 'nullable|exists:accommodations,id',
            'season_id' => 'nullable|exists:seasons,id',
            'meal_id' => 'nullable|exists:meals,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'price' => 'nullable|numeric|min:0',
            'is_supplement' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }
}