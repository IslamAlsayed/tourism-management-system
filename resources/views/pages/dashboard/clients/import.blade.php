@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Region::count() > 0,
                'route' => route('regions.create'),
                'label' => __('main.regions'),
            ],
            [
                'condition' => \App\Models\Subregion::count() > 0,
                'route' => route('subregions.create'),
                'label' => __('main.subregions'),
            ],
            [
                'condition' => \App\Models\Country::count() > 0,
                'route' => route('countries.create'),
                'label' => __('main.countries'),
            ],
            [
                'condition' => \App\Models\State::count() > 0,
                'route' => route('states.create'),
                'label' => __('main.states'),
            ],
            [
                'condition' => \App\Models\City::count() > 0,
                'route' => route('cities.create'),
                'label' => __('main.cities'),
            ],
            [
                'condition' => \App\Models\Nationality::count() > 0,
                'route' => route('nationalities.create'),
                'label' => __('main.nationalities'),
            ],
        ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">first_name</th>
                        <th class="border px-2">last_name</th>
                        <th class="border px-2">email_primary</th>
                        <th class="border px-2">primary_phone</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">John</td>
                        <td class="border px-2">Doe</td>
                        <td class="border px-2">john.doe@example.com</td>
                        <td class="border px-2">+1234567890</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }} -
                {{ __('main.personal_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">gender</th>
                        <th class="border px-2">nationality</th>
                        <th class="border px-2">birth_date</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">male</td>
                        <td class="border px-2">American</td>
                        <td class="border px-2">1990-01-15</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.passport_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">passport_number</th>
                        <th class="border px-2">passport_issue_date</th>
                        <th class="border px-2">passport_expiry_date</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">A12345678</td>
                        <td class="border px-2">2020-05-10</td>
                        <td class="border px-2">2030-05-10</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.contact_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">personal_email</th>
                        <th class="border px-2">work_email</th>
                        <th class="border px-2">secondary_email</th>
                        <th class="border px-2">secondary_phone</th>
                        <th class="border px-2">mobile_phone</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">personal@example.com</td>
                        <td class="border px-2">work@company.com</td>
                        <td class="border px-2">secondary@example.com</td>
                        <td class="border px-2">+0987654321</td>
                        <td class="border px-2">+1122334455</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">home_phone</th>
                        <th class="border px-2">work_phone</th>
                        <th class="border px-2">work_phone_ext</th>
                        <th class="border px-2">fax_number</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">+2233445566</td>
                        <td class="border px-2">+3344556677</td>
                        <td class="border px-2">123</td>
                        <td class="border px-2">+4455667788</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.location_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                        <td class="border px-2">5</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">box</th>
                        <th class="border px-2">postal_code</th>
                        <th class="border px-2">street_address</th>
                        <th class="border px-2">address_line_2</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">P.O. Box 1234</td>
                        <td class="border px-2">12345</td>
                        <td class="border px-2">123 Main Street</td>
                        <td class="border px-2">Apt 4B</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.company_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">company_name</th>
                        <th class="border px-2">job_title</th>
                        <th class="border px-2">sector</th>
                        <th class="border px-2">department</th>
                        <th class="border px-2">business_type</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">ABC Company</td>
                        <td class="border px-2">Manager</td>
                        <td class="border px-2">Tourism</td>
                        <td class="border px-2">Sales</td>
                        <td class="border px-2">B2B</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">business_registration_number</th>
                        <th class="border px-2">tax_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">CR-1234567890</td>
                        <td class="border px-2">TAX-9876543210</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.online_presence') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">website_url</th>
                        <th class="border px-2">linkedin_url</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">https://example.com</td>
                        <td class="border px-2">https://linkedin.com/in/johndoe</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.additional_settings') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">status</th>
                        <th class="border px-2">timezone</th>
                        <th class="border px-2">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">active</td>
                        <td class="border px-2">UTC</td>
                        <td class="border px-2">Important client notes here...</td>
                    </tr>
                </tbody>
            </table>
        @endif

    </x-import-form>
@endsection
