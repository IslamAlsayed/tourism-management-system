@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.transportations-pricing')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $pricing->company?->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $pricing->price }} • {{ $pricing->vehicleType?->name }} •
                    {{ $pricing->season?->name ?? __('main.no_season') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.pricings.edit', $pricing->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.transportation.pricings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-pricings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Transportations Pricing Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportations-pricing')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="font-semibold">
                                    {{ number_format($pricing->price, 2) }}
                                    {{ $pricing->pricingUnit?->name }}
                                    {{ $pricing->currency?->code }}
                                </span>
                            </p>
                        </div>
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $pricing->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $pricing->id,
                                        'modelType' => '\\Modules\\Transportation\\Entities\\Pricing',
                                        'field' => 'is_active',
                                        'value' => (bool) $pricing->is_active,
                                        'table' => 'transportations_pricings',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $pricing,
                        'column' => 'description',
                    ])
                    @include('components.elements.displayable-rich-text', [
                        'record' => $pricing,
                        'column' => 'notes',
                    ])
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $pricing])

            <!-- Company -->
            @if ($pricing->company)
                @include('pages.dashboard.related-components.transportations-company', [
                    'record' => $pricing->company,
                ])
            @endif

            <!-- VehicleType -->
            @if ($pricing->vehicleType)
                @include('pages.dashboard.related-components.transportations-vehicle-type', [
                    'record' => $pricing->vehicleType,
                ])
            @endif

            <!-- Season -->
            @if ($pricing->season)
                @include('pages.dashboard.related-components.season', [
                    'record' => $pricing->season,
                    'type' => 'transportation',
                ])
            @endif

            <!-- PricingUnit -->
            @if ($pricing->pricingUnit)
                @include('pages.dashboard.related-components.pricing-definition', [
                    'record' => $pricing->pricingUnit,
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.transportation.pricings',
                    'id' => $pricing->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'transportations.pricings',
                    'id' => $pricing->id,
                ])
                <a href="{{ route('dashboard.transportation.pricings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-pricings')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
