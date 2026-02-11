@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.visa-requirement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $visaRequirement->nationality?->name }} → {{ $visaRequirement->destinationCountry?->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.visa_type') }}: <span class="font-semibold">{{ __('main.' . $visaRequirement->visa_type) }}</span> •
                    {{ __('main.visa_category') }}: <span class="font-semibold">{{ __('main.' . $visaRequirement->visa_category) }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.traveldocuments.visa-requirements.edit', $visaRequirement->id) }}" class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.traveldocuments.visa-requirements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.visa-requirements')]) }}
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
                        @if ($visaRequirement->nationality)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.nationality') }}</label>
                                <a href="{{ route('dashboard.geography.nationalities.show', $visaRequirement->nationality?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $visaRequirement->nationality?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($visaRequirement->destinationCountry)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.destination_country') }}</label>
                                <a href="{{ route('dashboard.geography.nationalities.show', $visaRequirement->destinationCountry?->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $visaRequirement->destinationCountry?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($visaRequirement->crossingPort)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.crossing_port') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $visaRequirement->crossingPort->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.visa_type') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ __('main.' . $visaRequirement->visa_type) }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.visa_category') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ __('main.' . $visaRequirement->visa_category) }}</p>
                        </div>
                        @if ($visaRequirement->effective_from)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.effective_from') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $visaRequirement->effective_from->format('Y-m-d') }}</p>
                            </div>
                        @endif
                        @if ($visaRequirement->effective_until)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.effective_until') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $visaRequirement->effective_until->format('Y-m-d') }}</p>
                            </div>
                        @endif
                        @if ($visaRequirement->last_verified_at)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.last_verified_at') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $visaRequirement->last_verified_at->format('Y-m-d H:i') }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $visaRequirement->id,
                                    'modelType' => '\\App\\Models\\VisaRequirement',
                                    'field' => 'is_active',
                                    'value' => (bool) $visaRequirement->is_active,
                                    'table' => 'visa_requirements',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_restricted') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $visaRequirement->id,
                                    'modelType' => '\\App\\Models\\VisaRequirement',
                                    'field' => 'is_restricted',
                                    'value' => (bool) $visaRequirement->is_restricted,
                                    'table' => 'visa_requirements',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $visaRequirement,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $visaRequirement,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Visa Details -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.visa_details') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.visa_validity_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->visa_validity_days ?? '-' }}
                                {{ $visaRequirement->visa_validity_days ? __('main.days') : '' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.max_stay_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->max_stay_days ?? '-' }}
                                {{ $visaRequirement->max_stay_days ? __('main.days') : '' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.processing_time_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->processing_time_days ?? '-' }}
                                {{ $visaRequirement->processing_time_days ? __('main.days') : '' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.can_issue_at_port') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $visaRequirement->id,
                                    'modelType' => '\\App\\Models\\VisaRequirement',
                                    'field' => 'can_issue_at_port',
                                    'value' => (bool) $visaRequirement->can_issue_at_port,
                                    'table' => 'visa_requirements',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.pricing_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.visa_fee') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $visaRequirement->visa_fee ? number_format($visaRequirement->visa_fee, 2) : '-' }}
                                @if ($visaRequirement->visaFeeCurrency)
                                    <span class="text-primary font-semibold">{{ $visaRequirement->visaFeeCurrency->code }}</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.departure_tax') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $visaRequirement->departure_tax ? number_format($visaRequirement->departure_tax, 2) : '-' }}
                                @if ($visaRequirement->departureTaxCurrency)
                                    <span class="text-primary font-semibold">{{ $visaRequirement->departureTaxCurrency->code }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Group Requirements -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.group_requirements') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.group_min_size') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->group_min_size ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.group_min_nights') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->group_min_nights ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.group_processing_days') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $visaRequirement->group_processing_days ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- URLs & Resources -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.urls_resources') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($visaRequirement->application_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.application_url') }}:</label>
                                <div>
                                    <a href="{{ $visaRequirement->application_url }}" target="_blank" class="text-primary underline break-all">
                                        {{ $visaRequirement->application_url }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($visaRequirement->official_source_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.official_source_url') }}:</label>
                                <div>
                                    <a href="{{ $visaRequirement->official_source_url }}" target="_blank" class="text-primary underline break-all">
                                        {{ $visaRequirement->official_source_url }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $visaRequirement])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'visa-requirements',
                    'id' => $visaRequirement->id,
                ])
                @include('components.elements.delete-form', [
                    'models' => 'visa-requirements',
                    'id' => $visaRequirement->id,
                ])
                <a href="{{ route('dashboard.traveldocuments.visa-requirements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.visa-requirements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
