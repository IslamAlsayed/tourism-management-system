@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tour_guide_type')]))

@section('content')
    <div class="kt-container-fixed">
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
                <a href="{{ route('tour-guides-types.edit', $tourGuideType->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides_types')]) }}
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
                        @if ($tourGuideType->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->type ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->currency->name }}
                                    ({{ $tourGuideType->currency->code }})</p>
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
                        {{-- @if ($tourGuideType->all_states)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.all_states') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @if ($tourGuideType->all_states)
                                        <span class="kt-badge kt-badge-success">{{ __('main.yes') }}</span>
                                    @else
                                        <span class="kt-badge kt-badge-secondary">{{ __('main.no') }}</span>
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($tourGuideType->all_cities)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.all_cities') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @if ($tourGuideType->all_cities)
                                        <span class="kt-badge kt-badge-success">{{ __('main.yes') }}</span>
                                    @else
                                        <span class="kt-badge kt-badge-secondary">{{ __('main.no') }}</span>
                                    @endif
                                </p>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($tourGuideType->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->region->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuideType->country?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuideType->state?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuideType->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuideType->city?->name ?: __('main.na') }}
                                </p>
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
                        @if ($tourGuideType->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuideType->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($tourGuideType->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideType->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuideType->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tour-guides-types',
                    'id' => $tourGuideType->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'tour-guide-type',
                    'modelId' => $tourGuideType->id,
                    'modelType' => '\\App\\Models\\TourGuideType',
                    'table' => 'tourGuideTypes',
                ])
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides_types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
