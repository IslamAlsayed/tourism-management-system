@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :view="$view" :requirements="[
        [
            'condition' => \App\Models\Region::count() > 0,
            'route' => route('regions.create'),
            'label' => __('main.regions_'),
        ],
        [
            'condition' => \App\Models\Subregion::count() > 0,
            'route' => route('subregions.create'),
            'label' => __('main.subregions_'),
        ],
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.create'),
            'label' => __('main.countries_'),
        ],
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">iso2</th>
                        <th class="border px-2">iso3</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">city_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">state</td>
                        <td class="border px-2">ولاية</td>
                        <td class="border px-2">ST</td>
                        <td class="border px-2">STA</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4 or 4,5,6,...</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">timezone</th>
                        <th class="border px-2">fips_code</th>
                        <th class="border px-2">type</th>
                        <th class="border px-2">level</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">42.50779</td>
                        <td class="border px-2">1.52109</td>
                        <td class="border px-2">State/state +0</td>
                        <td class="border px-2">46</td>
                        <td class="border px-2">province</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
