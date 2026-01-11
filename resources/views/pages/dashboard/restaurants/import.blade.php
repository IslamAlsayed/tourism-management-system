@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
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
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">type_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">timezone_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">currency_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">region_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">subregion_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">city_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Fakhreddin Restaurant</td>
                        <td class="border px-2">مطعم فخر الدين</td>
                        <td class="border px-2">5</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">8</td>
                        <td class="border px-2">4</td>
                        <td class="border px-2">15</td>
                        <td class="border px-2">250</td>
                    </tr>
                </tbody>
            </table>

            <!-- Location & Rating -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">rating</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">box</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">postal_code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">street</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">33.3128</td>
                        <td class="border px-2">44.3615</td>
                        <td class="border px-2">4.5</td>
                        <td class="border px-2">145</td>
                        <td class="border px-2">10001</td>
                        <td class="border px-2">Al-Rashid Street</td>
                    </tr>
                </tbody>
            </table>

            <!-- Contact Information -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">contact_person</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">phone_01</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">phone_02</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">mobile</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">fax</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">email_01</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">email_02</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">website</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Ahmed Al-Rashid</td>
                        <td class="border px-2">+964 1 417 7710</td>
                        <td class="border px-2">+964 1 417 7711</td>
                        <td class="border px-2">+964 790 1234567</td>
                        <td class="border px-2">+964 1 417 7799</td>
                        <td class="border px-2">info@fakhreddin.com</td>
                        <td class="border px-2">booking@fakhreddin.com</td>
                        <td class="border px-2">www.fakhreddin.com</td>
                    </tr>
                </tbody>
            </table>

            <!-- Additional Information -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">company_name</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">specialty</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">wheelchair_accessible</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">free_wifi</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">parking</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">swimming_pool</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">gym</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">شركة فخر الدين للتغذية</td>
                        <td class="border px-2">Middle Eastern Cuisine</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">0</td>
                    </tr>
                </tbody>
            </table>

            <!-- Amenities -->
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">indoor</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">outdoor</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">spa</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">photo</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">fakhreddin_01.jpg</td>
                        <td class="border px-2">Luxury dining with authentic Middle Eastern flavors</td>
                        <td class="border px-2">Prime location with excellent service and ambiance</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
