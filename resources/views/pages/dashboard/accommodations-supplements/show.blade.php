@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.supplement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $accommodationSupplement->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $accommodationSupplement->accommodation?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations-supplements.edit', $accommodationSupplement->id) }}"
                    class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Supplement Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.supplement')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($accommodationSupplement->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($accommodationSupplement->price, 2) }}
                                    {{ $settings->app_default_currency }}
                                    @if ($accommodationSupplement->currency)
                                        {{ $accommodationSupplement->currency->code }}
                                    @endif
                                </p>
                            </div>
                        @endif
                        @if ($accommodationSupplement->price_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price_type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="kt-badge kt-badge-info">{{ $accommodationSupplement->price_type }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($accommodationSupplement->applicable_date)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.applicable_date') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->applicable_date->format('Y-m-d') }}
                                </p>
                            </div>
                        @endif
                        <div class="col-span-2 flex items-center gap-10 mb-2">
                            <div wire:key="toggle-{{ $accommodationSupplement->id }}-is_active">
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $accommodationSupplement->id,
                                        'modelType' => '\\App\\Models\\AccommodationSupplement',
                                        'field' => 'is_active',
                                        'value' => (bool) $accommodationSupplement->is_active,
                                        'table' => 'accommodations-supplements',
                                    ])
                                </div>
                            </div>
                            <div wire:key="toggle-{{ $accommodationSupplement->id }}-is_mandatory">
                                <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $accommodationSupplement->id,
                                        'modelType' => '\\App\\Models\\AccommodationSupplement',
                                        'field' => 'is_mandatory',
                                        'value' => (bool) $accommodationSupplement->is_mandatory,
                                        'table' => 'accommodations-supplements',
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($accommodationSupplement->notes)
                        <div class="mt-3">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $accommodationSupplement->notes !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodationSupplement->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodationSupplement->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Accommodation -->
            <div class="kt-card record-{{ $accommodationSupplement->accommodation_id }}">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.accommodation_details') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($accommodationSupplement->accommodation)
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodationSupplement->accommodation->name ?: __('main.na') }}</p>
                            </div>
                            @if ($accommodationSupplement->accommodation->name_ar)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->name_ar }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->type)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->type->name }}
                                    </p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->classification)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->classification }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->stars)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $accommodationSupplement->accommodation->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->currency)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->currency->code }} -
                                        {{ $accommodationSupplement->accommodation->currency->name }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->city || $accommodationSupplement->accommodation->country)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.location') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->city?->name ?? '' }}
                                        {{ $accommodationSupplement->accommodation->city && $accommodationSupplement->accommodation->country ? ', ' : '' }}
                                        {{ $accommodationSupplement->accommodation->country?->name ?? '' }}
                                    </p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->general_mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->general_mobile }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->general_email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->general_email }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->contact_person)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->contact_person }}</p>
                                </div>
                            @endif
                            @if ($accommodationSupplement->accommodation->street)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.street') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $accommodationSupplement->accommodation->street }}</p>
                                </div>
                            @endif
                            <div class="col-span-2 flex items-center gap-10 mb-2">
                                <div wire:key="toggle-{{ $accommodationSupplement->accommodation->id }}-is_active">
                                    <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $accommodationSupplement->accommodation->id,
                                            'modelType' => '\\App\\Models\\Accommodation',
                                            'field' => 'is_active',
                                            'value' => (bool) $accommodationSupplement->accommodation->is_active,
                                            'table' => 'accommodations',
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($accommodationSupplement->accommodation->notes)
                            <div class="mt-3">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">{!! $accommodationSupplement->accommodation->notes !!}
                                </div>
                            </div>
                        @endif
                        <div class="flex gap-2 mt-3">
                            @include('components.elements.show-button', [
                                'models' => 'accommodations',
                                'id' => $accommodationSupplement->accommodation->id,
                            ])
                            @include('components.elements.edit-button', [
                                'models' => 'accommodations',
                                'id' => $accommodationSupplement->accommodation->id,
                            ])
                        </div>
                    @else
                        <div class="text-center py-8 text-secondary-foreground">
                            <i class="ki-filled ki-information text-4xl mb-2"></i>
                            <p>{{ __('main.no_accommodation_linked') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'accommodations-supplements',
                    'id' => $accommodationSupplement->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'accommodations-supplement',
                    'modelId' => $accommodationSupplement->id,
                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                    'table' => 'accommodations_supplements',
                ])
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations-supplements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
