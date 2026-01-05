<?php

namespace App\Http\Requests\Type;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $typeId = $this->route('type');

        return [
            'name' => 'nullable|string|max:255|unique:types,name,' . $typeId,
            'name_ar' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}