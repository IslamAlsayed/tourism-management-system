<?php

namespace App\Http\Requests\MultiStep;

use Illuminate\Foundation\Http\FormRequest;

class Step1Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'currency_id' => ['required', 'exists:currencies,id'],
        ];
    }
}