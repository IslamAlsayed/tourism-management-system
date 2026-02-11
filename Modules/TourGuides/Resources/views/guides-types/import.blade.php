@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \Modules\Localization\Entities\Currency::count() > 0,
            'route' => route('dashboard.localization.currencies.create'),
            'label' => __('main.currencies'),
        ],
        [
            'condition' => \Modules\Geography\Entities\Region::count() > 0,
            'route' => route('dashboard.geography.regions.create'),
            'label' => __('main.regions'),
        ],
        [
            'condition' => \Modules\Geography\Entities\Subregion::count() > 0,
            'route' => route('dashboard.geography.subregions.create'),
            'label' => __('main.subregions'),
        ],
        [
            'condition' => \Modules\Geography\Entities\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries'),
        ],
        [
            'condition' => \Modules\Geography\Entities\State::count() > 0,
            'route' => route('dashboard.geography.states.create'),
            'label' => __('main.states'),
        ],
        [
            'condition' => \Modules\Geography\Entities\City::count() > 0,
            'route' => route('dashboard.geography.cities.create'),
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
                            type <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            price <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">currency_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">region_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">subregion_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Trails tour program</td>
                        <td class="border px-2">45.00</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">city_id</th>
                        <th class="border px-2">all_states</th>
                        <th class="border px-2">all_cities</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">[5] or [5,6,7]</td>
                        <td class="border px-2">[6] or [6,7,8]</td>
                        <td class="border px-2">1 or 0 or null</td>
                        <td class="border px-2">1 or 0 or null</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
