@extends('layouts.master')

@section('content')
    <x-import-form :title="$title" :description="$description" :models="$models" :view="$view" :requirements="[
        [
            'condition' => \App\Models\TransportationCompany::count() > 0,
            'route' => route('transportation.companies.index'),
            'label' => __('main.transportation-companies'),
        ],
        [
            'condition' => \App\Models\TransportationVehicleType::count() > 0,
            'route' => route('transportation.vehicle-types.index'),
            'label' => __('main.transportation-vehicle-types'),
        ],
        [
            'condition' => \App\Models\Season::count() > 0,
            'route' => route('seasons.index'),
            'label' => __('main.seasons'),
        ],
        [
            'condition' => \App\Models\PricingDefinition::count() > 0,
            'route' => route('pricing-definitions.index'),
            'label' => __('main.pricing-definitions'),
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
                            price <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            company_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            vehicle_type_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            season_id <span class="text-red-600">*</span>
                        </th>
                        <th class="border-custom px-2 bg-yellow-100" title="{{ __('main.required') }}">
                            pricing_unit_id <span class="text-red-600">*</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">452</td>
                        <td class="border-custom px-2">3</td>
                        <td class="border-custom px-2">2</td>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">1</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-custom min-w-full divide-y text-center divide-gray-200 mb-4">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">is_active</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">description</th>
                        <th class="border-custom px-2" title="{{ __('main.optional') }}">notes</th>
                    </tr>
                </thead>
                <tbody class="background divide-y divide-gray-200">
                    <tr>
                        <td class="border-custom px-2">1</td>
                        <td class="border-custom px-2">A comfortable microbus for city tours.</td>
                        <td class="border-custom px-2">Includes Wi-Fi and refreshments.</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </x-import-form>
@endsection
