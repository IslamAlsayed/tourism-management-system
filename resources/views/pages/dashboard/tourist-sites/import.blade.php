@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :requirements="[
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
            <strong class="block mt-6 mb-2">{{ __('main.required_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">description</th>
                        <th class="border px-2">site_type</th>
                        <th class="border px-2">category</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Great Pyramid of Giza</td>
                        <td class="border px-2">الهرم الأكبر بالجيزة</td>
                        <td class="border px-2">Ancient pyramid wonder</td>
                        <td class="border px-2">historical</td>
                        <td class="border px-2">monument</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">description_ar</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                        <th class="border px-2">address</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                        <th class="border px-2">entry_fee_adult</th>
                        <th class="border px-2">currency</th>
                        <th class="border px-2">is_free_entry</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">الوصف بالعربية</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">Giza, Egypt</td>
                        <td class="border px-2">29.9792</td>
                        <td class="border px-2">31.1342</td>
                        <td class="border px-2">200.00</td>
                        <td class="border px-2">EGP</td>
                        <td class="border px-2">0</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200">
                <thead style="background-color: #ffea00;">
                    <tr>
                        <th class="border px-2">opening_time</th>
                        <th class="border px-2">closing_time</th>
                        <th class="border px-2">mobile</th>
                        <th class="border px-2">email</th>
                        <th class="border px-2">website_url</th>
                        <th class="border px-2">facilities</th>
                        <th class="border px-2">activities</th>
                        <th class="border px-2">services</th>
                        <th class="border px-2">is_featured</th>
                        <th class="border px-2">wheelchair_accessible</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">08:00</td>
                        <td class="border px-2">17:00</td>
                        <td class="border px-2">+201234567890</td>
                        <td class="border px-2">info@site.com</td>
                        <td class="border px-2">https://website.com</td>
                        <td class="border px-2">["parking","restrooms"]</td>
                        <td class="border px-2">["sightseeing","photography"]</td>
                        <td class="border px-2">["guided_tours","cafe"]</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
