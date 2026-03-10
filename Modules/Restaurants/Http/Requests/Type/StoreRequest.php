<?php

namespace Modules\Restaurants\Http\Requests\Type;

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
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
