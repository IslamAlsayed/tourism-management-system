@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.airline')]))

@push('scripts')
    @include('components.scripts.setup-map')
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $airline->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.view_type_description', ['type' => __('main.airline')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('airlines.edit', $airline->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('airlines.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.airlines')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.airline')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($airline->name)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.name') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->name ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($airline->name_ar)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.name_ar') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->name_ar ?? '-' }}</p>
                            </div>
                        @endif
                        @if ($airline->code)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.code') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span
                                        class="kt-badge kt-badge-outline kt-badge-primary">{{ $airline->code ?? '-' }}</span>
                                </p>
                            </div>
                        @endif
                        @if ($airline->type)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.type') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span class="kt-badge kt-badge-light-primary">
                                        {{ $airline->type ? __('main.' . $airline->type) : '-' }}
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($airline->service_type)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.service_type') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span class="kt-badge kt-badge-light-info">
                                        {{ $airline->service_type ? __('main.' . $airline->service_type) : '-' }}
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.established_date') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airline->established_date ? $airline->established_date->format('Y-m-d') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.hub_airport') }}</label>
                            <p class="mt-1 text-gray-900">{{ $airline->hub_airport ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $airline->id,
                                    'modelType' => '\\App\\Models\\Airline',
                                    'field' => 'is_active',
                                    'value' => (bool) $airline->is_active,
                                    'table' => 'airlines',
                                ])
                            </div>
                        </div>
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $airline,
                            'column' => 'description',
                        ])

                        @include('components.elements.display-desc-or-notes', [
                            'record' => $airline,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            {{-- Fleet Information --}}
            {{-- <div class="kt-card hidden">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.fleet_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.fleet_size') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airline->fleet_size ?? '-' }}
                                @if ($airline->fleet_size)
                                    <span class="text-sm text-gray-500">{{ __('main.aircraft') }}</span>
                                @endif
                            </p>
                        </div>

                        @if ($airline->passenger_capacity)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.passenger_capacity') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ number_format($airline->passenger_capacity) }}
                                    <span class="text-sm text-gray-500">{{ __('main.passengers') }}</span>
                                </p>
                            </div>
                        @endif

                        @if ($airline->cargo_capacity)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.cargo_capacity') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ number_format($airline->cargo_capacity) }}
                                    <span class="text-sm text-gray-500">{{ __('main.tons') }}</span>
                                </p>
                            </div>
                        @endif

                        @if ($airline->aircraft_types && is_array($airline->aircraft_types))
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="font-medium text-gray-700">{{ __('main.aircraft_types') }}</label>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($airline->aircraft_types as $aircraft)
                                        <span
                                            class="kt-badge kt-badge-outline kt-badge-secondary">{{ $aircraft }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}

            <!-- Map -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.map') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($airline->latitude && $airline->longitude)
                        <div>
                            <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $airline->latitude }}, {{ $airline->longitude }}
                            </p>
                        </div>
                        <div class="col-span-full mt-4">
                            <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                            <a href="https://maps.google.com?q={{ $airline->latitude }},{{ $airline->longitude }}"
                                target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $airline->title }}"
                                    data-latitude="{{ $airline->latitude }}" data-longitude="{{ $airline->longitude }}"
                                    class="rounded-md overflow-hidden shadow"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($airline->local_phone_number)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.local_phone_number') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="tel:{{ $airline->local_phone_number }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airline->local_phone_number }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($airline->international_phone_number)
                            <div>
                                <label
                                    class="font-medium text-gray-700">{{ __('main.international_phone_number') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="tel:{{ $airline->international_phone_number }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airline->international_phone_number }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($airline->website)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.website') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="{{ $airline->website }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airline->website }}
                                        <i class="fas fa-external-link-alt text-xs ml-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @if ($airline->region)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.region') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->region?->name }}</p>
                            </div>
                        @endif
                        @if ($airline->subregion)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.subregion') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($airline->country)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.country') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->country?->name }}</p>
                            </div>
                        @endif
                        @if ($airline->state)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.state') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->state?->name }}</p>
                            </div>
                        @endif
                        @if ($airline->city)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.city') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airline->city?->name }}</p>
                            </div>
                        @endif
                        @if ($airline->latitude && $airline->longitude)
                            <div class="col-span-full">
                                <label class="font-medium text-gray-700">{{ __('main.coordinates') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ $airline->latitude }}, {{ $airline->longitude }}
                                    <a href="https://maps.google.com/?q={{ $airline->latitude }},{{ $airline->longitude }}"
                                        target="_blank" class="text-blue-600 hover:text-blue-800 ml-2">
                                        <i class="fas fa-map-marker-alt"></i> {{ __('main.view_on_map') }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Safety & Performance --}}
            {{-- <div class="kt-card hidden">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.safety_performance') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($airline->safety_rating)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.safety_rating') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span class="text-xl font-bold text-green-600">{{ $airline->safety_rating }}/10</span>
                                    @if ($airline->safety_rating_agency)
                                        <span
                                            class="text-sm text-gray-500 block">{{ $airline->safety_rating_agency }}</span>
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if ($airline->on_time_performance)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.on_time_performance') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span
                                        class="text-xl font-bold text-blue-600">{{ $airline->on_time_performance }}%</span>
                                </p>
                            </div>
                        @endif

                        @if ($airline->alliance)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.alliance') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span class="kt-badge kt-badge-light-primary">{{ $airline->alliance }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div> --}}

            {{-- Operational Status --}}
            {{-- <div class="kt-card hidden">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operational_status') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.active') }}</label>
                            <p class="mt-2">
                                <span class="kt-badge kt-badge-light-{{ $airline->is_active ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $airline->is_active ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airline->is_active ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.international') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airline->is_international ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $airline->is_international ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airline->is_international ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.domestic') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airline->is_domestic ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $airline->is_domestic ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airline->is_domestic ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.frequent_flyer_program') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airline->has_frequent_flyer ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $airline->has_frequent_flyer ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airline->has_frequent_flyer ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($airline->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $airline->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $airline->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($airline->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $airline->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $airline->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'airlines',
                    'id' => $airline->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'airlines',
                    'id' => $airline->id,
                ])
                <a href="{{ route('airlines.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.airlines')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
