<?php

namespace Modules\Localization\Http\Requests\SystemLanguage;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $languageId = $this->route('system_language')?->id ?? $this->route('system_language');

        return [
            'name' => ['nullable', Rule::unique('system_languages', 'name')->ignore($languageId, 'id')],
            'code' => ['nullable', Rule::unique('system_languages', 'code')->ignore($languageId, 'id')],
            'photo' => new \App\Rules\PhotoRules(),
        ];
    }
}