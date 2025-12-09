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
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border min-w-half divide-y text-center divide-gray-200">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name</th>
                        <th class="border px-2">code</th>
                        <th class="border px-2">type</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Saudi Arabian Airlines</td>
                        <td class="border px-2">SV</td>
                        <td class="border px-2">airline</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.optional_fields') }} -
                {{ __('main.basic_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">name_ar</th>
                        <th class="border px-2">description</th>
                        <th class="border px-2">service_type</th>
                        <th class="border px-2">status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">الخطوط الجوية السعودية</td>
                        <td class="border px-2">National carrier of Saudi Arabia</td>
                        <td class="border px-2">scheduled</td>
                        <td class="border px-2">active</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.fleet_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">fleet_size</th>
                        <th class="border px-2">aircraft_types</th>
                        <th class="border px-2">passenger_capacity</th>
                        <th class="border px-2">cargo_capacity</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">180</td>
                        <td class="border px-2">["Boeing 777","Airbus A320","Boeing 787"]</td>
                        <td class="border px-2">35000</td>
                        <td class="border px-2">5000</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.contact_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">phone</th>
                        <th class="border px-2">booking_phone</th>
                        <th class="border px-2">customer_service_phone</th>
                        <th class="border px-2">email</th>
                        <th class="border px-2">website</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">+966-11-454-5000</td>
                        <td class="border px-2">+966-11-454-6000</td>
                        <td class="border px-2">+966-11-454-7000</td>
                        <td class="border px-2">info@saudia.com</td>
                        <td class="border px-2">https://www.saudia.com</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.location_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">region_id</th>
                        <th class="border px-2">country_id</th>
                        <th class="border px-2">state_id</th>
                        <th class="border px-2">city_id</th>
                        <th class="border px-2">hub_airport</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1</td>
                        <td class="border px-2">194</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">RUH</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">address</th>
                        <th class="border px-2">postal_code</th>
                        <th class="border px-2">latitude</th>
                        <th class="border px-2">longitude</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">Saudi Airlines Building, Riyadh</td>
                        <td class="border px-2">11461</td>
                        <td class="border px-2">24.9576</td>
                        <td class="border px-2">46.6988</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.operational_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">established_date</th>
                        <th class="border px-2">is_active</th>
                        <th class="border px-2">is_international</th>
                        <th class="border px-2">is_domestic</th>
                        <th class="border px-2">has_frequent_flyer</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">1945-09-01</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                        <td class="border px-2">1</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.safety_performance') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">safety_rating</th>
                        <th class="border px-2">safety_rating_agency</th>
                        <th class="border px-2">on_time_performance</th>
                        <th class="border px-2">accident_count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">7.5</td>
                        <td class="border px-2">Skytrax</td>
                        <td class="border px-2">85.50</td>
                        <td class="border px-2">0</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.business_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">license_number</th>
                        <th class="border px-2">tax_number</th>
                        <th class="border px-2">annual_revenue</th>
                        <th class="border px-2">annual_passengers</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">AL-001-SVA</td>
                        <td class="border px-2">300123456789</td>
                        <td class="border px-2">5000000000.00</td>
                        <td class="border px-2">25000000</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.services_alliances') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">alliance</th>
                        <th class="border px-2">partnerships</th>
                        <th class="border px-2">codeshare_agreements</th>
                        <th class="border px-2">frequent_flyer_program</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">SkyTeam</td>
                        <td class="border px-2">["Emirates","Qatar Airways","Turkish Airlines"]</td>
                        <td class="border px-2">["EK - Emirates","QR - Qatar Airways"]</td>
                        <td class="border px-2">Alfursan</td>
                    </tr>
                </tbody>
            </table>

            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">certifications</th>
                        <th class="border px-2">destinations</th>
                        <th class="border px-2">services</th>
                        <th class="border px-2">cabin_classes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">["IATA IOSA","ISO 9001:2015","Skytrax 4-Star"]</td>
                        <td class="border px-2">["Riyadh (RUH)","Jeddah (JED)","Dubai (DXB)"]</td>
                        <td class="border px-2">["Passenger Transport","Cargo Services","VIP Lounge"]</td>
                        <td class="border px-2">["Economy","Business","First Class"]</td>
                    </tr>
                </tbody>
            </table>

            <strong class="block mt-6 mb-2">{{ __('main.additional_information') }}</strong>
            <table class="border min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="border px-2">notes</th>
                        <th class="border px-2">notes_ar</th>
                        <th class="border px-2">last_safety_audit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="border px-2">National flag carrier with extensive Middle East network</td>
                        <td class="border px-2">الناقل الوطني مع شبكة واسعة في الشرق الأوسط</td>
                        <td class="border px-2">2024-01-15 10:30:00</td>
                    </tr>
                </tbody>
            </table>
        @endif

    </x-import-form>
@endsection
