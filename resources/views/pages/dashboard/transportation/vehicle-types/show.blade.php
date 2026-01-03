@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.transportation-vehicle-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $vehicleType->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $vehicleType->company?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportation.vehicle-types.edit', $vehicleType->id) }}"
                    class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('transportation.vehicle-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportation-vehicle-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Transportation Vehicle Type Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.transportation-vehicle-type')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $vehicleType->name ?: __('main.na') }}</p>
                        </div>
                        @if ($vehicleType->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->name_ar }}</p>
                            </div>
                        @endif
                        @if ($vehicleType->min_capacity)
                            <div>
                                <label class="kt-label mb-1">
                                    {{ __('main.min_capacity') }} {{ __('main.pax') }}
                                </label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->min_capacity }}
                                    {{ __('main.pax') }}</p>
                            </div>
                        @endif
                        @if ($vehicleType->max_capacity)
                            <div>
                                <label class="kt-label mb-1">
                                    {{ __('main.max_capacity') }} {{ __('main.pax') }}
                                </label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->max_capacity }}
                                    {{ __('main.pax') }}</p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $vehicleType->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'is_active',
                                        'value' => (bool) $vehicleType->is_active,
                                        'table' => 'transportation_vehicle_types',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $vehicleType->id }}-has_luggage">
                                <label class="kt-label mb-1">{{ __('main.has_luggage') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'has_luggage',
                                        'value' => (bool) $vehicleType->has_luggage,
                                        'table' => 'transportation_vehicle_types',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $vehicleType->id }}-is_air_conditioning">
                                <label class="kt-label mb-1">{{ __('main.is_air_conditioning') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $vehicleType->id,
                                        'modelType' => '\\App\\Models\\TransportationVehicleType',
                                        'field' => 'is_air_conditioning',
                                        'value' => (bool) $vehicleType->is_air_conditioning,
                                        'table' => 'transportation_vehicle_types',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($vehicleType->description)
                        <div class="col-span-full border-custom rounded-lg mb-4 p-4">
                            <label class="kt-label mb-2">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $vehicleType->description !!}
                            </div>
                        </div>
                    @endif
                    @if ($vehicleType->notes)
                        <div class="col-span-full border-custom rounded-lg p-4">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $vehicleType->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($vehicleType->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $vehicleType->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($vehicleType->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $vehicleType->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $vehicleType->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company -->
            @if ($vehicleType->company)
                @include('pages.dashboard.related-components.transportation-company', [
                    'record' => $vehicleType->company,
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'transportation.vehicle-types',
                    'id' => $vehicleType->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'transportation.vehicle-types',
                    'id' => $vehicleType->id,
                ])
                <a href="{{ route('transportation.vehicle-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportation-vehicle-types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
