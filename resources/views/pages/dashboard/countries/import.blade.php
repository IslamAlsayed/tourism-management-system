@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Currency::count() > 0,
                'route' => route('currencies.index'),
                'label' => __('main.currencies_'),
            ],
            [
                'condition' => \App\Models\Region::count() > 0,
                'route' => route('regions.index'),
                'label' => __('main.regions_'),
            ],
            [
                'condition' => \App\Models\Subregion::count() > 0,
                'route' => route('subregions.index'),
                'label' => __('main.subregions_'),
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
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            iso2 <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            iso3 <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">timezone</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">currency_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">region_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">subregion_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">country</td>
                        <td class="border px-2">بلد</td>
                        <td class="border px-2">CO</td>
                        <td class="border px-2">CON</td>
                        <td class="border px-2">Country/country +0</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">numeric_code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">phone_code</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">capital</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">tld</th>
                        <th class="border px-2">native</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">population</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">4</td>
                        <td class="border px-2">93</td>
                        <td class="border px-2">native</td>
                        <td class="border px-2">.co</td>
                        <td class="border px-2">country</td>
                        <td class="border px-2">33.000000</td>
                        <td class="border px-2">65.000000</td>
                        <td class="border px-2">484641454</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_independent</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_developed</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_landlocked</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">language_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">photo</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">area</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
