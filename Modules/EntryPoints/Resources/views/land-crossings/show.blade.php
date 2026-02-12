@extends('layouts.master')

@section('title', __('main.view_type', ['type' => __('main.land-crossing')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $EntryPoint->display_name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.view_type_description', ['type' => __('main.land-crossing')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.entrypoints.land-crossings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.land-crossings')]) }}
                </a>
                <a href="{{ route('dashboard.entrypoints.land-crossings.edit', $EntryPoint->id) }}" class="kt-btn kt-btn-primary md:hidden">
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
                        {{ __('main.type_information', ['type' => __('main.land-crossing')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                        @if ($EntryPoint->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $EntryPoint->name }}</p>
                            </div>
                        @endif
                        @if ($EntryPoint->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $EntryPoint->name_ar }}</p>
                            </div>
                        @endif
                        @if ($EntryPoint->code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.code') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-secondary">
                                        {{ $EntryPoint->code }}
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($EntryPoint->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-primary">{{ $EntryPoint->getTypeLabel() }}</span>
                                </p>
                            </div>
                        @endif
                        @if ($EntryPoint->sort_order)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $EntryPoint->sort_order }}</p>
                            </div>
                        @endif
                        @if ($EntryPoint->operating_days)
                            <div class="col-span-full">
                                <label class="kt-label mb-2">{{ __('main.operating_days') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @foreach ($EntryPoint->operating_days as $day)
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
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_active',
                                    'value' => (bool) $EntryPoint->is_active,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_24_7',
                                    'value' => (bool) $EntryPoint->is_24_7,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_commercial') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_commercial',
                                    'value' => (bool) $EntryPoint->is_commercial,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_passenger') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_passenger',
                                    'value' => (bool) $EntryPoint->is_passenger,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_international') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_international',
                                    'value' => (bool) $EntryPoint->is_international,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_major') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $EntryPoint->id,
                                    'modelType' => '\\App\\Models\\EntryPoint',
                                    'field' => 'is_major',
                                    'value' => (bool) $EntryPoint->is_major,
                                    'table' => 'crossing_ports',
                                ])
                            </div>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $EntryPoint,
                        'column' => 'description',
                        'classes' => 'mb-4',
                    ])
                    @include('components.elements.displayable-rich-text', [
                        'record' => $EntryPoint,
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
                            @if ($EntryPoint->country)
                                <a href="{{ route('dashboard.geography.countries.show', $EntryPoint->country?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $EntryPoint->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($EntryPoint->state)
                                <a href="{{ route('dashboard.geography.states.show', $EntryPoint->state?->id) }}" class="block text-sm text-primary underline">
                                    {{ $EntryPoint->state?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($EntryPoint->city)
                                <a href="{{ route('dashboard.geography.cities.show', $EntryPoint->city?->id) }}" class="block text-sm text-primary underline">
                                    {{ $EntryPoint->city?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">{{ __('main.coordinates') }}</label>
                            <p class="mt-1 text-gray-500">{{ $EntryPoint->coordinates ?? '-' }}</p>
                        </div>
                    </div>
                    @include('components.elements.displayable-rich-text', [
                        'record' => $EntryPoint,
                        'column' => 'address',
                    ])
                </div>
            </div>

            {{-- Visa & Immigration Policies --}}
            @if ($EntryPoint->departure_tax || $EntryPoint->allows_visa_on_arrival)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visa_immigration_policies') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if ($EntryPoint->departure_tax)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.departure_tax') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($EntryPoint->departure_tax, 2) }}
                                        {{ $EntryPoint->departureTaxCurrency?->code }}
                                    </p>
                                </div>
                            @endif
                            <div>
                                <label class="kt-label mb-1">{{ __('main.allows_visa_on_arrival') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $EntryPoint->id,
                                        'modelType' => '\\App\\Models\\EntryPoint',
                                        'field' => 'allows_visa_on_arrival',
                                        'value' => (bool) $EntryPoint->allows_visa_on_arrival,
                                        'table' => 'crossing_ports',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Visa Requirements --}}
            {{-- @if ($EntryPoint->visa_required || $EntryPoint->visa_fee) --}}
            @if ($EntryPoint->visa_fee)
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
                                        'modelId' => $EntryPoint->id,
                                        'modelType' => '\\App\\Models\\EntryPoint',
                                        'field' => 'visa_required',
                                        'value' => (bool) $EntryPoint->visa_required,
                                        'table' => 'crossing_ports',
                                    ])
                                </div>
                            </div> --}}
                            @if ($EntryPoint->visa_fee)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_fee') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($EntryPoint->visa_fee, 2) }}
                                        {{ $EntryPoint->visaFeeCurrency?->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($EntryPoint->visa_duration)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_duration') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $EntryPoint->visa_duration }}
                                        {{ __('main.days') }}</p>
                                </div>
                            @endif
                            @if ($EntryPoint->visa_application_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_application_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $EntryPoint->visa_application_url }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $EntryPoint->visa_application_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($EntryPoint->visa_policy_source)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_policy_source') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $EntryPoint->visa_policy_source }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ __('main.view_source') }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($EntryPoint->visa_last_update)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.visa_last_update') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $EntryPoint->visa_last_update->format('Y-m-d') }}</p>
                                </div>
                            @endif
                        </div>
                        @if ($EntryPoint->visa_conditions)
                            <div class="mt-6">
                                <label class="kt-label mb-1">{{ __('main.visa_conditions') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $EntryPoint->visa_conditions !!}
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
                                {{ $EntryPoint->is_24_7 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $EntryPoint->is_24_7 ? __('main.yes') : __('main.no') }}
                            </span>
                        </div>

                        @if ($EntryPoint->opening_time)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.opening_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $EntryPoint->opening_time }}</p>
                            </div>
                        @endif

                        @if ($EntryPoint->closing_time)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.closing_time') }}</label>
                                <p class="mt-1 text-gray-500">{{ $EntryPoint->closing_time }}</p>
                            </div>
                        @endif

                        @if ($EntryPoint->capacity)
                            <div>
                                <label class="font-medium text-gray-600">{{ __('main.capacity') }}</label>
                                <p class="mt-1 text-gray-500">{{ number_format($EntryPoint->capacity) }}
                                    {{ __('main.passengers_per_hour') }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($EntryPoint->facilities && count($EntryPoint->facilities) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-600">{{ __('main.facilities') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($EntryPoint->facilities as $facility)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $facility)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($EntryPoint->services && count($EntryPoint->services) > 0)
                        <div class="mt-6">
                            <label class="font-medium text-gray-600">{{ __('main.services') }}</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($EntryPoint->services as $service)
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
            @if ($EntryPoint->phone || $EntryPoint->email || $EntryPoint->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($EntryPoint->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $EntryPoint->email }}" class="text-blue-600 hover:underline">
                                            {{ $EntryPoint->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($EntryPoint->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $EntryPoint->phone }}" class="text-blue-600 hover:underline">
                                            {{ $EntryPoint->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($EntryPoint->website)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $EntryPoint->website }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $EntryPoint->website }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $EntryPoint])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'land-crossings',
                    'id' => $EntryPoint->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'land-crossings',
                    'id' => $EntryPoint->id,
                ])
                <a href="{{ route('dashboard.entrypoints.land-crossings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.land-crossings')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
