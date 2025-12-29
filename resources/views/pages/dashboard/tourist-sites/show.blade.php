@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist_site')]))

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
                    {{ $touristSite->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $touristSite->city?->name ?? __('main.na') }}, {{ $touristSite->country?->name ?? __('main.na') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.edit', $touristSite->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist_sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Tourist Site Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tourist-site')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.site_code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->site_code ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->name_ar ?: __('main.na') }}</p>
                        </div>
                        @if ($touristSite->site_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.site_type') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-primary">{{ $touristSite->site_type }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-primary">{{ $touristSite->category }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->status)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.status') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-success">{{ ucfirst($touristSite->status) }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->average_rating)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.average_rating') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($touristSite->average_rating, 0) }}/5
                                    <i class="fas fa-star" style="color: #ffdd00"></i>
                                </p>
                            </div>
                        @endif
                        @if ($touristSite->total_reviews)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.total_reviews') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->total_reviews }}</p>
                            </div>
                        @endif
                        @if ($touristSite->popularity_score)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.popularity_score') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->popularity_score }}</p>
                            </div>
                        @endif
                        @if ($touristSite->currency_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $touristSite->currency->name . ' - ' . $touristSite->currency->code }}
                                </p>
                            </div>
                        @endif
                        @if ($touristSite->tags)
                            <div class="col-span-full mb-4">
                                <label class="kt-label mb-1">{{ __('main.tags') }}</label><br />
                                @foreach ($touristSite->tags as $tag)
                                    <span class="kt-badge kt-badge-info">{{ ucfirst($tag) }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristSite->id,
                                        'modelType' => '\\App\\Models\\TouristSite',
                                        'field' => 'is_active',
                                        'value' => (bool) $touristSite->is_active,
                                        'table' => 'touristSites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristSite->id,
                                        'modelType' => '\\App\\Models\\TouristSite',
                                        'field' => 'is_featured',
                                        'value' => (bool) $touristSite->is_featured,
                                        'table' => 'touristSites',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_verified') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristSite->id,
                                        'modelType' => '\\App\\Models\\TouristSite',
                                        'field' => 'is_verified',
                                        'value' => (bool) $touristSite->is_verified,
                                        'table' => 'touristSites',
                                    ])
                                </div>
                            </div>
                        </div>
                        @if ($touristSite->description)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $touristSite->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->notes)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $touristSite->notes !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- facilities -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.facilities') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap gap-" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.wheelchair_accessible') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'wheelchair_accessible',
                                    'value' => (bool) $touristSite->wheelchair_accessible,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.free_wifi') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'free_wifi',
                                    'value' => (bool) $touristSite->free_wifi,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.parking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'parking',
                                    'value' => (bool) $touristSite->parking,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.restrooms') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'restrooms',
                                    'value' => (bool) $touristSite->restrooms,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.restaurants') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'restaurants',
                                    'value' => (bool) $touristSite->restaurants,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.gift_shop') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'gift_shop',
                                    'value' => (bool) $touristSite->gift_shop,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.guided_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'guided_tours',
                                    'value' => (bool) $touristSite->guided_tours,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.audio_guide') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'audio_guide',
                                    'value' => (bool) $touristSite->audio_guide,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- activities -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.activities') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap gap-" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.photography') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'photography',
                                    'value' => (bool) $touristSite->photography,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.hiking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'hiking',
                                    'value' => (bool) $touristSite->hiking,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.swimming') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'swimming',
                                    'value' => (bool) $touristSite->swimming,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.camping') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'camping',
                                    'value' => (bool) $touristSite->camping,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.shopping') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'shopping',
                                    'value' => (bool) $touristSite->shopping,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.dining') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'dining',
                                    'value' => (bool) $touristSite->dining,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.entertainment') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'entertainment',
                                    'value' => (bool) $touristSite->entertainment,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.educational_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'educational_tours',
                                    'value' => (bool) $touristSite->educational_tours,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- services -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.services') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap gap-" style="gap: 10px 40px;">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.translation') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'translation',
                                    'value' => (bool) $touristSite->translation,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.special_events') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'special_events',
                                    'value' => (bool) $touristSite->special_events,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.group_bookings') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'group_bookings',
                                    'value' => (bool) $touristSite->group_bookings,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.online_booking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'online_booking',
                                    'value' => (bool) $touristSite->online_booking,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.mobile_app') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'mobile_app',
                                    'value' => (bool) $touristSite->mobile_app,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.virtual_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'virtual_tours',
                                    'value' => (bool) $touristSite->virtual_tours,
                                    'table' => 'touristSites',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media & Resources -->
            @if (
                $touristSite->main_image ||
                    $touristSite->gallery_images ||
                    $touristSite->video_url ||
                    $touristSite->virtual_tour_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.main_image') }}</label>
                                <div class="mt-2">
                                    @if ($touristSite->main_image)
                                        <img src="{{ asset('storage/' . $touristSite->main_image) }}" alt="Main Image"
                                            class="max-w-md rounded-lg shadow-md">
                                    @else
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endif
                                </div>
                            </div>

                            @if ($touristSite->video_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.video_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->video_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristSite->video_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($touristSite->virtual_tour_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.virtual_tour_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->virtual_tour_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristSite->virtual_tour_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            <div class="col-span-full">
                                <label class="kt-label">{{ __('main.gallery_images') }}</label>
                                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @if ($touristSite->gallery_images && count($touristSite->gallery_images) > 0)
                                        @foreach ($touristSite->gallery_images as $image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery"
                                                class="w-full h-40 object-cover rounded-lg shadow">
                                        @endforeach
                                    @else
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Entry Information -->
            @if (
                $touristSite->entry_fee_adult ||
                    $touristSite->entry_fee_child ||
                    $touristSite->entry_fee_student ||
                    $touristSite->entry_fee_senior ||
                    $touristSite->entry_fee_group)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.entry_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristSite->is_free_entry)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.is_free_entry') }}</label>
                                    <p class="kt-badge kt-badge-success">{{ __('main.yes') }}</p>
                                </div>
                            @endif
                            @if ($touristSite->entry_fee_adult)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_adult') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristSite->entry_fee_adult, 2) }}
                                        {{ $touristSite->currency->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->entry_fee_child)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_child') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristSite->entry_fee_child, 2) }}
                                        {{ $touristSite->currency->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->entry_fee_student)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_student') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristSite->entry_fee_student, 2) }}
                                        {{ $touristSite->currency->code }}</p>
                                </div>
                            @endif
                            @if ($touristSite->entry_fee_senior)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_senior') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristSite->entry_fee_senior, 2) }}
                                        {{ $touristSite->currency->code }}</p>
                                </div>
                            @endif
                            @if ($touristSite->entry_fee_group)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_group') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristSite->entry_fee_group, 2) }}
                                        {{ $touristSite->currency->code }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Operating Hours -->
            @if ($touristSite->opening_time || $touristSite->closing_time || $touristSite->operating_days)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @if ($touristSite->is_24_hours)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.is_24_hours') }}</label>
                                    <p class="kt-badge kt-badge-success">{{ __('main.yes') }}</p>
                                </div>
                            @endif
                            @if ($touristSite->opening_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.opening_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristSite->opening_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if ($touristSite->closing_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.closing_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristSite->closing_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if ($touristSite->operating_days && count($touristSite->operating_days) > 0)
                                <div class="sm:col-span-3">
                                    <label class="kt-label mb-1">{{ __('main.operating_days') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-2">
                                        @foreach ($touristSite->operating_days as $day)
                                            <span class="kt-badge kt-badge-info">
                                                @if ($day == 1)
                                                    {{ __('main.monday') }}
                                                @elseif($day == 2)
                                                    {{ __('main.tuesday') }}
                                                @elseif($day == 3)
                                                    {{ __('main.wednesday') }}
                                                @elseif($day == 4)
                                                    {{ __('main.thursday') }}
                                                @elseif($day == 5)
                                                    {{ __('main.friday') }}
                                                @elseif($day == 6)
                                                    {{ __('main.saturday') }}
                                                @elseif($day == 7)
                                                    {{ __('main.sunday') }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Visitor Information -->
            @if (
                $touristSite->estimated_visit_duration ||
                    $touristSite->difficulty_level ||
                    $touristSite->age_restrictions ||
                    $touristSite->best_visit_time)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.visitor')]) }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristSite->estimated_visit_duration)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.estimated_visit_duration') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristSite->estimated_visit_duration }} {{ __('main.minutes') }}</p>
                                </div>
                            @endif
                            @if ($touristSite->difficulty_level)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.difficulty_level') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="kt-badge kt-badge-info">{{ ucfirst($touristSite->difficulty_level) }}</span>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->age_restrictions && count($touristSite->age_restrictions) > 0)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.age_restrictions') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-1">
                                        @foreach ($touristSite->age_restrictions as $restriction)
                                            <span class="kt-badge kt-badge-warning">{{ $restriction }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($touristSite->best_visit_time && count($touristSite->best_visit_time) > 0)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.best_visit_time') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-1">
                                        @foreach ($touristSite->best_visit_time as $time)
                                            <span class="kt-badge kt-badge-success">{{ ucfirst($time) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Information -->
            @if (
                $touristSite->phone ||
                    $touristSite->mobile ||
                    $touristSite->email ||
                    $touristSite->website_url ||
                    $touristSite->facebook_url ||
                    $touristSite->instagram_url ||
                    $touristSite->twitter_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristSite->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristSite->phone }}" class="text-blue-600 hover:underline">
                                            {{ $touristSite->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristSite->mobile }}" class="text-blue-600 hover:underline">
                                            {{ $touristSite->mobile }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $touristSite->email }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristSite->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->website_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->website_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ __('main.visit_website') }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->facebook_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.facebook_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->facebook_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Facebook
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->instagram_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.instagram_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->instagram_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Instagram
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->twitter_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.twitter_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->twitter_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Twitter
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.location')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="flex flex-wrap justify-between gap-10">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.region') }}</label>
                            @if ($touristSite->region)
                                <a href="{{ route('regions.show', $touristSite->region->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristSite->region->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            @if ($touristSite->subregion)
                                <a href="{{ route('subregions.show', $touristSite->subregion->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristSite->subregion->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($touristSite->country)
                                <a href="{{ route('countries.show', $touristSite->country->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristSite->country->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($touristSite->state)
                                <a href="{{ route('states.show', $touristSite->state->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristSite->state->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($touristSite->city)
                                <a href="{{ route('cities.show', $touristSite->city->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristSite->city->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->postal_code ?? __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->latitude ?? __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->longitude ?? __('main.na') }}
                            </p>
                        </div>
                        <div class="col-span-full">
                            <label class="kt-label mb-1">{{ __('main.address') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $touristSite->address ?? __('main.na') !!}
                            </div>
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
                    @if ($touristSite->latitude && $touristSite->longitude)
                        <div>
                            <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->latitude }}, {{ $touristSite->longitude }}
                            </p>
                        </div>
                        <div class="col-span-full mt-4">
                            <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                            <a href="https://maps.google.com?q={{ $touristSite->latitude }},{{ $touristSite->longitude }}"
                                target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $touristSite->title }}"
                                    data-latitude="{{ $touristSite->latitude }}"
                                    data-longitude="{{ $touristSite->longitude }}"
                                    class="rounded-md overflow-hidden shadow"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            @if (
                $touristSite->phone ||
                    $touristSite->mobile ||
                    $touristSite->email ||
                    $touristSite->website_url ||
                    $touristSite->facebook_url ||
                    $touristSite->instagram_url ||
                    $touristSite->twitter_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristSite->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristSite->phone }}" class="text-blue-600 hover:underline">
                                            {{ $touristSite->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristSite->mobile }}" class="text-blue-600 hover:underline">
                                            {{ $touristSite->mobile }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $touristSite->email }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristSite->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->website_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->website_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">{{ __('main.visit_website') }}</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->facebook_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.facebook_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->facebook_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Facebook</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->instagram_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.instagram_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->instagram_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Instagram</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristSite->twitter_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.twitter_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->twitter_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Twitter</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($touristSite->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($touristSite->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tourist-sites',
                    'id' => $touristSite->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'tourist-sites',
                    'id' => $touristSite->id,
                ])
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
