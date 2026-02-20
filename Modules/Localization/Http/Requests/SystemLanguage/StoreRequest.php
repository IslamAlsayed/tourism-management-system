<?php

namespace Modules\Localization\Http\Requests\SystemLanguage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'unique:languages,name', Rule::unique('languages', 'name')->ignore($this->route('system_language'))],
            'code' => ['required', 'unique:languages,code', Rule::unique('languages', 'code')->ignore($this->route('system_language'))],
            'photo' => new \App\Rules\PhotoRules(),
        ];
    }
}
