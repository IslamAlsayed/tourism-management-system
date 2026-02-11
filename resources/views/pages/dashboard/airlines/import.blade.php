@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view" :requirements="[
        [
            'condition' => \App\Models\Region::count() > 0,
            'route' => route('dashboard.geography.regions.create'),
            'label' => __('main.regions'),
        ],
        [
            'condition' => \App\Models\Subregion::count() > 0,
            'route' => route('dashboard.geography.subregions.create'),
            'label' => __('main.subregions'),
        ],
        [
            'condition' => \App\Models\Country::count() > 0,
            'route' => route('dashboard.geography.countries.create'),
            'label' => __('main.countries'),
        ],
        [
            'condition' => \App\Models\State::count() > 0,
            'route' => route('dashboard.geography.states.create'),
            'label' => __('main.states'),
        ],
        [
            'condition' => \App\Models\City::count() > 0,
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
                        <th class="border px-2">iata_code</th>
                        <th class="border px-2">icao_code</th>
                        <th class="border px-2">parent_airline_icao_code</th>
                        <th class="border px-2">marketing_name</th>
                        <th class="border px-2">official_full_name</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">SV</td>
                        <td class="border px-2">SVA</td>
                        <td class="border px-2">SVX</td>
                        <td class="border px-2">Saudia</td>
                        <td class="border px-2">Saudi Arabian Airlines</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">alliance</th>
                        <th class="border px-2">frequent_flyer_program_name</th>
                        <th class="border px-2">airline_type</th>
                        <th class="border px-2">airline_type_code</th>
                        <th class="border px-2">is_lowcost</th>
                        <th class="border px-2">airline_home_country</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">SkyTeam</td>
                        <td class="border px-2">Alfursan</td>
                        <td class="border px-2">Full Service</td>
                        <td class="border px-2">FSC</td>
                        <td class="border px-2">0</td>
                        <td class="border px-2">Saudi Arabia</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">airline_home_country_alpha_2_code</th>
                        <th class="border px-2">airline_home_country_alpha_3_code</th>
                        <th class="border px-2">airline_home_city_iata_code</th>
                        <th class="border px-2">year_of_foundation</th>
                        <th class="border px-2">email</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">SA</td>
                        <td class="border px-2">SAU</td>
                        <td class="border px-2">RUH</td>
                        <td class="border px-2">1945</td>
                        <td class="border px-2">info@saudia.com</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">official_website</th>
                        <th class="border px-2">baggage_policy_url</th>
                        <th class="border px-2">baggage_policy_url</th>
                        <th class="border px-2">web_check_in_url</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">https://www.saudia.com/baggage</td>
                        <td class="border px-2">https://www.saudia.com/baggage</td>
                        <td class="border px-2">https://www.saudia.com/web-checkin</td>
                        <td class="border px-2">https://www.saudia.com</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">timezone_id</th>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">subregion_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                        <th class="border px-2">local_phone_number</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">6</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">194</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">+966-11-408-0000</td>
                    </tr>
                </tbody>
            </table>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border px-2">international_phone_number</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">description</th>
                        <th class="border px-2">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">+966-11-408-0000</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">National carrier of Saudi Arabia</td>
                        <td class="border px-2">Flag carrier, based in Jeddah</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
