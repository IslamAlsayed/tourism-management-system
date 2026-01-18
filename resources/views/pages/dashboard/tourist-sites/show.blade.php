@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tourist-site')]))

@push('styles')
    <style>
        .image-container {
            position: relative;
            display: inline-block;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .image-container img {
            display: block;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .image-container:hover .image-overlay {
            opacity: 1;
            visibility: visible;
        }

        .image-overlay a {
            text-decoration: none;
        }
    </style>
@endpush

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
                        <div>
                            <label class="kt-label mb-1">{{ __('main.city') }}</label>
                            <a href="{{ route('cities.show', $touristSite->city?->id) }}"
                                class="block text-sm text-primary underline">
                                {{ $touristSite->city?->name ?? __('main.na') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.sort_order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $touristSite->sort_order ?: __('main.na') }}
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
                        @include('components.elements.display-desc-or-notes', [
                            'record' => $touristSite,
                            'column' => 'description',
                        ])
                        @include('components.elements.display-desc-or-notes', [
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
                    </div>
                </div>
            </div>

            <!-- Nearby Attractions -->
            @if ($touristSite->nearby_attractions)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.nearby_attractions') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="text-sm text-secondary-foreground prose max-w-none">
                            {!! $touristSite->nearby_attractions !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Media Files -->
            @if ($touristSite->media && $touristSite->media->isNotEmpty())
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.media_resources') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="flex flex-col gap-6">
                            @if ($mainImage = $touristSite->media->where('collection_name', 'main_image')->first())
                                <div class="flex flex-col w-fit">
                                    <label class="kt-label mb-2">{{ __('main.main_image') }}</label>
                                    <div class="image-container">
                                        @if ($mainImage->file_path)
                                            <img src="{{ asset('storage/' . $mainImage->file_path) }}" alt="Main Image"
                                                class="h-40 object-cover shadow" loading="lazy">
                                        @else
                                            <div class="h-40 bg-gray-200 flex items-center justify-center">
                                                <p class="text-sm text-secondary-foreground">{{ __('main.na') }}</p>
                                            </div>
                                        @endif
                                        <div class="image-overlay">
                                            <a href="{{ $mainImage->file_path ? asset('storage/' . $mainImage->file_path) : '#' }}"
                                                download="{{ $mainImage->file_name }}"
                                                class="kt-btn kt-btn-sm kt-btn-primary">
                                                <i class="ki-filled ki-download text-sm me-1"></i>
                                                {{ __('main.download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($galleryImages = $touristSite->media->where('collection_name', 'gallery')->all())
                                <div>
                                    <label class="kt-label mb-3">{{ __('main.gallery_images') }}
                                        <span class="text-xs text-secondary-foreground">
                                            ({{ count($galleryImages) }} {{ __('main.images') }})
                                        </span>
                                    </label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                        @foreach ($galleryImages as $index => $image)
                                            <div class="image-container">
                                                @if ($image->file_path)
                                                    <img src="{{ asset('storage/' . $image->file_path) }}"
                                                        alt="Gallery {{ $index + 1 }}" class="w-full h-32 object-cover"
                                                        loading="lazy">
                                                @else
                                                    <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                                        <p class="text-xs text-secondary-foreground">{{ __('main.na') }}
                                                        </p>
                                                    </div>
                                                @endif
                                                <div class="image-overlay">
                                                    <a href="{{ $image->file_path ? asset('storage/' . $image->file_path) : '#' }}"
                                                        download="{{ $image->file_name }}"
                                                        class="kt-btn kt-btn-sm kt-btn-primary">
                                                        <i class="ki-filled ki-download text-sm me-1"></i>
                                                        {{ __('main.download') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Services -->
            @if ($touristSite->services && $touristSite->services->count() > 0)
                @include('pages.dashboard.related-components.services', [
                    'record' => $touristSite,
                    'type' => 'tourist-sites',
                ])
            @endif

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->created_at?->format('Y-m-d H:i') ?? __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $touristSite->updated_at?->format('Y-m-d H:i') ?? __('main.na') }}</p>
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
