@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tours.guides-type')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $tourGuideType->type }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $tourGuideType->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.guides-types.edit', $tourGuideType->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.tourguides.guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($tourGuideType->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->type ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($tourGuideType->price, 2) }} {{ $tourGuideType->currency?->code }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuideType->currency_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuideType->currency->name . ' - ' . $tourGuideType->currency->code }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $tourGuideType->id,
                                    'modelType' => '\\Modules\\TourGuides\\Entities\\TourGuideType',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuideType->is_active,
                                    'table' => 'tour-guides-types',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuideType,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuideType,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.location')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 20px 80px;">
                        @if ($tourGuideType->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <a href="{{ route('dashboard.geography.regions.show', $tourGuideType->country?->region?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->country?->region?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <a href="{{ route('dashboard.geography.subregions.show', $tourGuideType->country?->subregion?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->country?->subregion?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($tourGuideType->country)
                                <a href="{{ route('dashboard.geography.countries.show', $tourGuideType->country?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.states')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $tourGuideType->states->count() }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.total_types', ['types' => __('main.cities')]) }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <span class="kt-badge kt-badge-info">
                                    {{ $tourGuideType->cities->count() }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related States -->
            @if ($tourGuideType->states && $tourGuideType->states->count() > 0)
                @include('components.state-search', [
                    'models' => 'states',
                    'records' => $tourGuideType->states,
                ])
            @endif

            <!-- Related Cities -->
            @if ($tourGuideType->cities && $tourGuideType->cities->count() > 0)
                @include('components.state-search', [
                    'models' => 'cities',
                    'records' => $tourGuideType->cities,
                ])
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $tourGuideType])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.tourguides.guides-types',
                    'id' => $tourGuideType->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.tourguides.guides-types',
                    'id' => $tourGuideType->id,
                ])
                <a href="{{ route('dashboard.tourguides.guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides-types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
