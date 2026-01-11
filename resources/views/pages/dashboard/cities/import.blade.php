@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
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
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">city</td>
                        <td class="border px-2">مدينة</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">latitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">longitude</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">wiki_data_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">population</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">timezone</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">42.50779</td>
                        <td class="border px-2">1.52109</td>
                        <td class="border px-2">Q1863</td>
                        <td class="border px-2">468416843</td>
                        <td class="border px-2">Asia/Kabul</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
