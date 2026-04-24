@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.travel-pass')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $travelPass->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $travelPass->country?->name }} • {{ $travelPass->price ? number_format($travelPass->price, 2) : '-' }}
                    {{ $travelPass->currency?->code ?? $settings->app_default_currency }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.traveldocuments.travel-passes.edit', $travelPass->id) }}" class="kt-btn kt-btn-primary">
                    <i class="fa-duotone fa-solid fa-pen text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.traveldocuments.travel-passes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.travel-passes')]) }}
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
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->name }}</p>
                        </div>
                        @if ($travelPass->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $travelPass->name_ar }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.pass_type') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->pass_type }}</p>
                        </div>
                        @if ($travelPass->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $travelPass->country->name }}</p>
                            </div>
                        @endif
                        @if ($travelPass->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $travelPass->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $travelPass->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->sort_order }}</p>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'is_active',
                                    'value' => (bool) $travelPass->is_active,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'is_featured',
                                    'value' => (bool) $travelPass->is_featured,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>

                        @include('components.elements.displayable-rich-text', [
                            'record' => $travelPass,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $travelPass,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Pricing and Validity -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_and_validity') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <!-- Price -->
                        <div>
                            <label class="kt-label mb-1">{{ __('main.price') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $travelPass->price ? number_format($travelPass->price, 2) : '-' }}
                                {{ $travelPass->currency?->code ?? $settings->app_default_currency }}
                            </p>
                        </div>

                        <!-- Validity Days -->
                        <div>
                            <label class="kt-label mb-1">{{ __('main.validity_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->validity_days ?? '-' }}</p>
                        </div>

                        <!-- Special Attraction Days -->
                        <div>
                            <label class="kt-label mb-1">{{ __('main.special_attraction_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->special_attraction_days ?? '-' }}</p>
                        </div>

                        <!-- Min Stay Nights -->
                        <div>
                            <label class="kt-label mb-1">{{ __('main.min_stay_nights') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $travelPass->min_stay_nights ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features & Purchase Requirements -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.features') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'is_active',
                                    'value' => (bool) $travelPass->is_active,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'is_featured',
                                    'value' => (bool) $travelPass->is_featured,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.waives_visa_fee') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'waives_visa_fee',
                                    'value' => (bool) $travelPass->waives_visa_fee,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.must_purchase_before_arrival') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $travelPass->id,
                                    'modelType' => '\\Modules\\TravelDocuments\\Entities\\TravelPasse',
                                    'field' => 'must_purchase_before_arrival',
                                    'value' => (bool) $travelPass->must_purchase_before_arrival,
                                    'table' => 'travel_passes',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Official Purchase URL -->
            @if ($travelPass->official_purchase_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.official_purchase_url') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <a href="{{ $travelPass->official_purchase_url }}" target="_blank" class="text-primary hover:underline">
                            {{ $travelPass->official_purchase_url }}
                        </a>
                    </div>
                </div>
            @endif

            <!-- Included Sites -->
            @if ($travelPass->touristSites && count($travelPass->touristSites) > 0)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.included_sites') }}
                            <strong class="text-primary">({{ count($travelPass->touristSites) }})</strong>
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                            @foreach ($travelPass->touristSites as $site)
                                <div class="flex items-start gap-3 p-3 border rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-mono">{{ $site->name }}</h4>
                                        @if ($site->name_ar)
                                            <p class="text-xs text-gray-500 mt-2">{{ $site->name_ar }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related touristSites -->
            @if ($travelPass->touristSites && $travelPass->touristSites->count() > 0)
                @include('components.state-search', [
                    'models' => 'tourist-sites',
                    'records' => $travelPass->touristSites,
                ])
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $travelPass])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'travel-passes',
                    'id' => $travelPass->id,
                ])
                @include('components.elements.delete-form', [
                    'models' => 'travel-passes',
                    'id' => $travelPass->id,
                ])
                <a href="{{ route('dashboard.traveldocuments.travel-passes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.travel-passes')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
