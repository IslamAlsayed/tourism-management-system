<?php

namespace App\Http\Requests\AccommodationRate;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accommodation_id' => 'required|exists:accommodations,id',
            'season_id' => 'required|exists:seasons,id',
            'meal_id' => 'required|exists:meals,id',
            'currency_id' => 'required|exists:currencies,id',
            'price' => 'required|numeric|min:0',
            'is_supplement' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ];
    }
}