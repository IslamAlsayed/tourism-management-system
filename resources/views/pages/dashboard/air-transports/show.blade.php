@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.air_transport')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $airTransport->display_name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.view_type_description', ['type' => __('main.air_transport')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('air-transports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.air_transports')]) }}
                </a>
                <a href="{{ route('air-transports.edit', $airTransport->id) }}" class="kt-btn kt-btn-primary">
                    {{ __('main.edit') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="space-y-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.name') }}</label>
                            <p class="mt-1 text-gray-900">{{ $airTransport->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.name_ar') }}</label>
                            <p class="mt-1 text-gray-900" dir="rtl">{{ $airTransport->name_ar ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.code') }}</label>
                            <p class="mt-1 text-gray-900">
                                <span
                                    class="kt-badge kt-badge-outline kt-badge-primary">{{ $airTransport->code ?? '-' }}</span>
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.type') }}</label>
                            <p class="mt-1 text-gray-900">
                                <span class="kt-badge kt-badge-light-primary">
                                    {{ $airTransport->type ? __('main.' . $airTransport->type) : '-' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.service_type') }}</label>
                            <p class="mt-1 text-gray-900">
                                <span class="kt-badge kt-badge-light-info">
                                    {{ $airTransport->service_type ? __('main.' . $airTransport->service_type) : '-' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.status') }}</label>
                            <p class="mt-1 text-gray-900">
                                @if ($airTransport->status)
                                    <span
                                        class="kt-badge kt-badge-light-{{ $airTransport->status == 'active' ? 'success' : ($airTransport->status == 'suspended' ? 'warning' : 'danger') }}">
                                        {{ __('main.' . $airTransport->status) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.established_date') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airTransport->established_date ? $airTransport->established_date->format('Y-m-d') : '-' }}
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.hub_airport') }}</label>
                            <p class="mt-1 text-gray-900">{{ $airTransport->hub_airport ?? '-' }}</p>
                        </div>

                        @if ($airTransport->description)
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="font-medium text-gray-700">{{ __('main.description') }}</label>
                                <div class="mt-1 text-gray-900 prose max-w-none">
                                    {!! $airTransport->description !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Fleet Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.fleet_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.fleet_size') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airTransport->fleet_size ?? '-' }}
                                @if ($airTransport->fleet_size)
                                    <span class="text-sm text-gray-500">{{ __('main.aircraft') }}</span>
                                @endif
                            </p>
                        </div>

                        @if ($airTransport->passenger_capacity)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.passenger_capacity') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ number_format($airTransport->passenger_capacity) }}
                                    <span class="text-sm text-gray-500">{{ __('main.passengers') }}</span>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->cargo_capacity)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.cargo_capacity') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ number_format($airTransport->cargo_capacity) }}
                                    <span class="text-sm text-gray-500">{{ __('main.tons') }}</span>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->aircraft_types && is_array($airTransport->aircraft_types))
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="font-medium text-gray-700">{{ __('main.aircraft_types') }}</label>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($airTransport->aircraft_types as $aircraft)
                                        <span
                                            class="kt-badge kt-badge-outline kt-badge-secondary">{{ $aircraft }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($airTransport->phone)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.phone') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="tel:{{ $airTransport->phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $airTransport->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->booking_phone)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.booking_phone') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="tel:{{ $airTransport->booking_phone }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airTransport->booking_phone }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->customer_service_phone)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.customer_service_phone') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="tel:{{ $airTransport->customer_service_phone }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airTransport->customer_service_phone }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->email)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.email') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="mailto:{{ $airTransport->email }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $airTransport->email }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->website)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.website') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <a href="{{ $airTransport->website }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800">
                                        {{ $airTransport->website }}
                                        <i class="fas fa-external-link-alt text-xs ml-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->address)
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="font-medium text-gray-700">{{ __('main.address') }}</label>
                                <div class="mt-1 text-gray-900 prose max-w-none">
                                    {!! $airTransport->address !!}
                                </div>
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
                        @if ($airTransport->region)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.region') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airTransport->region->display_name }}</p>
                            </div>
                        @endif

                        @if ($airTransport->country)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.country') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airTransport->country->display_name }}</p>
                            </div>
                        @endif

                        @if ($airTransport->state)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.state') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airTransport->state->display_name }}</p>
                            </div>
                        @endif

                        @if ($airTransport->city)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.city') }}</label>
                                <p class="mt-1 text-gray-900">{{ $airTransport->city->display_name }}</p>
                            </div>
                        @endif

                        @if ($airTransport->latitude && $airTransport->longitude)
                            <div class="md:col-span-2">
                                <label class="font-medium text-gray-700">{{ __('main.coordinates') }}</label>
                                <p class="mt-1 text-gray-900">
                                    {{ $airTransport->latitude }}, {{ $airTransport->longitude }}
                                    <a href="https://maps.google.com/?q={{ $airTransport->latitude }},{{ $airTransport->longitude }}"
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
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.safety_performance') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if ($airTransport->safety_rating)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.safety_rating') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span
                                        class="text-xl font-bold text-green-600">{{ $airTransport->safety_rating }}/10</span>
                                    @if ($airTransport->safety_rating_agency)
                                        <span
                                            class="text-sm text-gray-500 block">{{ $airTransport->safety_rating_agency }}</span>
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->on_time_performance)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.on_time_performance') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span
                                        class="text-xl font-bold text-blue-600">{{ $airTransport->on_time_performance }}%</span>
                                </p>
                            </div>
                        @endif

                        @if ($airTransport->alliance)
                            <div>
                                <label class="font-medium text-gray-700">{{ __('main.alliance') }}</label>
                                <p class="mt-1 text-gray-900">
                                    <span class="kt-badge kt-badge-light-primary">{{ $airTransport->alliance }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Operational Status --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operational_status') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.active') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airTransport->is_active ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $airTransport->is_active ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airTransport->is_active ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.international') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airTransport->is_international ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $airTransport->is_international ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airTransport->is_international ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.domestic') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airTransport->is_domestic ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $airTransport->is_domestic ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airTransport->is_domestic ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="font-medium text-gray-700 block">{{ __('main.frequent_flyer_program') }}</label>
                            <p class="mt-2">
                                <span
                                    class="kt-badge kt-badge-light-{{ $airTransport->has_frequent_flyer ? 'success' : 'secondary' }}">
                                    <i
                                        class="fas fa-{{ $airTransport->has_frequent_flyer ? 'check' : 'times' }} mr-1"></i>
                                    {{ $airTransport->has_frequent_flyer ? __('main.yes') : __('main.no') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($airTransport->notes)
                {{-- Additional Notes --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_notes') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="prose max-w-none">
                            {!! $airTransport->notes !!}
                        </div>
                    </div>
                </div>
            @endif

            {{-- System Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.system_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.created_by') }}</label>
                            <p class="mt-1 text-gray-900">{{ $airTransport->creator->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.updated_by') }}</label>
                            <p class="mt-1 text-gray-900">{{ $airTransport->updater->name ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.created_at') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airTransport->created_at ? $airTransport->created_at->format('Y-m-d H:i') : '-' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">{{ __('main.updated_at') }}</label>
                            <p class="mt-1 text-gray-900">
                                {{ $airTransport->updated_at ? $airTransport->updated_at->format('Y-m-d H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
