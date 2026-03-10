@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.restaurant_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">{{ $type->name }}</h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.restaurants.types.edit', $type->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>{{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.restaurants.types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurant_types')]) }}
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
                            <p class="text-sm text-secondary-foreground">{{ $type->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $type->name_ar ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $type->id,
                                    'modelType' => '\\Modules\\Restaurants\\Entities\\RestaurantType',
                                    'field' => 'is_active',
                                    'value' => (bool) $type->is_active,
                                    'table' => 'restaurant_types',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.restaurants.types',
                    'id' => $type->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.restaurants.types',
                    'id' => $type->id,
                ])
                <a href="{{ route('dashboard.restaurants.types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurant_types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
