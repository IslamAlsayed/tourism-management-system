@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.crossing_port')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $crossingPort->display_name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.view_type_description', ['type' => __('main.crossing_port')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('crossings-ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.crossing_ports')]) }}
                </a>
                <a href="{{ route('crossings-ports.edit', $crossingPort->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    {{ __('main.edit') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            {{-- Crossing Port Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.crossing_port')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                        @if ($crossingPort->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $crossingPort->name }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $crossingPort->name_ar }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.code') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-secondary">
                                        {{ $crossingPort->code }}
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($crossingPort->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-primary">{{ $crossingPort->getTypeLabel() }}</span>
                                </p>
                            </div>
                        @endif
                        @if ($crossingPort->sort_order)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $crossingPort->sort_order }}</p>
                            </div>
                        @endif
                        @if ($crossingPort->operating_days)
                            <div class="col-span-full">
                                <label class="kt-label mb-2">{{ __('main.operating_days') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @foreach ($crossingPort->operating_days as $day)
                                        <span class="inline-flex bg-success/10 text-green-600 items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            {{ ucfirst(str_replace('_', ' ', $day)) }}
                                        </span>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-wrap my-8" style="gap: 10px 40px">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_active',
                                    'value' => (bool) $crossingPort->is_active,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_24_7',
                                    'value' => (bool) $crossingPort->is_24_7,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_commercial') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_commercial',
                                    'value' => (bool) $crossingPort->is_commercial,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_passenger') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_passenger',
                                    'value' => (bool) $crossingPort->is_passenger,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_international') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_international',
                                    'value' => (bool) $crossingPort->is_international,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_major') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $crossingPort->id,
                                    'modelType' => '\\App\\Models\\CrossingPort',
                                    'field' => 'is_major',
                                    'value' => (bool) $crossingPort->is_major,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $crossingPort,
                        'column' => 'description',
                        'classes' => 'mb-4',
                    ])
                    @include('components.elements.displayable-rich-text', [
                        'record' => $crossingPort,
                        'column' => 'notes',
                    ])
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.location')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($crossingPort->country)
                                <a href="{{ route('countries.show', $crossingPort->country?->id) }}" class="block text-sm text-primary underline">
                                    {{ $crossingPort->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($crossingPort->state)
                                <a href="{{ route('states.show', $crossingPort->state?->id) }}" class="block text-sm text-primary underline">
                                    {{ $crossingPort->state?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($crossingPort->city)
                                <a href="{{ route('cities.show', $crossingPort->city?->id) }}" class="block text-sm text-primary underline">
                                    {{ $crossingPort->city?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">{{ __('main.coordinates') }}</label>
                            <p class="mt-1 text-gray-500">{{ $crossingPort->coordinates ?? '-' }}</p>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $crossingPort,
                        'column' => 'address',
                    ])
                </div>
            </div>

            {{-- Visa & Immigration Policies --}}
            @if ($crossingPort->departure_tax || $crossingPort->allows_visa_on_arrival)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visa_immigration_policies') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if ($crossingPort->departure_tax)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.departure_tax') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($crossingPort->departure_tax, 2) }}
                                        {{ $crossingPort->departureTaxCurrency?->code }}
                                    </p>
                                </div>
                            @endif
                            <div>
                                <label class="kt-label mb-1">{{ __('main.allows_visa_on_arrival') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $crossingPort->id,
                                        'modelType' => '\\App\\Models\\CrossingPort',
                                        'field' => 'allows_visa_on_arrival',
                                        'value' => (bool) $crossingPort->allows_visa_on_arrival,
                                        'table' => 'crossing_ports',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Visa Requirements --}}
            {{-- @if ($crossingPort->visa_required || $crossingPort->visa_fee) --}}
            @if ($crossingPort->visa_fee)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visa_requirements') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            {{-- <div>
                                <label class="kt-label mb-1">{{ __('main.visa_required') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $crossingPort->id,
                                        'modelType' => '\\App\\Models\\CrossingPort',
                                        'field' => 'visa_required',
                                        'value' => (bool) $crossingPort->visa_required,
                                        'table' => 'crossing_ports',
                                    ])
                                </div>
                            </div> --}}
                            @if ($crossingPort->visa_fee)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_fee') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($crossingPort->visa_fee, 2) }}
                                        {{ $crossingPort->visaFeeCurrency?->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($crossingPort->visa_duration)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_duration') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $crossingPort->visa_duration }}
                                        {{ __('main.days') }}</p>
                                </div>
                            @endif
                            @if ($crossingPort->visa_application_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_application_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $crossingPort->visa_application_url }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $crossingPort->visa_application_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($crossingPort->visa_policy_source)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_policy_source') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $crossingPort->visa_policy_source }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ __('main.view_source') }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($crossingPort->visa_last_update)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_last_update') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $crossingPort->visa_last_update->format('Y-m-d') }}</p>
                                </div>
                            @endif
                        </div>
                        @if ($crossingPort->visa_conditions)
                            <div class="mt-6">
                                <label class="kt-label mb-1">{{ __('main.visa_conditions') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $crossingPort->visa_conditions !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Operating Information --}}
            <div class="kt-card hidden">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="font-medium text-gray-600">{{ __('main.24_hours') }}</label>
                            <span
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $crossingPort->is_24_7 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $crossingPort->is_24_7 ? __('main.yes') : __('main.no') }}
                            </span>
                        </div>

                        @if ($crossingPort->opening_time)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.opening_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->opening_time }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->closing_time)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.closing_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $crossingPort->closing_time }}</p>
                            </div>
                        @endif

                        @if ($crossingPort->capacity)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.capacity') }}</label>
                                <p class="mt-1 text-gray-500">{{ number_format($crossingPort->capacity) }}
                                    {{ __('main.passengers_per_hour') }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($crossingPort->facilities && count($crossingPort->facilities) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-600">{{ __('main.facilities') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($crossingPort->facilities as $facility)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $facility)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($crossingPort->services && count($crossingPort->services) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-600">{{ __('main.services') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($crossingPort->services as $service)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ ucfirst(str_replace('_', ' ', $service)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contact Information --}}
            @if ($crossingPort->phone || $crossingPort->email || $crossingPort->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($crossingPort->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $crossingPort->email }}" class="text-blue-600 hover:underline">
                                            {{ $crossingPort->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($crossingPort->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $crossingPort->phone }}" class="text-blue-600 hover:underline">
                                            {{ $crossingPort->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($crossingPort->website)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $crossingPort->website }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $crossingPort->website }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $crossingPort])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'crossings-ports',
                    'id' => $crossingPort->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'crossings-ports',
                    'id' => $crossingPort->id,
                ])
                <a href="{{ route('crossings-ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.crossings_ports')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
