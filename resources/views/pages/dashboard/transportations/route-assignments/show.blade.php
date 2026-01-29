@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.route-assignment')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $assignment->route->name ?? __('main.route-assignment') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $assignment->route->code ?? '' }} •
                    {{ $assignment->company->name ?? '' }} •
                    {{ $assignment->vehicleType->name ?? '' }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportations.route-assignments.edit', $assignment->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('transportations.route-assignments.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.route-assignments')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Assignment Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.assignment_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($assignment->route)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.route') }}</label>
                                <a href="{{ route('transportations.routes.show', $assignment->route->id) }}" class="block text-sm text-primary underline">
                                    {{ $assignment->route->name }}
                                    ({{ $assignment->route->originCity->name }} →
                                    {{ $assignment->route->destinationCity->name }})
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($assignment->company)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.company') }}</label>
                                <a href="{{ route('transportations.companies.show', $assignment->company->id) }}" class="block text-sm text-primary underline">
                                    {{ $assignment->company->name }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($assignment->vehicleType)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.vehicle_type') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $assignment->vehicleType->name }} ({{ $assignment->vehicleType->capacity }}
                                    {{ __('main.seats') }})
                                </p>
                            </div>
                        @endif
                        @if ($assignment->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $assignment->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $assignment->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $assignment->id,
                                    'modelType' => '\\App\\Models\\TransportationRouteAssignment',
                                    'field' => 'is_active',
                                    'value' => (bool) $assignment->is_active,
                                    'table' => 'transportations_route_assignments',
                                ])
                            </div>
                        </div>
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $assignment,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $assignment,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Information -->
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.pricing_information') }}</h3>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div>
                    <label class="kt-label mb-1">{{ __('main.base_price') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ number_format($assignment->base_price ?? 0, 2) }} {{ $assignment->currency->code ?? '' }}
                    </p>
                </div>
                <div>
                    <label class="kt-label mb-1">{{ __('main.price_per_km') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ number_format($assignment->price_per_km ?? 0, 2) }} {{ $assignment->currency->code ?? '' }}
                    </p>
                </div>
                <div>
                    <label class="kt-label mb-1">{{ __('main.price_per_person') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ number_format($assignment->price_per_person ?? 0, 2) }} {{ $assignment->currency->code ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Information -->
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.schedule_information') }}</h3>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @if ($assignment->departure_time)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.departure_time') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ substr($assignment->departure_time, 0, 5) }}
                        </p>
                    </div>
                @endif
                @if ($assignment->arrival_time)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.arrival_time') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ substr($assignment->arrival_time, 0, 5) }}
                        </p>
                    </div>
                @endif
                <div>
                    <label class="kt-label mb-1">{{ __('main.frequency_per_day') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ $assignment->frequency_per_day ?? 1 }} {{ __('main.times') }}
                    </p>
                </div>
            </div>

            @php
                $availableDays = is_array($assignment->available_days) ? $assignment->available_days : json_decode($assignment->available_days ?? '[]', true);
            @endphp
            @if (!empty($availableDays))
                <div class="mt-4">
                    <label class="kt-label mb-2">{{ __('main.available_days') }}</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($availableDays as $day)
                            <span class="kt-badge kt-badge-info">{{ __('main.' . $day) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Validity Period -->
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.validity_period') }}</h3>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @if ($assignment->valid_from)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.valid_from') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $assignment->valid_from->format('Y-m-d') }}
                        </p>
                    </div>
                @endif
                @if ($assignment->valid_to)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.valid_to') }}</label>
                        <p class="text-sm text-secondary-foreground">
                            {{ $assignment->valid_to->format('Y-m-d') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if ($assignment->description || $assignment->notes)
        <div class="kt-card">
            <div class="kt-card-header">
                <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
            </div>
            <div class="kt-card-body p-4">
                <div class="grid gap-6">
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $assignment,
                        'column' => 'description',
                    ])
                    @include('components.elements.display-desc-or-notes', [
                        'record' => $assignment,
                        'column' => 'notes',
                    ])
                </div>
            </div>
        </div>
    @endif

    <!-- Metadata -->
    <div class="kt-card">
        <div class="kt-card-header">
            <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
        </div>
        <div class="kt-card-body p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                @if ($assignment->creator)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $assignment->creator->name }}</p>
                    </div>
                @endif
                <div>
                    <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ $assignment->created_at?->format('Y-m-d H:i:s') }}
                    </p>
                </div>
                @if ($assignment->updater)
                    <div>
                        <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                        <p class="text-sm text-secondary-foreground">{{ $assignment->updater->name }}</p>
                    </div>
                @endif
                <div>
                    <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                    <p class="text-sm text-secondary-foreground">
                        {{ $assignment->updated_at?->format('Y-m-d H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-4">
        @include('components.elements.edit-button', [
            'models' => 'transportations.route-assignments',
            'id' => $assignment->id,
        ])
        @include('components.elements.delete-form', [
            'model' => 'transportations.route-assignments',
            'id' => $assignment->id,
        ])
        <a href="{{ route('transportations.route-assignments.index') }}" class="kt-btn kt-btn-outline">
            {{ __('main.back_to_types', ['types' => __('main.route-assignments')]) }}
        </a>
    </div>
    </div>
    </div>
@endsection
