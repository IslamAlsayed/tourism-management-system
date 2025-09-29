@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('countries.index'),
            'label' => __('main.countries_'),
        ],
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_Mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">iso2</th>
                        <th class="border px-2">iso3</th>
                        <th class="border px-2">timezone</th>
                        <th class="border px-2">country_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Banwa</td>
                        <td class="border px-2">BAN</td>
                        <td class="border px-2">BF-BAN</td>
                        <td class="border px-2">Africa/Ouagadougou</td>
                        <td class="border px-2">35</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">fips_code</th>
                        <th class="border px-2">type</th>
                        <th class="border px-2">level</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">parent_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">46</td>
                        <td class="border px-2">province</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">12.226557</td>
                        <td class="border px-2">-4.191334</td>
                        <td class="border px-2">3138</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
