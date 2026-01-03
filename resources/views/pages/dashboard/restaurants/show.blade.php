@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.restaurant')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $restaurant->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $restaurant->type?->name }} • {{ $restaurant->city?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('restaurants.edit', $restaurant->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-4">
                        @if ($restaurant->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->name_ar }}</p>
                            </div>
                        @endif
                        @if ($restaurant->company_name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.company_name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->company_name_ar }}</p>
                            </div>
                        @endif
                        @if ($restaurant->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->type->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->rating)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.rating') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($restaurant->rating, 0) }}/5
                                    <i class="fas fa-star" style="color: #ffdd00"></i>
                                </p>
                            </div>
                        @endif
                        @if ($restaurant->specialty)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.specialty') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->specialty }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-wrap mb-4" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'is_active',
                                    'value' => (bool) $restaurant->is_active,
                                    'table' => 'restaurants',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.wheelchair_accessible') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'wheelchair_accessible',
                                    'value' => (bool) $restaurant->wheelchair_accessible,
                                    'table' => 'wheelchair_accessible',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.free_wifi') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'free_wifi',
                                    'value' => (bool) $restaurant->free_wifi,
                                    'table' => 'free_wifi',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.parking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'parking',
                                    'value' => (bool) $restaurant->parking,
                                    'table' => 'parking',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.swimming_pool') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'swimming_pool',
                                    'value' => (bool) $restaurant->swimming_pool,
                                    'table' => 'swimming_pool',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.gym') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'gym',
                                    'value' => (bool) $restaurant->gym,
                                    'table' => 'gym',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.indoor') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'indoor',
                                    'value' => (bool) $restaurant->indoor,
                                    'table' => 'indoor',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.outdoor') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'outdoor',
                                    'value' => (bool) $restaurant->outdoor,
                                    'table' => 'outdoor',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.spa') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'spa',
                                    'value' => (bool) $restaurant->spa,
                                    'table' => 'spa',
                                ])
                            </div>
                        </div>
                    </div>
                    @if ($restaurant->description)
                        <div class="col-span-full border-custom rounded-lg mb-4 p-4">
                            <label class="kt-label mb-2">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $restaurant->description !!}
                            </div>
                        </div>
                    @endif
                    @if ($restaurant->notes)
                        <div class="col-span-full border-custom rounded-lg p-4">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $restaurant->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.location')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        @if ($restaurant->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->region->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->country->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->state->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->city->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->street)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->street }}</p>
                            </div>
                        @endif
                        @if ($restaurant->postal_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->postal_code }}</p>
                            </div>
                        @endif
                        @if ($restaurant->box)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.box') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->box }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if (
                $restaurant->phone_01 ||
                    $restaurant->phone_02 ||
                    $restaurant->email_01 ||
                    $restaurant->email_02 ||
                    $restaurant->mobile ||
                    $restaurant->fax ||
                    $restaurant->contact_person ||
                    $restaurant->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.contact')]) }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($restaurant->phone_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone_01') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->phone_01 }}</p>
                                </div>
                            @endif
                            @if ($restaurant->phone_02)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone_02') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->phone_02 }}</p>
                                </div>
                            @endif
                            @if ($restaurant->mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->mobile }}</p>
                                </div>
                            @endif
                            @if ($restaurant->fax)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->fax }}</p>
                                </div>
                            @endif
                            @if ($restaurant->email_01)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email_01') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->email_01 }}</p>
                                </div>
                            @endif
                            @if ($restaurant->email_02)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email_02') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->email_02 }}</p>
                                </div>
                            @endif
                            @if ($restaurant->contact_person)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->contact_person }}</p>
                                </div>
                            @endif
                            @if ($restaurant->website)
                                <div class="lg:col-span-2">
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $restaurant->website }}" target="_blank"
                                            class="text-primary hover:underline">
                                            {{ $restaurant->website }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- @if ($restaurant->photo)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.photo') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <img src="{{ asset('storage/' . $restaurant->photo) }}" alt="{{ $restaurant->name }}"
                            class="max-w-md rounded-lg">
                    </div>
                </div>
            @endif --}}

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($restaurant->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $restaurant->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($restaurant->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $restaurant->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seasons for this restaurant -->
            <div class="kt-card bg-blue-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.seasons') }}
                        (<span class="font-semibold text-primary">{{ $restaurant->seasons->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('seasons.create', [Str::random(120), 'type' => 'restaurant']) }}"
                            class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.season')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($restaurant->seasons as $season)
                            <div wire:key="season-{{ $season->id }}"
                                class="kt-card bg-white rounded-lg p-4 pt-2 record-seasons-{{ $season->id }}">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $season->name ?: __('main.na') }}</p>
                                    </div>
                                    @if ($season->name_ar)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $season->name_ar }}</p>
                                        </div>
                                    @endif
                                    @if ($season->season_from)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.season_from') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                {{ $season->season_from->format('Y-m-d') }}</p>
                                        </div>
                                    @endif
                                    @if ($season->season_to)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.season_to') }}</label>
                                            <p class="text-sm text-secondary-foreground">
                                                {{ $season->season_to->format('Y-m-d') }}</p>
                                        </div>
                                    @endif
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $season->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $season->id,
                                                    'modelType' => '\\App\\Models\\Season',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $season->is_active,
                                                    'table' => 'seasons',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($season->description)
                                    <div class="lg:col-span-2 mt-2 border-custom-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $season->description !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-4">
                                    @include('components.elements.show-button', [
                                        'models' => 'seasons',
                                        'id' => $season->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'seasons',
                                        'id' => $season->id,
                                    ])
                                    @livewire('delete-bottom', [
                                        'type' => 'seasons',
                                        'modelId' => $season->id,
                                        'modelType' => '\\App\\Models\\Season',
                                        'table' => 'seasons',
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Meals for this restaurant -->
            <div class="kt-card bg-orange-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.meals') }}
                        (<span class="font-semibold text-primary">{{ $restaurant->meals->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('meals.create') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.meal')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($restaurant->meals as $meal)
                            <div wire:key="meal-{{ $meal->id }}"
                                class="kt-card bg-white rounded-lg p-4 pt-2 record-meals-{{ $meal->id }}">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $meal->name ?: __('main.na') }}</p>
                                    </div>
                                    @if ($meal->name_ar)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $meal->name_ar }}</p>
                                        </div>
                                    @endif
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $meal->id }}-is_included">
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
                                        <div wire:key="toggle-{{ $meal->id }}-is_active">
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

                                {{-- Meal Pricing Information --}}
                                @if ($meal->season || $meal->price)
                                    <div class="lg:col-span-2 mt-3 border-custom-t pt-3">
                                        <label
                                            class="kt-label mb-2">{{ __('main.type_information', ['type' => __('main.pricing')]) }}</label>
                                        <div class="bg-blue-50 p-3 rounded-lg">
                                            @if ($meal->season)
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="font-medium text-sm">{{ $meal->season->name }}</span>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $meal->season->season_from->format('Y-m-d') }}
                                                        → {{ $meal->season->season_to->format('Y-m-d') }}</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center gap-4 text-sm">
                                                @if ($meal->price)
                                                    <div>
                                                        <span class="text-gray-600">{{ __('main.price') }}:</span>
                                                        <span
                                                            class="font-semibold text-lg">{{ number_format($meal->price, 2) }}
                                                            {{ $meal->currency?->code }}</span>
                                                    </div>
                                                @endif
                                                @if ($meal->is_included)
                                                    <span
                                                        class="kt-badge kt-badge-success">{{ __('main.included') }}</span>
                                                @endif
                                                @if ($meal->is_supplement)
                                                    <span
                                                        class="kt-badge kt-badge-info">{{ __('main.supplement') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($meal->description)
                                    <div class="lg:col-span-2 mt-2 border-custom-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $meal->description !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-4">
                                    @include('components.elements.show-button', [
                                        'models' => 'meals',
                                        'id' => $meal->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'meals',
                                        'id' => $meal->id,
                                    ])
                                    @livewire('delete-bottom', [
                                        'type' => 'meals',
                                        'modelId' => $meal->id,
                                        'modelType' => '\\App\\Models\\Meal',
                                        'table' => 'meals',
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Supplements -->
            <div class="kt-card bg-pink-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.supplements') }}
                        (<span class="font-semibold text-primary">{{ $restaurant->supplements->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('supplements.create', ['accommodation_id' => $restaurant->id]) }}"
                            class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.supplement')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($restaurant->supplements as $supplement)
                            <div wire:key="supplement-{{ $supplement->id }}"
                                class="kt-card bg-white rounded-lg p-4 pt-2 record-supplements-{{ $supplement->id }}">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->name ?: __('main.na') }}</p>
                                    </div>
                                    @if ($supplement->name_ar)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $supplement->name_ar }}</p>
                                        </div>
                                    @endif
                                    @if ($supplement->description)
                                        <div class="col-span-2">
                                            <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $supplement->description }}
                                            </p>
                                        </div>
                                    @endif
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($supplement->price, 2) . ' ' . $settings->app_default_currency }}
                                            {{ $supplement->currency?->code }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                class="kt-badge kt-badge-info">{{ __('main.' . $supplement->price_type) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $supplement->id }}-is_mandatory">
                                            <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $supplement->id,
                                                    'modelType' => '\\App\\Models\\Supplement',
                                                    'field' => 'is_mandatory',
                                                    'value' => (bool) $supplement->is_mandatory,
                                                    'table' => 'supplements',
                                                ])
                                            </div>
                                        </div>
                                        <div wire:key="toggle-{{ $supplement->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $supplement->id,
                                                    'modelType' => '\\App\\Models\\Supplement',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $supplement->is_active,
                                                    'table' => 'supplements',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($supplement->description)
                                    <div class="lg:col-span-2 mt-2 border-custom-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $supplement->description !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-4">
                                    @include('components.elements.show-button', [
                                        'models' => 'supplements',
                                        'id' => $supplement->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'supplements',
                                        'id' => $supplement->id,
                                    ])
                                    @livewire('delete-bottom', [
                                        'type' => 'supplements',
                                        'modelId' => $supplement->id,
                                        'modelType' => '\\App\\Models\\Supplement',
                                        'table' => 'supplements',
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_supplements_available') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'restaurants',
                    'id' => $restaurant->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'restaurants',
                    'id' => $restaurant->id,
                ])
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
