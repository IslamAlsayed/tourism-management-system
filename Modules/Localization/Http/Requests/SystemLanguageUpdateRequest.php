<?php

namespace Modules\Localization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SystemLanguageUpdateRequest extends FormRequest
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
        $id = $this->route('system_language');

        return [
            "name" => ["required", Rule::unique('system_languages', 'name')->ignore($id)],
            "name_ar" => "nullable|string",
            "code" => ["required", Rule::unique('system_languages', 'code')->ignore($id)],
            "native" => "nullable|string|max:255",
            "dir" => "required|in:ltr,rtl",
            'photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'],
            'selected_flag' => 'nullable|string'
        ];
    }
}
