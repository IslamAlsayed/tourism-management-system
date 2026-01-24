@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :model="$model" :view="$view"
        :requirements="[
            [
                'condition' => \App\Models\TransportationRoute::count() > 0,
                'route' => route('transportations.routes.create'),
                'label' => __('main.transportations-routes'),
            ],
            [
                'condition' => \App\Models\TransportationCompany::count() > 0,
                'route' => route('transportations.companies.create'),
                'label' => __('main.transportations-companies'),
            ],
            [
                'condition' => \App\Models\TransportationVehicleType::count() > 0,
                'route' => route('transportations.vehicle-types.create'),
                'label' => __('main.transportations-vehicle-types'),
            ],
        ]">
        <div class="mt-4">
            <a href="{{ route('export.data', ['models' => $models]) }}" class="kt-btn kt-btn-outline">
                {{ __('main.export') }}
            </a>
        </div>

        @if (env('DB_MODE') != 'production')
            <strong class="block mt-6 mb-2">{{ __('main.fields') }}</strong>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            route_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            company_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            vehicle_type_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">currency_id</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">base_price</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">price_per_km</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">price_per_person</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2</td>
                        <td class="border-custom px-2">3</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">500.00</td>
                        <td class="border-custom px-2">2.50</td>
                        <td class="border-custom px-2">50.00</td>
                    </tr>
                </tbody>
            </table>

            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">available_days</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">departure_time</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">arrival_time</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">frequency_per_day</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">[0,1,2,3,4,5,6]</td>
                        <td class="border-custom px-2">08:00:00</td>
                        <td class="border-custom px-2">10:00:00</td>
                        <td class="border-custom px-2">3</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">valid_from</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">valid_to</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">2025-01-01</td>
                        <td class="border-custom px-2">2025-12-31</td>
                        <td class="border-custom px-2">Daily service to Cairo</td>
                        <td class="border-custom px-2">Peak season pricing</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
