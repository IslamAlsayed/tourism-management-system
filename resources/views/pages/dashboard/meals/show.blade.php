@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.meal')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $meal->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('meals.edit', $meal->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
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
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $meal->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $meal->name_ar ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_included') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $meal->id,
                                    'modelType' => '\\App\\Models\\Meal',
                                    'field' => 'is_included',
                                    'value' => (bool) $meal->is_included,
                                    'table' => 'meals',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $meal->id,
                                    'modelType' => '\\App\\Models\\Meal',
                                    'field' => 'is_active',
                                    'value' => (bool) $meal->is_active,
                                    'table' => 'meals',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $meal->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $meal->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meal rates -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.meal_rates') }}</h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('accommodations-rates.create-meal') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.meal_rates')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4" wire:ignore>
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($meal->mealRates as $mealRate)
                            <div wire:key="mealRate-{{ $mealRate->id }}" class="kt-card bg-gray-50 rounded-lg p-4 pt-2">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.accommodation') }} -
                                            {{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $mealRate->accommodation->name ?: __('main.na') }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $mealRate->accommodation->name_ar ?: __('main.na') }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.season') }} -
                                            {{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $mealRate->season->name ?: __('main.na') }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $mealRate->season->name_ar ?: __('main.na') }}</p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($mealRate->price, 2) }}</p>
                                    </div>
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $mealRate->id }}-is_supplement">
                                            <label class="kt-label mb-1">{{ __('main.is_supplement') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $mealRate->id,
                                                    'modelType' => '\\App\\Models\\AccommodationMealRate',
                                                    'field' => 'is_supplement',
                                                    'value' => (bool) $mealRate->is_supplement,
                                                    'table' => 'accommodation_meal_rates',
                                                ])
                                            </div>
                                        </div>
                                        <div wire:key="toggle-{{ $mealRate->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $mealRate->id,
                                                    'modelType' => '\\App\\Models\\AccommodationMealRate',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $mealRate->is_active,
                                                    'table' => 'accommodation_meal_rates',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($mealRate->notes)
                                    <div class="lg:col-span-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <p class="text-sm text-secondary-foreground">{!! $mealRate->notes !!}</p>
                                    </div>
                                @endif
                                @livewire('delete-bottom', [
                                    'type' => 'mealRate',
                                    'modelId' => $mealRate->id,
                                    'modelType' => '\\App\\Models\\AccommodationMealRate',
                                    'table' => 'accommodation_meal_rates',
                                ])
                            </div>
                        @empty
                            <div class="text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('accommodations-rates.create-meal') }}"
                                    class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.create_type', ['type' => __('main.meal_rate')]) }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'meals',
                    'id' => $meal->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'meal',
                    'modelId' => $meal->id,
                    'modelType' => '\\App\\Models\\Meal',
                    'table' => 'meals',
                ])
                <a href="{{ route('meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
