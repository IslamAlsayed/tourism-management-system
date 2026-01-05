@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :view="$view" :requirements="[
        [
            'condition' => \App\Models\Region::count() > 0,
            'route' => route('regions.index'),
            'label' => __('main.regions'),
        ],
        [
            'condition' => \App\Models\Subregion::count() > 0,
            'route' => route('subregions.index'),
            'label' => __('main.subregions'),
        ],
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.index'),
            'label' => __('main.countries'),
        ],
        [
            'condition' => \App\Models\State::count() > 0,
            'route' => route('states.index'),
            'label' => __('main.states'),
        ],
        [
            'condition' => \App\Models\City::count() > 0,
            'route' => route('cities.index'),
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
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">classification</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">stars</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">region_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">subregion_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">city_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Hotel Example</td>
                        <td class="border-custom px-2">فندق المثال</td>
                        <td class="border-custom px-2">hotel</td>
                        <td class="border-custom px-2">5</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2</td>
                        <td class="border-custom px-2">3</td>
                        <td class="border-custom px-2">4</td>
                        <td class="border-custom px-2">5</td>
                    </tr>
                </tbody>
            </table>

            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">general_mobile</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">general_email</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">email</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">website</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">phone</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">Luxury hotel in city center</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">1</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">0551234567</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">info@example.com</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contact@example.com</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">www.example.com</td>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">0112345678</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">phone_ext</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">fax</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contact_person</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contact_position</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contact_mobile</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contact_email</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">123</td>
                        <td class="border-custom px-2">0112345679</td>
                        <td class="border-custom px-2">John Doe</td>
                        <td class="border-custom px-2">Manager</td>
                        <td class="border-custom px-2">0559876543</td>
                        <td class="border-custom px-2">johndoe@example.com</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">street</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">box</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">postal_code</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">contract_file_path
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">default_currency
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">
                            accommodation_type_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">King Fahd Road</td>
                        <td class="border-custom px-2">PO Box 123</td>
                        <td class="border-custom px-2">11564</td>
                        <td class="border-custom px-2">24.7136</td>
                        <td class="border-custom px-2">46.6753</td>
                        <td class="border-custom px-2">contracts/hotel_example.pdf</td>
                        <td class="border-custom px-2">SAR</td>
                        <td class="border-custom px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
