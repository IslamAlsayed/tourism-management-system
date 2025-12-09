<?php

namespace App\Http\Requests\Season;

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
            'season_from' => 'required|date',
            'season_to' => 'required|date|after:season_from',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }
}