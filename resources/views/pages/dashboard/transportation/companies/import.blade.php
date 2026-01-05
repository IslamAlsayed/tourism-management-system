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
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            code <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">rating</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">currency_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">region_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">subregion_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">city_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">Egypt Transport Company</td>
                        <td class="border-custom px-2">شركة مصر للنقل السياحي</td>
                        <td class="border-custom px-2">TC-4126</td>
                        <td class="border-custom px-2">5</td>
                        <td class="border-custom px-2">24</td>
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
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">email</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">phone</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">mobile</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">fax</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">street</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">info@example.com</td>
                        <td class="border-custom px-2">0112345678</td>
                        <td class="border-custom px-2">0551234567</td>
                        <td class="border-custom px-2">0551234567</td>
                        <td class="border-custom px-2">123 Main St</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">postal_code</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">website</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">11564</th>
                        <td class="border-custom px-2">24.7136</th>
                        <td class="border-custom px-2">46.6753</th>
                        <td class="border-custom px-2">www.example.com</th>
                        <td class="border-custom px-2">1</th>
                        <td class="border-custom px-2">Reliable transportation company</th>
                        <td class="border-custom px-2">Operates 24/7</th>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
