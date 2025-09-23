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
    ]">

        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
        <table class="border min-w-full divide-y text-center divide-gray-200">
            <thead>
                <tr>
                    <th class="border px-2">name</th>
                    <th class="border px-2">name_ar</th>
                    <th class="border px-2">iso2</th>
                    <th class="border px-2">iso3</th>
                    <th class="border px-2">timezone</th>
                    <th class="border px-2">currency_id</th>
                    <th class="border px-2">region_id</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="border px-2">Afghanistan</td>
                    <td class="border px-2">أفغانستان</td>
                    <td class="border px-2">AF</td>
                    <td class="border px-2">AFG</td>
                    <td class="border px-2">
                        [{"tzName": "Afghanistan Time","zoneName":"Asia/Kabul",...}]
                    </td>
                    <td class="border px-2">1</td>
                    <td class="border px-2">64</td>
                </tr>
            </tbody>
        </table>

        <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
        <table class="border min-w-full divide-y text-center divide-gray-200">
            <thead>
                <tr>
                    <th class="border px-2">numeric_code</th>
                    <th class="border px-2">phone_code</th>
                    <th class="border px-2">capital</th>
                    <th class="border px-2">tld</th>
                    <th class="border px-2">native</th>
                    <th class="border px-2">latitude</th>
                    <th class="border px-2">longitude</th>
                    <th class="border px-2">emoji</th>
                    <th class="border px-2">emojiU</th>
                    <th class="border px-2">population</th>
                    <th class="border px-2">flag_url</th>
                    <th class="border px-2">flag_emoji</th>
                    <th class="border px-2">continent</th>
                    <th class="border px-2">area</th>
                    <th class="border px-2">is_active</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="border px-2">4</td>
                    <td class="border px-2">93</td>
                    <td class="border px-2">Kabul</td>
                    <td class="border px-2">.af</td>
                    <td class="border px-2">افغانستان</td>
                    <td class="border px-2">33.000000</td>
                    <td class="border px-2">65.000000</td>
                    <td class="border px-2">🇦🇫</td>
                    <td class="border px-2">U+1F1E6 U+1F1EB</td>
                    <td class="border px-2">484641454</td>
                    <td class="border px-2">null</td>
                    <td class="border px-2">null</td>
                    <td class="border px-2">null</td>
                    <td class="border px-2">1</td>
                    <td class="border px-2">1</td>
                </tr>
            </tbody>
        </table>
    </x-import-form>
@endsection
