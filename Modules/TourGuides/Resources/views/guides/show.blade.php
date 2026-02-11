@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tours.guide')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $tourGuide->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $tourGuide->guide_type?->type }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.guides.edit', $tourGuide->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.tourguides.guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tour Guide Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tours.guide')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($tourGuide->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->home_city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.home_city') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->home_city ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->birth_year)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.birth_year') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->birth_year ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->gender)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.gender') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-info">{{ $tourGuide->gender ?: __('main.na') }}</span>
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->national_guide_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.national_guide_id') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->national_guide_id ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->tourism_ministry_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.tourism_ministry_code') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->tourism_ministry_code ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->fd_day_fees)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fd_day_fees') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->fd_day_fees ?? 0 . ' ' . $tourGuide->currency->code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->hd_day_fees)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.hd_day_fees') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->hd_day_fe ?? 0 . ' ' . $tourGuide->currency->code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->extra_fees_1)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.extra_fees_1') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->extra_fees_1 ?? 0 . ' ' . $tourGuide->currency->code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->extra_fees_2)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.extra_fees_2') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->extra_fees_2 ?? 0 . ' ' . $tourGuide->currency->code ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->guideType)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.guide_type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->guideType->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $tourGuide->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $tourGuide->id,
                                    'modelType' => '\\Modules\\TourGuides\\Entities\\TourGuide',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuide->is_active,
                                    'table' => 'tour-guides',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuide,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuide,
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
                        @if ($tourGuide->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <a href="{{ route('dashboard.geography.regions.show', $tourGuide->country?->region?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuide->country?->region?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <a href="{{ route('dashboard.geography.subregions.show', $tourGuide->country?->subregion?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $tourGuide->country?->subregion?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($tourGuide->country)
                                <a href="{{ route('dashboard.geography.countries.show', $tourGuide->country?->id) }}" class="block text-sm text-primary underline">
                                    {{ $tourGuide->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $tourGuide->street ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.box') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $tourGuide->box ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $tourGuide->postal_code ?? __('main.na') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.contact')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($tourGuide->email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $tourGuide->email }}" class="text-primary hover:underline">
                                        {{ $tourGuide->email }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->mobile_01)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile_01') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $tourGuide->mobile_01 }}" class="text-primary hover:underline">
                                        {{ $tourGuide->mobile_01 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->mobile_02)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile_02') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $tourGuide->mobile_02 }}" class="text-primary hover:underline">
                                        {{ $tourGuide->mobile_02 }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $tourGuide])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.tourguides.guides',
                    'id' => $tourGuide->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'tours.guides',
                    'id' => $tourGuide->id,
                ])
                <a href="{{ route('dashboard.tourguides.guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
