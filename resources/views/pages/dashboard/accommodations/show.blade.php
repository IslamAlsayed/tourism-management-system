@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.accommodation')]))
@push('styles')
    <style>
        /* Define the size of the map container */
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush
@push('scripts')
    <script>
        function initMap() {
            let mapContainer = document.getElementById('map');
            let title = mapContainer.getAttribute('data-title');
            let latitude = mapContainer.getAttribute('data-latitude');
            let longitude = mapContainer.getAttribute('data-longitude');
            const latLng = {
                lat: parseFloat(latitude),
                lng: parseFloat(longitude)
            };
            const mapOptions = {
                zoom: 15,
                center: latLng,
            };
            const map = new google.maps.Map(mapContainer, mapOptions);
            new google.maps.Marker({
                position: latLng,
                map: map,
                title: title,
            });
        }
        window.initMap = initMap;
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
    </script>
@endpush

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
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('types.show', $accommodation->type->id) }}"
                                        class="kt-badge kt-badge-primary">
                                        #{{ $accommodation->type->id }} | {{ $accommodation->type->name }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($accommodation->seasons)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.seasons') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($accommodation->seasons as $season)
                                        <a href="{{ route('seasons.show', $season->season->id) }}"
                                            class="kt-badge kt-badge-info">
                                            #{{ $season->season->id }} | {{ $season->season->name }}
                                        </a>
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
                                    {{ $accommodation->classification ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->stars)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= $accommodation->stars ? 'text-yellow-500' : 'text-gray-300' }} text-sm"></i>
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
                        @if ($accommodation->notes)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $accommodation->notes !!}
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
                                <a href="{{ route('regions.show', $accommodation->region->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $accommodation->region->name }}
                                </a>
                            </div>
                        @endif
                        @if ($accommodation->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <a href="{{ route('subregions.show', $accommodation->subregion->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $accommodation->subregion->name }}
                                </a>
                            </div>
                        @endif
                        @if ($accommodation->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <a href="{{ route('countries.show', $accommodation->country->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $accommodation->country->name }}
                                </a>
                            </div>
                        @endif
                        @if ($accommodation->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <a href="{{ route('states.show', $accommodation->state->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $accommodation->state->name }}
                                </a>
                            </div>
                        @endif
                        @if ($accommodation->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <a href="{{ route('cities.show', $accommodation->city->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $accommodation->city->name }}
                                </a>
                            </div>
                        @endif
                        @if ($accommodation->street)
                            <div class="col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->street }}</p>
                            </div>
                        @endif
                        @if ($accommodation->box)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.box') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->box }}</p>
                            </div>
                        @endif
                        @if ($accommodation->postal_code)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $accommodation->postal_code }}</p>
                            </div>
                        @endif
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
                            <a href="https://maps.google.com?q={{ $accommodation->latitude }},{{ $accommodation->longitude }}"
                                target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $accommodation->title }}"
                                    data-latitude="{{ $accommodation->latitude }}"
                                    data-longitude="{{ $accommodation->longitude }}"
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
                                    {{ $accommodation->currency->name . ' - ' . $accommodation->currency->code }}
                                </p>
                            </div>
                        @endif
                        @if ($accommodation->contract_file_path)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.contract_file') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ Storage::url($accommodation->contract_file_path) }}" target="_blank"
                                        class="text-primary hover:underline">
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

            <!-- Seasons for this accommodation -->
            <div class="kt-card bg-blue-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.seasons') }}
                        (<span class="font-semibold text-primary">{{ $accommodation->seasons->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('seasons.create') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.season')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($accommodation->seasons as $accommodationSeason)
                            @php
                                $season = $accommodationSeason->season;
                            @endphp
                            <div wire:key="season-{{ $season->id }}" class="kt-card bg-white rounded-lg p-4 pt-2">
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
                                @if ($season->notes)
                                    <div class="lg:col-span-2 mt-2 border-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $season->notes !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
                                    @include('components.elements.show-button', [
                                        'models' => 'seasons',
                                        'id' => $season->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'seasons',
                                        'id' => $season->id,
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('seasons.create') }}" class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.add_first_season') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Rooms for this accommodation -->
            <div class="kt-card bg-green-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.rooms') }}
                        (<span class="font-semibold text-primary">{{ $accommodation->roomRates->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('rooms.create') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.room')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @php
                            $rooms = $accommodation->roomRates
                                ->groupBy('room_id')
                                ->map(function ($rates) {
                                    return $rates->first()->room;
                                })
                                ->unique('id');
                        @endphp
                        @forelse($rooms as $room)
                            <div wire:key="room-{{ $room->id }}" class="kt-card bg-white rounded-lg p-4 pt-2">
                                <div class="grid lg:grid-cols-2 gap-4">
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                        <p class="text-sm text-secondary-foreground">
                                            {{ $room->name ?: __('main.na') }}</p>
                                    </div>
                                    @if ($room->name_ar)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $room->name_ar }}</p>
                                        </div>
                                    @endif
                                    @if ($room->max_occupancy)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.max_occupancy') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $room->max_occupancy }}</p>
                                        </div>
                                    @endif
                                    @if ($room->occupancy_details)
                                        <div>
                                            <label class="kt-label mb-1">{{ __('main.occupancy_details') }}</label>
                                            <p class="text-sm text-secondary-foreground">{{ $room->occupancy_details }}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="col-span-2 flex items-center gap-10 mb-2">
                                        <div wire:key="toggle-{{ $room->id }}-is_active">
                                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                            <div class="flex items-center gap-2">
                                                @livewire('toggle-switch', [
                                                    'modelId' => $room->id,
                                                    'modelType' => '\\App\\Models\\Room',
                                                    'field' => 'is_active',
                                                    'value' => (bool) $room->is_active,
                                                    'table' => 'rooms',
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Room Rates by Season --}}
                                @php
                                    $roomRates = $accommodation->roomRates->where('room_id', $room->id);
                                @endphp
                                @if ($roomRates->isNotEmpty())
                                    <div class="lg:col-span-2 mt-3 border-t pt-3">
                                        <label class="kt-label mb-2">{{ __('main.pricing_by_season') }}</label>
                                        <div class="space-y-2">
                                            @foreach ($roomRates as $rate)
                                                @php
                                                    $season = $rate->season;
                                                    $currency = $rate->currency;
                                                @endphp
                                                <div class="bg-blue-50 p-3 rounded-lg">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="font-medium text-sm">{{ $season->name }}</span>
                                                        <span
                                                            class="text-xs text-gray-500">{{ $season->season_from->format('Y-m-d') }}
                                                            → {{ $season->season_to->format('Y-m-d') }}</span>
                                                    </div>
                                                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-xs">
                                                        <div>
                                                            <span
                                                                class="text-gray-600">{{ __('main.price_per_person_double') }}:</span>
                                                            <span
                                                                class="font-semibold">{{ number_format($rate->price_per_person_double, 2) }}
                                                                {{ $currency->code }}</span>
                                                        </div>
                                                        @if ($rate->single_room_supplement)
                                                            <div>
                                                                <span
                                                                    class="text-gray-600">{{ __('main.single_room_supplement') }}:</span>
                                                                <span
                                                                    class="font-semibold">{{ number_format($rate->single_room_supplement, 2) }}
                                                                    {{ $currency->code }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($rate->triple_room_discount)
                                                            <div>
                                                                <span
                                                                    class="text-gray-600">{{ __('main.triple_room_discount') }}:</span>
                                                                <span
                                                                    class="font-semibold">{{ number_format($rate->triple_room_discount, 2) }}
                                                                    {{ $currency->code }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($rate->third_person_price)
                                                            <div>
                                                                <span
                                                                    class="text-gray-600">{{ __('main.third_person_price') }}:</span>
                                                                <span
                                                                    class="font-semibold">{{ number_format($rate->third_person_price, 2) }}
                                                                    {{ $currency->code }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($rate->extra_bed_price)
                                                            <div>
                                                                <span
                                                                    class="text-gray-600">{{ __('main.extra_bed_price') }}:</span>
                                                                <span
                                                                    class="font-semibold">{{ number_format($rate->extra_bed_price, 2) }}
                                                                    {{ $currency->code }}</span>
                                                            </div>
                                                        @endif
                                                        @if ($rate->sea_view_supplement)
                                                            <div>
                                                                <span
                                                                    class="text-gray-600">{{ __('main.sea_view_supplement') }}:</span>
                                                                <span
                                                                    class="font-semibold">{{ number_format($rate->sea_view_supplement, 2) }}
                                                                    {{ $currency->code }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($room->description)
                                    <div class="lg:col-span-2 mt-2 border-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $room->description !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
                                    @include('components.elements.show-button', [
                                        'models' => 'rooms',
                                        'id' => $room->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'rooms',
                                        'id' => $room->id,
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('rooms.create') }}" class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.add_first_room') }}
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Meals for this accommodation -->
            <div class="kt-card bg-orange-100">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.meals') }}
                        (<span class="font-semibold text-primary">{{ $accommodation->mealRates->count() }}</span>)
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
                        @php
                            $meals = $accommodation->mealRates
                                ->groupBy('meal_id')
                                ->map(function ($rates) {
                                    return $rates->first()->meal;
                                })
                                ->unique('id');
                        @endphp
                        @forelse($meals as $meal)
                            <div wire:key="meal-{{ $meal->id }}" class="kt-card bg-white rounded-lg p-4 pt-2">
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

                                {{-- Meal Rates by Season --}}
                                @php
                                    $mealRates = $accommodation->mealRates->where('meal_id', $meal->id);
                                @endphp
                                @if ($mealRates->isNotEmpty())
                                    <div class="lg:col-span-2 mt-3 border-t pt-3">
                                        <label class="kt-label mb-2">{{ __('main.pricing_by_season') }}</label>
                                        <div class="space-y-2">
                                            @foreach ($mealRates as $rate)
                                                @php
                                                    $season = $rate->season;
                                                    $currency = $rate->currency;
                                                @endphp
                                                <div class="bg-blue-50 p-3 rounded-lg">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="font-medium text-sm">{{ $season->name }}</span>
                                                        <span
                                                            class="text-xs text-gray-500">{{ $season->season_from->format('Y-m-d') }}
                                                            → {{ $season->season_to->format('Y-m-d') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-sm">
                                                        <div>
                                                            <span class="text-gray-600">{{ __('main.price') }}:</span>
                                                            <span
                                                                class="font-semibold text-lg">{{ number_format($rate->price, 2) }}
                                                                {{ $currency->code }}</span>
                                                        </div>
                                                        @if ($rate->is_included)
                                                            <span
                                                                class="kt-badge kt-badge-success">{{ __('main.included') }}</span>
                                                        @endif
                                                        @if ($rate->is_supplement)
                                                            <span
                                                                class="kt-badge kt-badge-info">{{ __('main.supplement') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($meal->notes)
                                    <div class="lg:col-span-2 mt-2 border-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $meal->notes !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
                                    @include('components.elements.show-button', [
                                        'models' => 'meals',
                                        'id' => $meal->id,
                                    ])
                                    @include('components.elements.edit-button', [
                                        'models' => 'meals',
                                        'id' => $meal->id,
                                    ])
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
                                <i class="ki-filled ki-information text-4xl mb-2"></i>
                                <p>{{ __('main.no_data_available') }}</p>
                                <a href="{{ route('meals.create') }}" class="kt-btn kt-btn-sm kt-btn-primary mt-4">
                                    <i class="ki-filled ki-plus text-sm me-1"></i>
                                    {{ __('main.add_first_meal') }}
                                </a>
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
                        (<span class="font-semibold text-primary">{{ $accommodation->supplements->count() }}</span>)
                    </h3>
                    <div class="kt-card-toolbar">
                        <a href="{{ route('accommodations-supplements.create', ['accommodation_id' => $accommodation->id]) }}"
                            class="kt-btn kt-btn-sm kt-btn-primary">
                            <i class="ki-filled ki-plus text-sm me-1"></i>
                            {{ __('main.add_type', ['type' => __('main.supplement')]) }}
                        </a>
                    </div>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid lg:grid-cols-2 gap-4">
                        @forelse($accommodation->supplements as $supplement)
                            <div wire:key="supplement-{{ $supplement->id }}"
                                class="kt-card bg-white rounded-lg p-4 pt-2">
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
                                                    'modelType' => '\\App\\Models\\AccommodationSupplement',
                                                    'field' => 'is_mandatory',
                                                    'value' => (bool) $supplement->is_mandatory,
                                                    'table' => 'accommodations-supplements',
                                                ])
                                            </div>
                                        </div>
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
                                    </div>
                                </div>
                                @if ($supplement->notes)
                                    <div class="lg:col-span-2 mt-2 border-t pt-2">
                                        <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                        <div class="text-sm text-secondary-foreground prose max-w-none">
                                            {!! $supplement->notes !!}</div>
                                    </div>
                                @endif
                                <div class="lg:col-span-2 flex gap-2 mt-2">
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
                            <div class="col-span-2 text-center py-8 text-secondary-foreground">
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
