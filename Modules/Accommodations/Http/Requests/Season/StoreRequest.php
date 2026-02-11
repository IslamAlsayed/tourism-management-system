<?php

namespace Modules\Accommodations\Http\Requests\Season;

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
            'model_id' => 'required_without:model_type|string|max:255',
            'model_type' => 'required_without:model_id|string|max:255',
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'season_from' => 'required|date',
            'season_to' => 'required|date|after:season_from',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
