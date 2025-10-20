<?php

namespace App\Http\Requests\TransportationDepartments;

use Illuminate\Foundation\Http\FormRequest;

class TransportationDepartmentsCreateRequest extends FormRequest
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
            'department' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'string', 'exists:companies,id'],
            'region_id' => ['required', 'string', 'exists:regions,id'],
            'subregion_id' => ['required', 'string', 'exists:subregions,id'],
            'country_id' => ['required', 'string', 'exists:countries,id'],
            'state_id' => ['required', 'string', 'exists:states,id'],
            'city_id' => ['required', 'string', 'exists:cities,id'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone_01' => ['nullable', 'string', 'max:20'],
            'phone_02' => ['nullable', 'string', 'max:20'],
            'email_01' => ['nullable', 'email', 'max:255'],
            'email_02' => ['nullable', 'email', 'max:255'],
            'fax' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'website' => ['nullable', 'url'],
        ];
    }
}