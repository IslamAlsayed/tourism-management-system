<?php

namespace App\Http\Requests\MultiStep;

use Illuminate\Foundation\Http\FormRequest;

class Step4Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transportation_company_ids' => ['nullable', 'array'],
            'transportation_company_ids.*' => ['exists:transportation_companies,id'],
            'other_service_ids' => ['nullable', 'array'],
            'other_service_ids.*' => ['exists:other_services,id'],
            'supplier_ids' => ['nullable', 'array'],
            'supplier_ids.*' => ['exists:suppliers,id'],
        ];
    }
}