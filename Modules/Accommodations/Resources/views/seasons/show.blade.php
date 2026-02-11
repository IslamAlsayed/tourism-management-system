@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.season')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $season->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.accommodations.seasons.edit', $season->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.accommodations.seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($season->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($season->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $season->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($season->season_from)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_from->format('Y-m-d') ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($season->season_to)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $season->season_to->format('Y-m-d') ?: __('main.na') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $season->id,
                                    'modelType' => '\\Modules\\Accommodations\\Entities\\Season',
                                    'field' => 'is_active',
                                    'value' => (bool) $season->is_active,
                                    'table' => 'seasons',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $season,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $season,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $season])

            <!-- Season Related Components -->
            @if ($season->model && Str::contains($season->model_type, 'Accommodation'))
                @include('pages.dashboard.related-components.accommodation', [
                    'record' => $season->model,
                ])
            @elseif($season->model && Str::contains($season->model_type, 'Restaurant'))
                @include('pages.dashboard.related-components.restaurant', [
                    'record' => $season->model,
                ])
            @elseif($season->model && Str::contains($season->model_type, 'Transportation'))
                @include('pages.dashboard.related-components.transportations-company', [
                    'record' => $season->model,
                ])
            @else
                <!-- No Associated Type Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.no_associated_type')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.no_associated_type_details', ['type' => __('main.season')]) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-4">
                            @include('components.elements.create-button', [
                                'models' => 'dashboard.accommodations',
                                'model' => 'accommodation',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'restaurants',
                                'model' => 'restaurant',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'transportation.companies',
                                'model' => 'transportation-company',
                            ])
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.accommodations.seasons',
                    'id' => $season->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.accommodations.seasons',
                    'id' => $season->id,
                ])
                <a href="{{ route('dashboard.accommodations.seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
