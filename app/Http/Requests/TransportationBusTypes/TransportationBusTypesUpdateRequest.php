<?php

namespace App\Http\Requests\TransportationBusTypes;

use Illuminate\Foundation\Http\FormRequest;

class TransportationBusTypesUpdateRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'seats' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'company_id' => ['nullable', 'string', 'exists:transportations_companies,id'],
        ];
    }
}