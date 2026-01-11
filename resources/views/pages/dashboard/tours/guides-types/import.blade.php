@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Currency::count() > 0,
                'route' => route('currencies.index'),
                'label' => __('main.currencies'),
            ],
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
            <table class="border min-w-full divide-y text-center divide-gray-200">
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
                        <th class="border px-2" title="{{ __('main.optional') }}">state_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">city_id</th>
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
                        <td class="border px-2">5 or 5,6,7,...</td>
                        <td class="border px-2">6 or 6,7,8,...</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">all_states</th>
                        <th class="border px-2">all_cities</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">null</td>
                        <td class="border px-2">all</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
