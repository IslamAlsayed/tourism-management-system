@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist-service')]))

@push('scripts')
    @include('components.elements.setup-map')
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $touristService->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $touristService->city?->name ?? __('main.na') }},
                    {{ $touristService->country?->name ?? __('main.na') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-services.edit', $touristService->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Tourist Site Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tourist-service')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.code') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->code ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristService->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->name_ar ?: __('main.na') }}</p>
                        </div>
                        @if ($touristService->site_type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.site_type') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-primary">{{ $touristService->site_type }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristService->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-primary">{{ $touristService->category }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristService->status)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.status') }}</label>
                                <div>
                                    <span class="kt-badge kt-badge-success">{{ ucfirst($touristService->status) }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($touristService->rating)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.rating') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($touristService->rating, 0) }}/5
                                    <i class="fas fa-star" style="color: #ffdd00"></i>
                                </p>
                            </div>
                        @endif
                        @if ($touristService->total_reviews)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.total_reviews') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->total_reviews }}</p>
                            </div>
                        @endif
                        @if ($touristService->popularity_score)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.popularity_score') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->popularity_score }}</p>
                            </div>
                        @endif
                        @if ($touristService->currency_id)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $touristService->currency->name . ' - ' . $touristService->currency->code }}
                                </p>
                            </div>
                        @endif
                        @if ($touristService->tags)
                            <div class="col-span-full mb-4">
                                <label class="kt-label mb-1">{{ __('main.tags') }}</label><br />
                                @foreach ($touristService->tags as $tag)
                                    <span class="kt-badge kt-badge-info">{{ ucfirst($tag) }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristService->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'is_active',
                                        'value' => (bool) $touristService->is_active,
                                        'table' => 'tourist_services',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_featured') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristService->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'is_featured',
                                        'value' => (bool) $touristService->is_featured,
                                        'table' => 'tourist_services',
                                    ])
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-1">{{ __('main.is_verified') }}</label>
                                <div class="flex items-center gap-2">
                                    @livewire('toggle-switch', [
                                        'modelId' => $touristService->id,
                                        'modelType' => '\\App\\Models\\TouristService',
                                        'field' => 'is_verified',
                                        'value' => (bool) $touristService->is_verified,
                                        'table' => 'tourist_services',
                                    ])
                                </div>
                            </div>
                        </div>
                        @if ($touristService->description)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $touristService->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($touristService->notes)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $touristService->notes !!}
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
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'wheelchair_accessible',
                                    'value' => (bool) $touristService->wheelchair_accessible,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.free_wifi') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'free_wifi',
                                    'value' => (bool) $touristService->free_wifi,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.parking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'parking',
                                    'value' => (bool) $touristService->parking,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.restrooms') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'restrooms',
                                    'value' => (bool) $touristService->restrooms,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.restaurants') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'restaurants',
                                    'value' => (bool) $touristService->restaurants,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.gift_shop') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'gift_shop',
                                    'value' => (bool) $touristService->gift_shop,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.guided_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'guided_tours',
                                    'value' => (bool) $touristService->guided_tours,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.audio_guide') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'audio_guide',
                                    'value' => (bool) $touristService->audio_guide,
                                    'table' => 'tourist_services',
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
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'photography',
                                    'value' => (bool) $touristService->photography,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.hiking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'hiking',
                                    'value' => (bool) $touristService->hiking,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.swimming') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'swimming',
                                    'value' => (bool) $touristService->swimming,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.camping') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'camping',
                                    'value' => (bool) $touristService->camping,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.shopping') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'shopping',
                                    'value' => (bool) $touristService->shopping,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.dining') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'dining',
                                    'value' => (bool) $touristService->dining,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.entertainment') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'entertainment',
                                    'value' => (bool) $touristService->entertainment,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.educational_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'educational_tours',
                                    'value' => (bool) $touristService->educational_tours,
                                    'table' => 'tourist_services',
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
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'translation',
                                    'value' => (bool) $touristService->translation,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.special_events') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'special_events',
                                    'value' => (bool) $touristService->special_events,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.group_bookings') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'group_bookings',
                                    'value' => (bool) $touristService->group_bookings,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.online_booking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'online_booking',
                                    'value' => (bool) $touristService->online_booking,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.mobile_app') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'mobile_app',
                                    'value' => (bool) $touristService->mobile_app,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.virtual_tours') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $touristService->id,
                                    'modelType' => '\\App\\Models\\TouristService',
                                    'field' => 'virtual_tours',
                                    'value' => (bool) $touristService->virtual_tours,
                                    'table' => 'tourist_services',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media & Resources -->
            @if (
                $touristService->main_image ||
                    $touristService->gallery_images ||
                    $touristService->video_url ||
                    $touristService->virtual_tour_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.main_image') }}</label>
                                <div class="mt-2">
                                    @if ($touristService->main_image)
                                        <img src="{{ asset('storage/' . $touristService->main_image) }}" alt="Main Image"
                                            class="max-w-md rounded-lg shadow-md">
                                    @else
                                        <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                    @endif
                                </div>
                            </div>

                            @if ($touristService->video_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.video_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->video_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->video_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            @if ($touristService->virtual_tour_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.virtual_tour_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->virtual_tour_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->virtual_tour_url }}
                                        </a>
                                    </p>
                                </div>
                            @endif

                            <div class="col-span-full">
                                <label class="kt-label">{{ __('main.gallery_images') }}</label>
                                <div class="mt-2 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @if ($touristService->gallery_images && count($touristService->gallery_images) > 0)
                                        @foreach ($touristService->gallery_images as $image)
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
                $touristService->entry_fee_adult ||
                    $touristService->entry_fee_child ||
                    $touristService->entry_fee_student ||
                    $touristService->entry_fee_senior ||
                    $touristService->entry_fee_group)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.entry_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->is_free_entry)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.is_free_entry') }}</label>
                                    <p class="kt-badge kt-badge-success">{{ __('main.yes') }}</p>
                                </div>
                            @endif
                            @if ($touristService->entry_fee_adult)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_adult') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristService->entry_fee_adult, 2) }}
                                        {{ $touristService->currency->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->entry_fee_child)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_child') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristService->entry_fee_child, 2) }}
                                        {{ $touristService->currency->code }}
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->entry_fee_student)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_student') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristService->entry_fee_student, 2) }}
                                        {{ $touristService->currency->code }}</p>
                                </div>
                            @endif
                            @if ($touristService->entry_fee_senior)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_senior') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristService->entry_fee_senior, 2) }}
                                        {{ $touristService->currency->code }}</p>
                                </div>
                            @endif
                            @if ($touristService->entry_fee_group)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.entry_fee_group') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ number_format($touristService->entry_fee_group, 2) }}
                                        {{ $touristService->currency->code }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Operating Hours -->
            @if ($touristService->opening_time || $touristService->closing_time || $touristService->operating_days)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            @if ($touristService->is_24_hours)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.is_24_hours') }}</label>
                                    <p class="kt-badge kt-badge-success">{{ __('main.yes') }}</p>
                                </div>
                            @endif
                            @if ($touristService->opening_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.opening_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->opening_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if ($touristService->closing_time)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.closing_time') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->closing_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if ($touristService->operating_days && count($touristService->operating_days) > 0)
                                <div class="sm:col-span-3">
                                    <label class="kt-label mb-1">{{ __('main.operating_days') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-2">
                                        @foreach ($touristService->operating_days as $day)
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
                $touristService->estimated_visit_duration ||
                    $touristService->difficulty_level ||
                    $touristService->age_restrictions ||
                    $touristService->best_visit_time)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.visitor')]) }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->estimated_visit_duration)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.estimated_visit_duration') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        {{ $touristService->estimated_visit_duration }} {{ __('main.minutes') }}</p>
                                </div>
                            @endif
                            @if ($touristService->difficulty_level)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.difficulty_level') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <span
                                            class="kt-badge kt-badge-info">{{ ucfirst($touristService->difficulty_level) }}</span>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->age_restrictions && count($touristService->age_restrictions) > 0)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.age_restrictions') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-1">
                                        @foreach ($touristService->age_restrictions as $restriction)
                                            <span class="kt-badge kt-badge-warning">{{ $restriction }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if ($touristService->best_visit_time && count($touristService->best_visit_time) > 0)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.best_visit_time') }}</label>
                                    <div class="flex gap-2 flex-wrap mt-1">
                                        @foreach ($touristService->best_visit_time as $time)
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
                $touristService->phone ||
                    $touristService->mobile ||
                    $touristService->email ||
                    $touristService->website_url ||
                    $touristService->facebook_url ||
                    $touristService->instagram_url ||
                    $touristService->twitter_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristService->phone }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristService->mobile }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->mobile }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $touristService->email }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->website_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->website_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            {{ __('main.visit_website') }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->facebook_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.facebook_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->facebook_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Facebook
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->instagram_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.instagram_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->instagram_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Instagram
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->twitter_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.twitter_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->twitter_url }}" target="_blank"
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
                            @if ($touristService->region)
                                <a href="{{ route('regions.show', $touristService->region->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->region->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                            @if ($touristService->subregion)
                                <a href="{{ route('subregions.show', $touristService->subregion->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->subregion->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            @if ($touristService->country)
                                <a href="{{ route('countries.show', $touristService->country->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->country->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.state') }}</label>
                            @if ($touristService->state)
                                <a href="{{ route('states.show', $touristService->state->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->state->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            @if ($touristService->city)
                                <a href="{{ route('cities.show', $touristService->city->id) }}"
                                    class="block text-sm text-primary underline">
                                    {{ $touristService->city->name ?? __('main.na') }}
                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            @else
                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.postal_code') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->postal_code ?? __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.latitude') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->latitude ?? __('main.na') }}
                            </p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.longitude') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->longitude ?? __('main.na') }}
                            </p>
                        </div>
                        <div class="col-span-full">
                            <label class="kt-label mb-1">{{ __('main.address') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $touristService->address ?? __('main.na') !!}
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
                    @if ($touristService->latitude && $touristService->longitude)
                        <div>
                            <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->latitude }}, {{ $touristService->longitude }}
                            </p>
                        </div>
                        <div class="col-span-full mt-4">
                            <label class="kt-label block mb-1">{{ __('main.map') }}</label>
                            <a href="https://maps.google.com?q={{ $touristService->latitude }},{{ $touristService->longitude }}"
                                target="_blank" class="text-sm text-primary hover:underline">
                                {{ __('main.view_on_google_maps') }}
                            </a>
                            <div class="w-full bg-white p-4 rounded-lg shadow-lg">
                                <div id="map" data-title="{{ $touristService->title }}"
                                    data-latitude="{{ $touristService->latitude }}"
                                    data-longitude="{{ $touristService->longitude }}"
                                    class="rounded-md overflow-hidden shadow"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            @if (
                $touristService->phone ||
                    $touristService->mobile ||
                    $touristService->email ||
                    $touristService->website_url ||
                    $touristService->facebook_url ||
                    $touristService->instagram_url ||
                    $touristService->twitter_url)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristService->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristService->phone }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->phone }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->mobile)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="tel:{{ $touristService->mobile }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->mobile }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="mailto:{{ $touristService->email }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $touristService->email }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->website_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.website_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->website_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">{{ __('main.visit_website') }}</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->facebook_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.facebook_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->facebook_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Facebook</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->instagram_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.instagram_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->instagram_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Instagram</a>
                                    </p>
                                </div>
                            @endif
                            @if ($touristService->twitter_url)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.twitter_url') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristService->twitter_url }}" target="_blank"
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
                        @if ($touristService->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($touristService->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristService->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristService->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tourist-services',
                    'id' => $touristService->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'tourist-services',
                    'id' => $touristService->id,
                ])
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
