<?php

namespace Modules\Accommodations\Http\Requests\Supplement;

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
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'nullable|in:per_person,per_room,per_night,one_time',
            'applicable_date' => 'nullable|date',
            'is_mandatory' => 'boolean',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
