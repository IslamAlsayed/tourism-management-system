@extends('layouts.master')

@section('title', __('main.tourist_site_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $touristSite->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $touristSite->city?->name }}, {{ $touristSite->country?->name }}
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

            <!-- Basic Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->site_type }}</p>
                            </div>
                        @endif
                        @if ($touristSite->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->category }}</p>
                            </div>
                        @endif
                        @if ($touristSite->difficulty_level)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.difficulty_level') }}</label><br />
                                <p class="kt-badge kt-badge-info">{{ $touristSite->difficulty_level }}</p>
                            </div>
                        @endif
                        @if ($touristSite->tags)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.tags') }}</label><br />
                                @foreach ($touristSite->tags as $tag)
                                    <span class="kt-badge kt-badge-info">{{ ucfirst($tag) }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if ($touristSite->duration)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.duration') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->duration }}
                                    {{ __('main.minutes') }}</p>
                            </div>
                        @endif
                        @if ($touristSite->entrance_fee)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.entrance_fee') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($touristSite->entrance_fee, 2) }}</p>
                            </div>
                        @endif
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
                    </div>
                    @if ($touristSite->description)
                        <div class="mt-6">
                            <label class="kt-label mb-1">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $touristSite->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- facilities -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.facilities') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.country') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->country?->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->city?->name ?: __('main.na') }}
                            </p>
                        </div>
                        @if ($touristSite->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->region->name }}</p>
                            </div>
                        @endif
                        @if ($touristSite->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($touristSite->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $touristSite->street }}</p>
                            </div>
                        @endif
                        @if ($touristSite->latitude && $touristSite->longitude)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $touristSite->latitude }}, {{ $touristSite->longitude }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if ($touristSite->phone || $touristSite->email || $touristSite->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($touristSite->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $touristSite->phone }}</p>
                                </div>
                            @endif
                            @if ($touristSite->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $touristSite->email }}</p>
                                </div>
                            @endif
                            @if ($touristSite->website)
                                <div class="lg:col-span-2">
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $touristSite->website }}" target="_blank"
                                            class="text-primary hover:underline">
                                            {{ $touristSite->website }}
                                        </a>
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
                @livewire('delete-bottom', [
                    'type' => 'tourist_site',
                    'modelId' => $touristSite->id,
                    'modelType' => '\\App\\Models\\TouristSite',
                    'table' => 'tourist_sites',
                ])
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
