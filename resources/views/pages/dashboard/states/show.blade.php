@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.state')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $state->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $state->country?->numeric_code }} • {{ $state->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('states.edit', $state->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('states.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.states')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.state')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($state->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->name }}</p>
                            </div>
                        @endif
                        @if ($state->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($state->iso2)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.iso2') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->iso2 }}</p>
                            </div>
                        @endif
                        @if ($state->iso3)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.iso3') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->iso3 }}</p>
                            </div>
                        @endif
                        @if ($state->fips_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fips_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->fips_code }}</p>
                            </div>
                        @endif
                        @if ($state->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->type }}</p>
                            </div>
                        @endif
                        @if ($state->level)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.level') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->level }}</p>
                            </div>
                        @endif
                        @if ($state->timezone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.timezone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">
                                        {{ $state->timezone->name }} ({{ $state->timezone->abbreviation }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $state->id,
                                    'modelType' => '\\App\\Models\\State',
                                    'field' => 'is_active',
                                    'value' => (bool) $state->is_active,
                                    'table' => 'states',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_independent') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $state->id,
                                    'modelType' => '\\App\\Models\\State',
                                    'field' => 'is_independent',
                                    'value' => (bool) $state->is_independent,
                                    'table' => 'states',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_developed') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $state->id,
                                    'modelType' => '\\App\\Models\\State',
                                    'field' => 'is_developed',
                                    'value' => (bool) $state->is_developed,
                                    'table' => 'states',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_landlocked') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $state->id,
                                    'modelType' => '\\App\\Models\\State',
                                    'field' => 'is_landlocked',
                                    'value' => (bool) $state->is_landlocked,
                                    'table' => 'states',
                                ])
                            </div>
                        </div>
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $state,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $state,
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
                    <div class="flex flex-wrap justify-between gap-10">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.region') }}</label>
                            <a href="{{ route('regions.show', $state->region?->id) }}"
                                class="block text-sm text-primary underline">
                                {{ $state->region?->name ?? __('main.na') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            <a href="{{ route('subregions.show', $state->subregion->id) }}"
                                class="block text-sm text-primary underline">
                                {{ $state->subregion->name ?? __('main.na') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            <a href="{{ route('countries.show', $state->country?->id) }}"
                                class="block text-sm text-primary underline">
                                {{ $state->country?->name ?? __('main.na') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                        @if ($state->cities && $state->cities->count() > 0)
                            <div>
                                <label
                                    class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.cities')]) }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">
                                        {{ $state->cities->count() }}
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Geographic Information -->
            @if ($state->latitude || $state->longitude || $state->population || $state->area)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            <i class="ki-filled ki-geolocation text-primary me-2"></i>
                            {{ __('main.type_information', ['type' => __('main.geographic')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($state->latitude)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $state->latitude }}</p>
                                </div>
                            @endif
                            @if ($state->longitude)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $state->longitude }}</p>
                                </div>
                            @endif
                            @if ($state->population)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.population') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($state->population) }}
                                    </p>
                                </div>
                            @endif
                            @if ($state->area)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.area') }} (km²)</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($state->area, 2) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Cities -->
            @if ($state->cities && $state->cities->count() > 0)
                @include('components.state-search', [
                    'models' => 'cities',
                    'records' => $state->cities,
                ])
            @endif

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($state->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $state->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($state->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $state->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $state->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'states',
                    'id' => $state->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'states',
                    'id' => $state->id,
                ])
                <a href="{{ route('states.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.states')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
