@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
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
            [
                'condition' => \App\Models\Country::count() > 0,
                'route' => route('countries.index'),
                'label' => __('main.countries_'),
            ],
            [
                'condition' => \App\Models\State::count() > 0,
                'route' => route('states.index'),
                'label' => __('main.states_'),
            ],
            [
                'condition' => \App\Models\City::count() > 0,
                'route' => route('cities.index'),
                'label' => __('main.cities_'),
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
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2" title="{{ __('main.optional') }}">name_ar</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">country_id</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Egyptian</td>
                        <td class="border px-2">المصرية</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Sample description</td>
                        <td class="border px-2">Sample notes</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
