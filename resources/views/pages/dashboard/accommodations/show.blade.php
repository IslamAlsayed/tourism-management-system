@extends('layouts.master')

@section('title', __('main.accommodation_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $accommodation->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $accommodation->type?->name }} • {{ $accommodation->city?->name }},
                    {{ $accommodation->country?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations.edit', $accommodation->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_accommodations') }}
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
                        @if ($accommodation->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->type)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <span class="kt-badge kt-badge-primary">#{{ $accommodation->type->id }} |
                                        {{ $accommodation->type->name }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->seasons)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.seasons') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($accommodation->seasons as $season)
                                        <span class="kt-badge kt-badge-info">#{{ $season->season->id }} |
                                            {{ $season->season->name }}</span>
                                    @empty
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->classification)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->classification ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($accommodation->stars)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $accommodation->stars)
                                            <i class="fas fa-star text-yellow-500 text-sm"></i>
                                        @else
                                            <i class="fas fa-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $accommodation->id,
                                    'modelType' => '\\App\\Models\\Accommodation',
                                    'field' => 'is_active',
                                    'value' => (bool) $accommodation->is_active,
                                    'table' => 'accommodations',
                                ])
                            </div>
                        </div>
                        @if ($accommodation->description)
                            <div class="col-span-2 border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $accommodation->description !!}
                                </div>
                            </div>
                        @endif
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
                        @if ($accommodation->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->region->name }}</p>
                            </div>
                        @endif
                        @if ($accommodation->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->subregion->name }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->country?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($accommodation->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->city?->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->street)
                            <div class="col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->street }}</p>
                            </div>
                        @endif
                        @if ($accommodation->latitude && $accommodation->longitude)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->latitude }},
                                    {{ $accommodation->longitude }}</p>
                            </div>
                            <div>
                                <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                                <a href="https://maps.google.com?q={{ $accommodation->latitude }},{{ $accommodation->longitude }}"
                                    target="_blank" class="text-sm text-primary hover:underline">
                                    {{ __('main.view_on_google_maps') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($accommodation->general_mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.general_mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $accommodation->general_mobile }}"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->general_mobile }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->general_email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $accommodation->general_email }}"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->general_email }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="tel:{{ $accommodation->phone }}" class="text-primary hover:underline">
                                        {{ $accommodation->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->website)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ $accommodation->website }}" target="_blank"
                                        class="text-primary hover:underline">
                                        {{ $accommodation->website }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    @if (
                        $accommodation->contact_person ||
                            $accommodation->contact_position ||
                            $accommodation->contact_mobile ||
                            $accommodation->contact_email)
                        <div class="border-t pt-4 mt-4">
                            <h4 class="text-lg font-medium mb-4">{{ __('main.contact_person') }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @if ($accommodation->contact_person)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $accommodation->contact_person }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_position)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.position') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $accommodation->contact_position }}
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_mobile)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="tel:{{ $accommodation->contact_mobile }}"
                                                class="text-primary hover:underline">
                                                {{ $accommodation->contact_mobile }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="mailto:{{ $accommodation->contact_email }}"
                                                class="text-primary hover:underline">
                                                {{ $accommodation->contact_email }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($accommodation->currency_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->currency->name . ' - ' . $accommodation->currency->code }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if ($accommodation->updated_at != $accommodation->created_at)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.last_updated') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Supplements -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.supplements') }}</h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('accommodations-supplements.create', ['accommodation_id' => $accommodation->id]) }}"
                            class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.supplement')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4" wire:ignore>
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($accommodation->supplements as $supplement)
                            <div wire:key="supplement-{{ $supplement->id }}-supplement"
                                class="border rounded-lg p-4 pt-2">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $supplement->name }}</p>
                                    </div>
                                    {{-- <div>
                                    <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $supplement->name_ar }}</p>
                                </div> --}}
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ number_format($supplement->price, 2) }}
                                            {{ $accommodation->currency?->code }}
                                        </p>
                                    </div>
                                    {{-- @if ($supplement->applicable_date)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.applicable_date') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $supplement->applicable_date->format('Y-m-d') }}
                                        </p>
                                    </div>
                                @endif --}}
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $supplement->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $supplement->id,
                                                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $supplement->is_active,
                                                    'table' => 'accommodations-supplements',
                                                ])
                                            </div>
                                        </div>
                                        <div wire:key="toggle-{{ $supplement->id }}-is_per_person">
                                            <label class="kt-label mb-1">{{ __('main.is_per_person') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $supplement->id,
                                                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                                                    'field' => 'is_per_person',
                                                    'value' => (bool) $supplement->is_per_person,
                                                    'table' => 'accommodations-supplements',
                                                ])
                                            </div>
                                        </div>
                                        <div wire:key="toggle-{{ $supplement->id }}-is_mandatory">
                                            <label class="kt-label mb-1">{{ __('main.is_mandatory') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $supplement->id,
                                                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                                                    'field' => 'is_mandatory',
                                                    'value' => (bool) $supplement->is_mandatory,
                                                    'table' => 'accommodations-supplements',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($supplement->notes)
                                    <div class="lg:col-span-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <p class="text-sm text-secondary-foreground">{!! $supplement->notes !!}</p>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
                                    {{-- <a href="{{ route('accommodations-supplements.show', $supplement->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">
                                        <i class="ki-filled ki-eye text-sm me-1"></i>
                                        {{ __('main.view') }}
                                    </a>
                                    <a href="{{ route('accommodations-supplements.edit', $supplement->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-primary">
                                        <i class="ki-filled ki-pencil text-sm me-1"></i>
                                        {{ __('main.edit') }}
                                    </a> --}}

                                    @include('components.elements.show-button', [
                                        'models' => 'accommodations-supplements',
                                        'id' => $supplement->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'accommodations-supplements',
                                        'id' => $supplement->id,
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_supplements_available') }}</p>
                                <a href="{{ route('accommodations-supplements.create', ['accommodation_id' => $accommodation->id]) }}"
                                    class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.add_first_supplement') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'accommodations-supplements',
                    'id' => $supplement->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'accommodations-supplement',
                    'modelId' => $supplement->id,
                    'modelType' => '\\App\\Models\\Supplement',
                    'table' => 'supplements',
                ])
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations-supplements')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
