@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
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
    ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['model' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (config('app.db_mode') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">department</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Commercial Manager</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">23</td>
                        <td class="border px-2">111</td>
                        <td class="border px-2">965</td>
                        <td class="border px-2">63141</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2">contact_person</th>
                        <th class="border px-2">mobile</th>
                        <th class="border px-2">phone_01</th>
                        <th class="border px-2">phone_02</th>
                        <th class="border px-2">email_01</th>
                        <th class="border px-2">email_02</th>
                        <th class="border px-2">fax</th>
                        <th class="border px-2">address</th>
                        <th class="border px-2">website</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                        <td class="border px-2">null</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
