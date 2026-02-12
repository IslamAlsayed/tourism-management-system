@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Geography\Entities\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries'),
        ],
        [
            'condition' => \Modules\Geography\Entities\State::count() > 0,
            'route' => route('dashboard.geography.states.create'),
            'label' => __('main.states'),
        ],
        [
            'condition' => \Modules\Geography\Entities\City::count() > 0,
            'route' => route('dashboard.geography.cities.create'),
            'label' => __('main.cities'),
        ],
    ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name
                            <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            type
                            <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">sort_order</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_major</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Taba Crossing</td>
                        <td class="border px-2">land</td>
                        <td class="border px-2">TABA</td>
                        <td class="border px-2">معبر طابا</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">city_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">address</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">29.5866</td>
                        <td class="border px-2">34.7589</td>
                        <td class="border px-2">Taba, South Sinai Governorate, Egypt</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">operating_days</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">opening_time</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">closing_time</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">operating_hours</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_24_7</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_commercial</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">sunday,monday,tuesday</td>
                        <td class="border px-2">08:00</td>
                        <td class="border px-2">18:00</td>
                        <td class="border px-2">24/7 or custom hours</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_passenger</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_international</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">allows_visa_on_arrival</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_required</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">nationality_policy</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">["US", "UK", "CA"]</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">departure_tax</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">departure_tax_currency_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_fee</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_fee_currency_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_duration</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">25.00</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">75.00</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">30</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_conditions</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_application_url</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_policy_source</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">visa_last_update</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Valid passport required</td>
                        <td class="border px-2">https://visa.example.com</td>
                        <td class="border px-2">https://government.example.com/visa</td>
                        <td class="border px-2">2025-01-15</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">phone</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">email</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">website</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">+20690123456</td>
                        <td class="border px-2">info@taba.gov.eg</td>
                        <td class="border px-2">https://www.taba.gov.eg</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Primary crossing point between Egypt and Israel</td>
                        <td class="border px-2">Important transit hub</td>
                    </tr>
                </tbody>
            </table>
        @endif

    </x-import-form>
@endsection
