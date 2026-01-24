@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\Region::count() > 0,
                'route' => route('regions.create'),
                'label' => __('main.regions'),
            ],
            [
                'condition' => \App\Models\Subregion::count() > 0,
                'route' => route('subregions.create'),
                'label' => __('main.subregions'),
            ],
            [
                'condition' => \App\Models\Country::count() > 0,
                'route' => route('countries.create'),
                'label' => __('main.countries'),
            ],
            [
                'condition' => \App\Models\State::count() > 0,
                'route' => route('states.create'),
                'label' => __('main.states'),
            ],
            [
                'condition' => \App\Models\City::count() > 0,
                'route' => route('cities.create'),
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
                            name <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            email <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            mobile_01 <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            gender <span class="text-red-600">*</span>
                        </th>
                        <th class="border px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            guide_type <span class="text-red-600">*</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Islam Alsayed</td>
                        <td class="border px-2">اسلام السيد</td>
                        <td class="border px-2">email@gmail.com</td>
                        <td class="border px-2">01012345678</td>
                        <td class="border px-2">male</td>
                        <td class="border px-2">General</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                        <th class="border px-2">mobile_02</th>
                        <th class="border px-2">home_city</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">2</td>
                        <td class="border px-2">3</td>
                        <td class="border px-2">4</td>
                        <td class="border px-2">5</td>
                        <td class="border px-2">01098765432</td>
                        <td class="border px-2">Cairo</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">birth_year</th>
                        <th class="border px-2">national_guide_id</th>
                        <th class="border px-2">currency_id</th>
                        <th class="border px-2">tourism_ministry_code</th>
                        <th class="border px-2">fd_day_fees</th>
                        <th class="border px-2">hd_day_fees</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1990</td>
                        <td class="border px-2">12345</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">TM-001</td>
                        <td class="border px-2">100.00</td>
                        <td class="border px-2">50.00</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">extra_fees_1</th>
                        <th class="border px-2">extra_fees_2</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">description</th>
                        <th class="border px-2">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">25.00</td>
                        <td class="border px-2">25.00</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Sample guide description</td>
                        <td class="border px-2">Additional notes for import</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
