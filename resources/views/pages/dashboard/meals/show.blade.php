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


            <!-- Accommodations -->
            <div class="kt-card record-accommodations-{{ $meal->accommodation->id }}">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.accommodation')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div wire:key="accommodation-{{ $meal->accommodation->id }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $meal->accommodation->name ?: __('main.na') }}</p>
                            </div>
                            @if ($meal->accommodation->name_ar)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $meal->accommodation->name_ar }}
                                    </p>
                                </div>
                            @endif
                            @if ($meal->accommodation->type)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                    <div>
                                        <a href="{{ route('types.show', $meal->accommodation->type->id) }}"
                                            class="kt-badge kt-badge-primary">
                                            {{ $meal->accommodation->type->name ?: __('main.na') }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if ($meal->accommodation->classification)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                    <div>
                                        <span class="kt-badge kt-badge-primary">
                                            {{ $meal->accommodation->classification ?: __('main.na') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @if ($meal->accommodation->stars)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $meal->accommodation->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                            @if ($meal->accommodation->currency)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $meal->accommodation->currency->code }} -
                                        {{ $meal->accommodation->currency->name }}</p>
                                </div>
                            @endif
                            @if ($meal->accommodation->city || $meal->accommodation->country)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $meal->accommodation->city?->name ?? '' }}
                                        {{ $meal->accommodation->city && $meal->accommodation->country ? ', ' : '' }}
                                        {{ $meal->accommodation->country?->name ?? '' }}
                                    </p>
                                </div>
                            @endif
                            @if ($meal->accommodation->general_mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $meal->accommodation->general_mobile }}</p>
                                </div>
                            @endif
                            @if ($meal->accommodation->general_email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $meal->accommodation->general_email }}</p>
                                </div>
                            @endif
                            @if ($meal->accommodation->contact_person)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $meal->accommodation->contact_person }}</p>
                                </div>
                            @endif
                            @if ($meal->accommodation->street)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $meal->accommodation->street }}
                                    </p>
                                </div>
                            @endif
                            <div class="col-span-2 flex items-center gap-10 mb-2">
                                <div wire:key="toggle-{{ $meal->accommodation->id }}-is_active">
                                    <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $meal->accommodation->id,
                                            'modelType' => '\\App\\Models\\Accommodation',
                                            'field' => 'is_active',
                                            'value' => (bool) $meal->accommodation->is_active,
                                            'table' => 'accommodations',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($meal->accommodation->notes)
                            <div class="lg:col-span-2 mt-2">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground">{!! $meal->accommodation->notes !!}</div>
                            </div>
                        @endif
                        <div class="lg:col-span-2 flex gap-2 mt-4">
                            @include('components.elements.show-button', [
                                'models' => 'accommodations',
                                'id' => $meal->accommodation->id,
                            ])
                            @include('components.elements.edit-button', [
                                'models' => 'accommodations',
                                'id' => $meal->accommodation->id,
                            ])
                            @livewire('delete-bottom', [
                                'type' => 'accommodations',
                                'modelId' => $meal->accommodation->id,
                                'modelType' => '\\App\\Models\\Accommodation',
                                'table' => 'accommodations',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seasons for this accommodation -->
            <div class="kt-card bg-blue-100 record-meals-seasons-{{ $meal->season->id }}">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.seasons') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div wire:key="season-{{ $meal->season->id }}" class="kt-card bg-white rounded-lg p-4 pt-2">
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $meal->season->name ?: __('main.na') }}
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $meal->season->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $meal->season->season_from->format('Y-m-d') ?: __('main.na') }}
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $meal->season->season_to->format('Y-m-d') ?: __('main.na') }}
                                </p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $meal->season->id,
                                        'modelType' => '\\App\\Models\\Season',
                                        'field' => 'is_active',
                                        'value' => (bool) $meal->season->is_active,
                                        'table' => 'seasons',
                                    ])
                                </div>
                            </div>
                        </div>
                        @if ($meal->season->description)
                            <div class="lg:col-span-2 mt-2 border-custom-t pt-2">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $meal->season->description !!}</div>
                            </div>
                        @endif
                        <div class="lg:col-span-2 flex gap-2 mt-4">
                            @include('components.elements.show-button', [
                                'models' => 'meals',
                                'id' => $meal->season->id,
                            ])
                            @include('components.elements.edit-button', [
                                'models' => 'meals',
                                'id' => $meal->season->id,
                            ])
                            @livewire('delete-bottom', [
                                'type' => 'meals-seasons',
                                'modelId' => $meal->season->id,
                                'modelType' => '\\App\\Models\\Season',
                                'table' => 'seasons',
                            ])
                        </div>
                    </div>
                </div>
            </div>

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
