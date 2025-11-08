@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
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
        [
            'condition' => \App\Models\State::count() > 0,
            'route' => route('states.create'),
            'label' => __('main.states_'),
        ],
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">city</td>
                        <td class="border px-2">مدينة</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">wikiDataId</th>
                        <th class="border px-2">population</th>
                        <th class="border px-2">timezone</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">42.50779</td>
                        <td class="border px-2">1.52109</td>
                        <td class="border px-2">Q1863</td>
                        <td class="border px-2">468416843</td>
                        <td class="border px-2">City/city +0</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
