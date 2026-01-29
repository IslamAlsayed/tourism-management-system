@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.accommodation')]))

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
            <!-- Accommodation Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.accommodation')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($accommodation->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->name_ar ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('types.show', $accommodation->type?->id) }}" class="kt-badge kt-badge-primary">
                                        #{{ $accommodation->type?->id }} | {{ $accommodation->type?->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->classification)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.classification') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-primary">
                                        {{ $accommodation->classification ?: __('main.na') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->stars)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $accommodation->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->seasons)
                            <div class="col-span-full">
                                <label class="kt-label mb-1">{{ __('main.seasons') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($accommodation->seasons as $season)
                                        <a href="{{ route('seasons.show', $season->id) }}" class="kt-badge kt-badge-info">
                                            #{{ $season->id }} | {{ $season->name }}
                                            <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                        </a>
                                    @empty
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endforelse
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
                        @include('components.elements.displayable-rich-text', [
                            'record' => $accommodation,
                            'column' => 'description',
                        ])

                        @include('components.elements.displayable-rich-text', [
                            'record' => $accommodation,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.region') }}</label>
                            @if ($accommodation->region)
                                <a href="{{ route('regions.show', $accommodation->region?->id) }}" class="block text-sm text-primary underline">
                                    {{ $accommodation->region?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            @if ($accommodation->subregion)
                                <a href="{{ route('subregions.show', $accommodation->subregion->id) }}" class="block text-sm text-primary underline">
                                    {{ $accommodation->subregion->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($accommodation->country)
                                <a href="{{ route('countries.show', $accommodation->country?->id) }}" class="block text-sm text-primary underline">
                                    {{ $accommodation->country?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($accommodation->state)
                                <a href="{{ route('states.show', $accommodation->state?->id) }}" class="block text-sm text-primary underline">
                                    {{ $accommodation->state?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($accommodation->city)
                                <a href="{{ route('cities.show', $accommodation->city?->id) }}" class="block text-sm text-primary underline">
                                    {{ $accommodation->city?->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->street ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.box') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->box ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $accommodation->postal_code ?? __('main.na') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.map') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    @if ($accommodation->latitude && $accommodation->longitude)
                        <div>
                            <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $accommodation->latitude }}, {{ $accommodation->longitude }}
                            </p>
                        </div>
                        <div class="col-span-full mt-4">
                            <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                            <a href="https://maps.google.com?q={{ $accommodation->latitude }},{{ $accommodation->longitude }}" target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $accommodation->title }}" data-latitude="{{ $accommodation->latitude }}" data-longitude="{{ $accommodation->longitude }}"
                                    class="rounded-md overflow-hidden shadow"></div>
                            </div>
                        </div>
                    @endif
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
                                    <a href="tel:{{ $accommodation->general_mobile }}" class="text-primary hover:underline">
                                        {{ $accommodation->general_mobile }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->general_email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.general_email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $accommodation->general_email }}" class="text-primary hover:underline">
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
                        @if ($accommodation->phone_ext)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone_ext') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->phone_ext }}</p>
                            </div>
                        @endif
                        @if ($accommodation->fax)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->fax }}</p>
                            </div>
                        @endif
                        @if ($accommodation->email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="mailto:{{ $accommodation->email }}" class="text-primary hover:underline">
                                        {{ $accommodation->email }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->website)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ $accommodation->website }}" target="_blank" class="text-primary hover:underline">
                                        {{ $accommodation->website }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($accommodation->contact_person || $accommodation->contact_position || $accommodation->contact_mobile || $accommodation->contact_email)
                        <div class="border-custom-t pt-4 mt-4">
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
                                            <a href="tel:{{ $accommodation->contact_mobile }}" class="text-primary hover:underline">
                                                {{ $accommodation->contact_mobile }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if ($accommodation->contact_email)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            <a href="mailto:{{ $accommodation->contact_email }}" class="text-primary hover:underline">
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
                        @if ($accommodation->uuid)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.uuid') }}</label>
                                <p class="text-sm text-secondary-foreground font-mono">
                                    {{ $accommodation->uuid }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->currency_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $accommodation->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $accommodation->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->contract_file_path)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.contract_file') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ Storage::url($accommodation->contract_file_path) }}" target="_blank" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        {{ __('main.view_contract') }}
                                    </a>
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

            <!-- Seasons -->
            @if ($accommodation->seasons && $accommodation->seasons->count() > 0)
                @include('pages.dashboard.related-components.seasons', [
                    'record' => $accommodation,
                    'type' => 'accommodation',
                ])
            @endif

            <!-- Rooms -->
            @if ($accommodation->rooms && $accommodation->rooms->count() > 0)
                @include('pages.dashboard.related-components.rooms', ['record' => $accommodation])
            @endif

            <!-- Meals -->
            @if ($accommodation->meals && $accommodation->meals->count() > 0)
                @include('pages.dashboard.related-components.meals', [
                    'record' => $accommodation,
                    'type' => 'accommodation',
                ])
            @endif

            <!-- Supplements -->
            @if ($accommodation->supplements && $accommodation->supplements->count() > 0)
                @include('pages.dashboard.related-components.supplements', [
                    'record' => $accommodation,
                    'type' => 'accommodation',
                ])
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'accommodations',
                    'id' => $accommodation->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'accommodations',
                    'id' => $accommodation->id,
                ])
                <a href="{{ route('accommodations.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodations')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
