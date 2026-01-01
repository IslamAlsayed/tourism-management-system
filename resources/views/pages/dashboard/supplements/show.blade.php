@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.supplement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $supplement->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $supplement->price }} {{ $settings->app_default_currency }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('supplements.edit', $supplement->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Supplement Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.supplement')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($supplement->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($supplement->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($supplement->price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($supplement->price, 2) }}
                                    {{ $settings->app_default_currency }}
                                    @if ($supplement->currency)
                                        {{ $supplement->currency->code }}
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($supplement->price_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="kt-badge kt-badge-info">{{ $supplement->price_type }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($supplement->applicable_date)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.applicable_date') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $supplement->applicable_date->format('Y-m-d') }}
                                </p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $supplement->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\supplement',
                                        'field' => 'is_active',
                                        'value' => (bool) $supplement->is_active,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $supplement->id }}-is_mandatory">
                                <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\supplement',
                                        'field' => 'is_mandatory',
                                        'value' => (bool) $supplement->is_mandatory,
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                        </div>
                        @if ($supplement->description)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-2">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $supplement->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($supplement->notes)
                            <div class="col-span-full border-custom rounded-lg p-4">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $supplement->notes !!}
                                </div>
                            </div>
                        @endif
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
                        @if ($supplement->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $supplement->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($supplement->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $supplement->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $supplement->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Accommodations or Restaurants -->
            @if ($supplement->model && Str::contains($supplement->model_type, 'Accommodation'))
                @include('pages.dashboard.related-components.accommodations', [
                    'record' => $supplement->model,
                ])
            @elseif($supplement->model && Str::contains($supplement->model_type, 'Restaurant'))
                @include('pages.dashboard.related-components.restaurants', [
                    'record' => $supplement->model,
                ])
            @elseif($supplement->model && Str::contains($supplement->model_type, 'Transportation'))
                {{-- @include('pages.dashboard.related-components.restaurants', [
                    'record' => $supplement->model,
                ]) --}}
                Transportation details component to be implemented.
            @else
                <!-- No Associated Type Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.no_associated_type')]) }}
                        </h3>

                        <div class="flex items-center gap-4">
                            @include('components.elements.create-button', [
                                'models' => 'accommodations',
                                'model' => 'accommodation',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'restaurants',
                                'model' => 'restaurant',
                            ])
                        </div>
                    </div>
                    <div class="kt-card-body p-4">
                        <p class="text-sm text-secondary-foreground">
                            {{ __('main.no_associated_type_details', ['type' => __('main.season')]) }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'supplements',
                    'id' => $supplement->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'supplements',
                    'id' => $supplement->id,
                ])
                <a href="{{ route('supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
