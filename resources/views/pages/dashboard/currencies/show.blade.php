@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.currency')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $currency->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $currency->code }} • {{ $currency->symbol }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('currencies.edit', $currency->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.currencies')]) }}
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
                        @if ($currency->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $currency->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($currency->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $currency->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($currency->code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $currency->code ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($currency->symbol)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.symbol') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $currency->symbol }}</p>
                            </div>
                        @endif
                        @if ($currency->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $currency->country->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $currency->id,
                                    'modelType' => '\\App\\Models\\Currency',
                                    'field' => 'is_active',
                                    'value' => (bool) $currency->is_active,
                                    'table' => 'currencies',
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
                            <p class="text-sm text-secondary-foreground">
                                {{ $currency->created_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $currency->updated_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'currencies',
                    'id' => $currency->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'currencies',
                    'id' => $currency->id,
                ])
                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.currencies')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
