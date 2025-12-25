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
                                    'modelType' => '\\App\\Models\\TourGuideType',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuideType->is_active,
                                    'table' => 'tour-guides-types',
                                ])
                            </div>
                        </div>
                        @if ($tourGuideType->description)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $tourGuideType->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($tourGuideType->notes)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $tourGuideType->notes !!}
                                </div>
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
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.location')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        @if ($tourGuideType->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <a href="{{ route('regions.show', $tourGuideType->region->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->region->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($tourGuideType->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <a href="{{ route('subregions.show', $tourGuideType->subregion->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->subregion->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($tourGuideType->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <a href="{{ route('countries.show', $tourGuideType->country->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->country->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($tourGuideType->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <a href="{{ route('states.show', $tourGuideType->state->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->state->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($tourGuideType->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <a href="{{ route('cities.show', $tourGuideType->city->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuideType->city->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
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
                @include('components.elements.delete-form', [
                    'model' => 'tour-guides-types',
                    'id' => $tourGuideType->id,
                ])
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides_types')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
