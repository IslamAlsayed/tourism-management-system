@extends('layouts.master')

@section('title', __('main.supplement_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $accommodationSupplement->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $accommodationSupplement->accommodation?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations-supplements.edit', $accommodationSupplement->id) }}"
                    class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
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
                        @if ($accommodationSupplement->accommodation)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.accommodation') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->accommodation?->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($accommodationSupplement->price, 2) }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->applicable_date)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.applicable_date') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->applicable_date->format('Y-m-d') }}
                                </p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $accommodationSupplement->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $accommodationSupplement->id,
                                        'modelType' => '\\App\\Models\\AccommodationSupplement',
                                        'field' => 'is_active',
                                        'value' => (bool) $accommodationSupplement->is_active,
                                        'table' => 'accommodations-supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $accommodationSupplement->id }}-is_per_person">
                                <label class="kt-label mb-1">{{ __('main.is_per_person') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $accommodationSupplement->id,
                                        'modelType' => '\\App\\Models\\AccommodationSupplement',
                                        'field' => 'is_per_person',
                                        'value' => (bool) $accommodationSupplement->is_per_person,
                                        'table' => 'accommodations-supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $accommodationSupplement->id }}-is_mandatory">
                                <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $accommodationSupplement->id,
                                        'modelType' => '\\App\\Models\\AccommodationSupplement',
                                        'field' => 'is_mandatory',
                                        'value' => (bool) $accommodationSupplement->is_mandatory,
                                        'table' => 'accommodations-supplements',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($accommodationSupplement->notes)
                        <div class="mt-3">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground">
                                {!! $accommodationSupplement->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodationSupplement->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodationSupplement->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'accommodations-supplements',
                    'id' => $accommodationSupplement->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'accommodations-supplement',
                    'modelId' => $accommodationSupplement->id,
                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                    'table' => 'accommodations_supplements',
                ])
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations-supplements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
