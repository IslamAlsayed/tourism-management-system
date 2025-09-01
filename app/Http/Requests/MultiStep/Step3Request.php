<?php

namespace App\Http\Requests\MultiStep;

use Illuminate\Foundation\Http\FormRequest;

class Step3Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rate_ids' => ['required', 'array', 'min:1'],
            'rate_ids.*' => ['exists:rates,id'],
            'supplement_ids' => ['nullable', 'array'],
            'supplement_ids.*' => ['exists:supplements,id'],
            'policy_ids' => ['nullable', 'array'],
            'policy_ids.*' => ['exists:policies,id'],
        ];
    }
}