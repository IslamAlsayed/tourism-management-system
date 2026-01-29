@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist-site')]))

@push('scripts')
    @include('components.scripts.setup-map')
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $touristSite->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $touristSite->city?->name ?? __('main.na') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.edit', $touristSite->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tourist-site')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->name_ar ?: __('main.na') }}</p>
                        </div>
                        @if ($touristSite->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <a href="{{ route('cities.show', $touristSite->city->id) }}" class="block text-sm text-primary underline">
                                    {{ $touristSite->city->name }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($touristSite->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $touristSite->currency->name }}
                                    <span class="text-primary font-semibold">
                                        ({{ $touristSite->currency->code }})
                                    </span>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->sort_order ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'is_active',
                                    'value' => (bool) $touristSite->is_active,
                                    'table' => 'tourist_sites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.unesco_site') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'unesco_site',
                                    'value' => (bool) $touristSite->unesco_site,
                                    'table' => 'tourist_sites',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristSite,
                            'column' => 'nearby_attractions',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristSite,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristSite,
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($touristSite->city || $touristSite->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <a href="{{ route('countries.show', $touristSite->city->country->id) }}" class="block text-sm text-primary underline">
                                    {{ $touristSite->city->country?->name ?? '' }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($touristSite->city || $touristSite->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <a href="{{ route('states.show', $touristSite->city->state->id) }}" class="block text-sm text-primary underline">
                                    {{ $touristSite->city->state?->name ?? '' }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        @if ($touristSite->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <a href="{{ route('cities.show', $touristSite->city->id) }}" class="block text-sm text-primary underline">
                                    {{ $touristSite->city?->name ?? '' }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->latitude ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->longitude ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.site_type') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->site_type ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.supplier_type') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->supplier_type ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sites_theme') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->sites_theme ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.supplier_name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->supplier_name ?: __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->postal_code ?: __('main.na') }}</p>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $touristSite,
                            'column' => 'address',
                        ])
                    </div>
                </div>
            </div>

            <!-- Entry Fees -->
            @if ($touristSite->is_free_entry || $touristSite->entry_fee_adult || $touristSite->entry_fee_child || $touristSite->entry_fee_foreigner_adult)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.entry_fees') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach (['entry_fee_adult', 'entry_fee_child', 'entry_fee_student', 'entry_fee_senior', 'entry_fee_group', 'entry_fee_foreigner_adult', 'entry_fee_foreigner_child', 'entry_fee_arab_adult', 'entry_fee_arab_child', 'entry_fee_local_adult', 'entry_fee_local_child', 'entry_fee_resident_adult', 'entry_fee_resident_child'] as $fee)
                                @if ($touristSite->$fee)
                                    <div>
                                        <label class="kt-label mb-1">{{ __('main.' . $fee) }}</label>
                                        <p class="text-sm text-secondary-foreground">{{ $touristSite->$fee }} {{ $touristSite->currency?->code ?? '' }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Operating Hours -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_24_7') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'is_24_7',
                                    'value' => (bool) $touristSite->is_24_7,
                                    'table' => 'tourist_sites',
                                ])
                            </div>
                        </div>
                        @if (!$touristSite->is_24_7)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.opening_time') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->opening_time ?: __('main.na') }}</p>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.closing_time') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->closing_time ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($touristSite->operating_days)
                            <div class="col-span-full">
                                <label class="kt-label mb-2">{{ __('main.operating_days') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @php
                                        $days = is_array($touristSite->operating_days) ? $touristSite->operating_days : json_decode($touristSite->operating_days, true) ?? [];
                                    @endphp
                                <div class="flex flex-wrap gap-4">
                                    @foreach ($days as $day)
                                        <span class="kt-badge kt-badge-info">{{ __('main.' . $day) }}</span>
                                    @endforeach
                                </div>
                                </p>
                            </div>
                        @endif
                        @if ($touristSite->special_hours)
                            <div class="col-span-full">
                                <label class="kt-label mb-2">{{ __('main.special_hours') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    @php
                                        $hours = is_array($touristSite->special_hours) ? $touristSite->special_hours : json_decode($touristSite->special_hours, true) ?? [];
                                    @endphp
                                <div class="flex flex-wrap" style="gap: 10px 20px;">
                                    @foreach ($hours as $hourDate => $time)
                                        <div class="border-custom p-2 rounded-md">
                                            <strong class="text-primary">{{ __('main.' . $hourDate) }}</strong>
                                            <strong>{{ \Carbon\Carbon::parse($hourDate)->format('F j, Y') }}:</strong>
                                            @if (isset($time['closed']) && $time['closed'])
                                                <span class="text-danger font-semibold">{{ __('main.closed') }}</span>
                                            @else
                                                <span>{{ $time['opening'] ?? __('main.na') }} - {{ $time['closing'] ?? __('main.na') }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                </p>
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
                        @if ($touristSite->contact_person)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.contact_person') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->contact_person }}</p>
                            </div>
                        @endif
                        @if ($touristSite->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <div>
                                    <a href="tel:{{ $touristSite->phone }}" class="text-sm text-primary underline">
                                        {{ $touristSite->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <div>
                                    <a href="tel:{{ $touristSite->mobile }}" class="text-sm text-primary underline">
                                        {{ $touristSite->mobile }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <div>
                                    <a href="mailto:{{ $touristSite->email }}" class="text-sm text-primary underline">
                                        {{ $touristSite->email }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->website_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->website_url }}" target="_blank" class="text-sm text-primary underline">
                                        {{ $touristSite->website_url }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->facebook_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.facebook_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->facebook_url }}" target="_blank" class="text-sm text-primary underline">
                                        Facebook
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->instagram_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.instagram_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->instagram_url }}" target="_blank" class="text-sm text-primary underline">
                                        Instagram
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->twitter_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.twitter_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->twitter_url }}" target="_blank" class="text-sm text-primary underline">
                                        Twitter
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->fax)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.fax') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->fax }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Facilities & Services -->
            @php
                $facilities = [
                    'wheelchair_accessible',
                    'free_wifi',
                    'parking',
                    'restrooms',
                    'restaurants',
                    'gift_shop',
                    'guided_tours',
                    'audio_guide',
                    'photography',
                    'hiking',
                    'swimming',
                    'camping',
                    'shopping',
                    'dining',
                    'entertainment',
                    'educational_tours',
                    'translation',
                    'special_events',
                    'group_bookings',
                    'online_booking',
                    'mobile_app',
                    'virtual_tours',
                ];
                $hasFacilities = collect($facilities)->some(fn($f) => $touristSite->$f);
            @endphp
            @if ($hasFacilities)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.facilities_services') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach ($facilities as $facility)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.' . $facility) }}</label>
                                    <div class="flex items-center gap-2">
                                        @livewire('toggle-switch', [
                                            'modelId' => $touristSite->id,
                                            'modelType' => '\\App\\Models\\TouristSite',
                                            'field' => $facility,
                                            'value' => (bool) $touristSite->$facility,
                                            'table' => 'tourist_sites',
                                        ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($touristSite->local_guide_price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.local_guide_price') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->local_guide_price }} {{ $touristSite->currency?->code ?? '' }}</p>
                            </div>
                        @endif
                        @if ($touristSite->club_car_price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.club_car_price') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->club_car_price }} {{ $touristSite->currency?->code ?? '' }}</p>
                            </div>
                        @endif
                        @if ($touristSite->video_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.video_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->video_url }}" target="_blank" class="text-sm text-primary underline">
                                        Video
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if ($touristSite->virtual_tour_url)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.virtual_tour_url') }}</label>
                                <div>
                                    <a href="{{ $touristSite->virtual_tour_url }}" target="_blank" class="text-sm text-primary underline">
                                        Virtual Tour
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
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
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->popularity_score }}%</p>
                            </div>
                        @endif
                        @if ($touristSite->estimated_visit_duration)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.estimated_visit_duration') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->estimated_visit_duration }} {{ __('main.minutes') }}</p>
                            </div>
                        @endif
                        @if ($touristSite->difficulty_level)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.difficulty_level') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ __('main.' . strtolower($touristSite->difficulty_level)) }}</p>
                            </div>
                        @endif
                        @if ($touristSite->tags)
                            <div class="col-span-full">
                                <label class="kt-label mb-1">{{ __('main.tags') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $tags = is_array($touristSite->tags) ? $touristSite->tags : json_decode($touristSite->tags, true) ?? [];
                                    @endphp
                                    @foreach ($tags as $tag)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'is_featured',
                                    'value' => (bool) $touristSite->is_featured,
                                    'table' => 'tourist_sites',
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
                                    'table' => 'tourist_sites',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.has_unified_ticket') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristSite->id,
                                    'modelType' => '\\App\\Models\\TouristSite',
                                    'field' => 'has_unified_ticket',
                                    'value' => (bool) $touristSite->has_unified_ticket,
                                    'table' => 'tourist_sites',
                                ])
                            </div>
                        </div>
                        @if ($touristSite->status)
                            <div>
                                <label class="kt-label mb-1">
                                    {{ __('main.status') }}
                                    <div class="hidden search-load">
                                        @include('components.load-data', ['width' => '15px', 'height' => '15px'])
                                    </div>
                                </label>
                                <select class="kt-input kt-input-sm basic-single disabled-option js-async-field" data-model="touristSites" data-id="{{ $touristSite->id }}" data-field="status">
                                    <option value="active" {{ $touristSite->status === 'active' ? 'selected' : '' }}>
                                        {{ __('main.active') }}
                                    </option>
                                    <option value="maintenance" {{ $touristSite->status === 'maintenance' ? 'selected' : '' }}>
                                        {{ __('main.maintenance') }}
                                    </option>
                                    <option value="retired" {{ $touristSite->status === 'retired' ? 'selected' : '' }}>
                                        {{ __('main.retired') }}
                                    </option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Services -->
            @if ($touristSite->services && $touristSite->services->count() > 0)
                @include('pages.dashboard.related-components.services', [
                    'record' => $touristSite,
                    'type' => 'tourist-sites',
                ])
            @endif

            <!-- Metadata -->
            @include('components.metadata', ['record' => $touristSite])

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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.basic-single').select2();

            $(document).on('focus', '.js-async-field', function() {
                $(this).data('old-value', this.value);
            });

            $(document).on('change', '.js-async-field', async function() {
                const $select = $(this);
                const wrapper = $select.closest('div');
                const searchLoad = document.querySelector('.search-load');
                const asyncField = document.querySelector('.js-async-field');

                const payload = {
                    model: $select.data('model'),
                    id: $select.data('id'),
                    field: $select.data('field'),
                    value: $select.val(),
                };

                searchLoad.classList.remove('hidden');
                asyncField.classList.add('disabled');
                $select.prop('disabled', true);

                try {
                    const res = await fetch('{{ route('patch.toggleField') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await res.json();

                    if (!res.ok || !data.success) {
                        throw data;
                    }

                    searchLoad.classList.add('hidden');
                    asyncField.classList.remove('disabled');
                    window.showToast({
                        type: 'success',
                        message: data.message || `{{ __('messages.field_updated_successfully', ['field' => ':field', 'status' => ':status']) }}`.replace(':field', payload
                            .field).replace(':status', payload.value)
                    });
                } catch (e) {
                    $select.val($select.data('old-value')).trigger('change.select2');
                    window.showToast({
                        type: 'error',
                        message: e.message || '{{ __('messages.something_went_wrong') }}'
                    });
                } finally {
                    searchLoad.classList.add('hidden');
                    asyncField.classList.remove('disabled');
                    $select.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
