<?php

namespace App\Http\Requests\TransportationDepartments;

use Illuminate\Foundation\Http\FormRequest;

class TransportationDepartmentsUpdateRequest extends FormRequest
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
            'department' => ['nullable', 'string', 'max:255'],
            'company_id' => ['nullable', 'string', 'exists:transportation_companies,id'],
            'region_id' => ['nullable', 'string', 'exists:regions,id'],
            'subregion_id' => ['nullable', 'string', 'exists:subregions,id'],
            'country_id' => ['nullable', 'string', 'exists:countries,id'],
            'state_id' => ['nullable', 'string', 'exists:states,id'],
            'city_id' => ['nullable', 'string', 'exists:cities,id'],
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