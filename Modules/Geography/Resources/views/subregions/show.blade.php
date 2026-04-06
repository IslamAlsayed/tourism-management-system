@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.subregion')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $subregion->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.subregions.edit', $subregion->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.geography.subregions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.regions')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($subregion->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $subregion->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($subregion->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $subregion->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $subregion->id,
                                    'modelType' => '\\Modules\\Geography\\Entities\\Subregion',
                                    'field' => 'is_active',
                                    'value' => (bool) $subregion->is_active,
                                    'table' => 'subregions',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        <i class="fa-duotone fa-solid fa-chart-pie text-info me-2"></i>
                        {{ __('main.statistics') }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 20px 80px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.countries')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->countries()->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.states')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->states()->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.cities')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->cities()->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.accommodations')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->accommodations()->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.restaurants')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->restaurants()->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.transportation_companies')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $subregion->transportationCompanies()->count() }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $subregion])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.geography.subregions',
                    'id' => $subregion->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.geography.subregions',
                    'id' => $subregion->id,
                ])
                <a href="{{ route('dashboard.geography.subregions.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.subregions')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
