<?php

namespace Modules\Transportation\Http\Requests\VehicleType;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'min_capacity' => ['nullable', 'integer'],
            'max_capacity' => ['nullable', 'integer'],
            'has_luggage' => ['nullable', 'boolean'],
            'is_air_conditioning' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'company_id' => ['required', 'exists:transportations_companies,id'],
        ];
    }
}
