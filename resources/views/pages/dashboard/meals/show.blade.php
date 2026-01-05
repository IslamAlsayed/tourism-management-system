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

            <!-- Meal Related Components -->
            @if ($meal->model && Str::contains($meal->model_type, 'Accommodation'))
                @include('pages.dashboard.related-components.accommodation', [
                    'record' => $meal->model,
                ])
            @elseif($meal->model && Str::contains($meal->model_type, 'Restaurant'))
                @include('pages.dashboard.related-components.restaurant', [
                    'record' => $meal->model,
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
                                'models' => 'accommodations',
                                'model' => 'accommodation',
                            ])
                            @include('components.elements.create-button', [
                                'models' => 'restaurants',
                                'model' => 'restaurant',
                            ])
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'meals',
                    'id' => $meal->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'meals',
                    'id' => $meal->id,
                ])
                <a href="{{ route('meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
