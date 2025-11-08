@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
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
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">iso2</th>
                        <th class="border px-2">iso3</th>
                        <th class="border px-2">timezone</th>
                        <th class="border px-2">currency_id</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">country</td>
                        <td class="border px-2">بلد</td>
                        <td class="border px-2">CO</td>
                        <td class="border px-2">CON</td>
                        <td class="border px-2">Country/country +0</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4 or 4,5,6,...</td>
                        <td class="border px-2">5 or 5,6,7,...</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">numeric_code</th>
                        <th class="border px-2">phone_code</th>
                        <th class="border px-2">capital</th>
                        <th class="border px-2">tld</th>
                        <th class="border px-2">native</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">population</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
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

            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">is_independent</th>
                        <th class="border px-2">is_developed</th>
                        <th class="border px-2">is_landlocked</th>
                        <th class="border px-2">language_id</th>
                        <th class="border px-2">photo</th>
                        <th class="border px-2">area</th>
                        <th class="border px-2">is_active</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
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
