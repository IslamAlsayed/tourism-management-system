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
            'name' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'season_from' => 'nullable|date',
            'season_to' => 'nullable|date|after:season_from',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
}