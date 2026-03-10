<?php

namespace App\Http\Requests\TransportationCompanyBusTypes;

use Illuminate\Foundation\Http\FormRequest;

class TransportationCompanyBusTypesCreateRequest extends FormRequest
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
            'min_seats' => ['nullable', 'integer', 'min:0'],
            'max_seats' => ['nullable', 'integer', 'min:0', 'gte:min_seats'],
            'seats' => ['nullable', 'integer', 'max:255'],
            'company_id' => ['required', 'string', 'exists:transportations_companies,id'],
            'bus_type_id' => ['required', 'string', 'exists:transportations_bus_types,id'],
        ];
    }
}
