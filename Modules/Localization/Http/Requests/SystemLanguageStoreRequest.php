<?php

namespace Modules\Localization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemLanguageStoreRequest extends FormRequest
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
            "name" => "required|unique:system_languages,name",
            "name_ar" => "nullable|string",
            "code" => "required|unique:system_languages,code",
            "native" => "nullable|string|max:255",
            "dir" => "required|in:ltr,rtl",
            'photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120']
        ];
    }
}
