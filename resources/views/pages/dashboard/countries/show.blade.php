@extends('layouts.master')

@section('title', __('main.country_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $country->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $country->numeric_code }} • {{ $country->currency?->code }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.edit', $country->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($country->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($country->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($country->numeric_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.numeric_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->numeric_code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($country->iso2)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.iso2') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->iso2 }}</p>
                            </div>
                        @endif
                        @if ($country->iso3)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.iso3') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->iso3 }}</p>
                            </div>
                        @endif
                        @if ($country->phone_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone_code') }}</label>
                                <p class="text-sm text-secondary-foreground">+{{ $country->phone_code }}</p>
                            </div>
                        @endif
                        @if ($country->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->currency->name }}
                                    ({{ $country->currency->code }})</p>
                            </div>
                        @endif
                        @if ($country->language)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.language') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->language->name }}</p>
                            </div>
                        @endif
                        @if ($country->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->region->name }}</p>
                            </div>
                        @endif
                        @if ($country->timezone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.timezone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->timezone->name }}
                                    ({{ $country->timezone->abbreviation }})</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $country->id,
                                    'modelType' => '\\App\\Models\\Country',
                                    'field' => 'is_active',
                                    'value' => (bool) $country->is_active,
                                    'table' => 'countries',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_independent') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $country->id,
                                    'modelType' => '\\App\\Models\\Country',
                                    'field' => 'is_independent',
                                    'value' => (bool) $country->is_independent,
                                    'table' => 'countries',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_developed') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $country->id,
                                    'modelType' => '\\App\\Models\\Country',
                                    'field' => 'is_developed',
                                    'value' => (bool) $country->is_developed,
                                    'table' => 'countries',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_landlocked') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $country->id,
                                    'modelType' => '\\App\\Models\\Country',
                                    'field' => 'is_landlocked',
                                    'value' => (bool) $country->is_landlocked,
                                    'table' => 'countries',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($country->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $country->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($country->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $country->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $country->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'countries',
                    'id' => $country->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'country',
                    'modelId' => $country->id,
                    'modelType' => '\\App\\Models\\Country',
                    'table' => 'countries',
                ])
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
