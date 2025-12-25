<?php

namespace App\Http\Requests\Season;

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
            'model_id' => 'nullable|string|max:255',
            'model_type' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'season_from' => 'nullable|date',
            'season_to' => 'nullable|date|after:season_from',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}