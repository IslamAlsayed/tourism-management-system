@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.nationality')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $nationality->name }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('nationalities.edit', $nationality->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('nationalities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.nationalities')]) }}
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
                        @if ($nationality->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $nationality->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($nationality->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $nationality->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($nationality->country->iso3)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.iso3') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $nationality->country->iso3 }}</p>
                            </div>
                        @endif
                        @if ($nationality->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $nationality->country->name }}</p>
                            </div>
                        @endif
                        @if ($nationality->country->capital)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.capital') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $nationality->country->capital }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $nationality->id,
                                    'modelType' => '\\App\\Models\\Nationality',
                                    'field' => 'is_active',
                                    'value' => (bool) $nationality->is_active,
                                    'table' => 'nationalities',
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
                                {{ $nationality->created_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $nationality->updated_at?->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'nationalities',
                    'id' => $nationality->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'nationality',
                    'modelId' => $nationality->id,
                    'modelType' => '\\App\\Models\\Nationality',
                    'table' => 'nationalities',
                ])
                <a href="{{ route('nationalities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.nationalities')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
