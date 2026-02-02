@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.city')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $city->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $city->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('cities.edit', $city->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.cities')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.city')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($city->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $city->name }}</p>
                            </div>
                        @endif
                        @if ($city->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $city->name_ar }}</p>
                            </div>
                        @endif
                        @if ($city->wiki_data_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.wiki_data_id') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $city->wiki_data_id }}</p>
                            </div>
                        @endif
                        @if ($city->population)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.population') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ number_format($city->population) }}</p>
                            </div>
                        @endif
                        @if ($city->timezone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.timezone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">
                                        {{ $city->timezone->name }} ({{ $city->timezone->abbreviation }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $city->id,
                                    'modelType' => '\\App\\Models\\City',
                                    'field' => 'is_active',
                                    'value' => (bool) $city->is_active,
                                    'table' => 'cities',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_independent') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $city->id,
                                    'modelType' => '\\App\\Models\\City',
                                    'field' => 'is_independent',
                                    'value' => (bool) $city->is_independent,
                                    'table' => 'cities',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_developed') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $city->id,
                                    'modelType' => '\\App\\Models\\City',
                                    'field' => 'is_developed',
                                    'value' => (bool) $city->is_developed,
                                    'table' => 'cities',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_landlocked') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $city->id,
                                    'modelType' => '\\App\\Models\\City',
                                    'field' => 'is_landlocked',
                                    'value' => (bool) $city->is_landlocked,
                                    'table' => 'cities',
                                ])
                            </div>
                        </div>

                        @include('components.elements.displayable-rich-text', [
                            'record' => $city,
                            'column' => 'description',
                        ])

                        @include('components.elements.displayable-rich-text', [
                            'record' => $city,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="ki-filled ki-map text-info me-2"></i>
                        {{ __('main.location_information') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 20px 80px;">
                        @if ($city->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <a href="{{ route('regions.show', $city->country?->region?->id) }}" class="block text-sm text-primary underline">
                                    {{ $city->country?->region?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <a href="{{ route('subregions.show', $city->country?->subregion?->id) }}" class="block text-sm text-primary underline">
                                    {{ $city->country?->subregion?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($city->country)
                                <a href="{{ route('countries.show', $city->country?->id) }}" class="block text-sm text-primary underline">
                                    {{ $city->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($city->state)
                                <a href="{{ route('states.show', $city->state?->id) }}" class="block text-sm text-primary underline">
                                    {{ $city->state?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Geographic Information -->
            @if ($city->latitude || $city->longitude || $city->population || $city->area)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-geolocation text-primary me-2"></i>
                            {{ __('main.type_information', ['type' => __('main.geographic')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($city->latitude)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $city->latitude }}</p>
                                </div>
                            @endif
                            @if ($city->longitude)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $city->longitude }}</p>
                                </div>
                            @endif
                            @if ($city->population)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.population') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($city->population) }}
                                    </p>
                                </div>
                            @endif
                            @if ($city->area)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.area') }} (km²)</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($city->area, 2) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $city])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'cities',
                    'id' => $city->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'cities',
                    'id' => $city->id,
                ])
                <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.cities')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
