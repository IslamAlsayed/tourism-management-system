@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
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
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">classification</th>
                        <th class="border px-2">stars</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Hotel Example</td>
                        <td class="border px-2">hotel</td>
                        <td class="border px-2">5</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                        <td class="border px-2">5</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">id</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">description</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">general_mobile</th>
                        <th class="border px-2">general_email</th>
                        <th class="border px-2">email</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">10</td>
                        <td class="border px-2">فندق المثال</td>
                        <td class="border px-2">Luxury hotel in city center</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">0551234567</td>
                        <td class="border px-2">info@example.com</td>
                        <td class="border px-2">contact@example.com</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">website</th>
                        <th class="border px-2">phone</th>
                        <th class="border px-2">phone_ext</th>
                        <th class="border px-2">fax</th>
                        <th class="border px-2">contact_person</th>
                        <th class="border px-2">contact_position</th>
                        <th class="border px-2">contact_mobile</th>
                        <th class="border px-2">contact_email</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">www.example.com</td>
                        <td class="border px-2">0112345678</td>
                        <td class="border px-2">123</td>
                        <td class="border px-2">0112345679</td>
                        <td class="border px-2">John Doe</td>
                        <td class="border px-2">Manager</td>
                        <td class="border px-2">0559876543</td>
                        <td class="border px-2">johndoe@example.com</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">street</th>
                        <th class="border px-2">box</th>
                        <th class="border px-2">postal_code</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">contract_file_path</th>
                        <th class="border px-2">default_currency</th>
                        <th class="border px-2">accommodation_type_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">King Fahd Road</td>
                        <td class="border px-2">PO Box 123</td>
                        <td class="border px-2">11564</td>
                        <td class="border px-2">24.7136</td>
                        <td class="border px-2">46.6753</td>
                        <td class="border px-2">contracts/hotel_example.pdf</td>
                        <td class="border px-2">SAR</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
