@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.restaurant')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $restaurant->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $restaurant->type?->name }} • {{ $restaurant->city?->name }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('restaurants.edit', $restaurant->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
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
                            <p class="text-sm text-secondary-foreground">{{ $restaurant->name ?: __('main.na') }}</p>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $restaurant->name_ar ?: __('main.na') }}</p>
                        </div>
                        @if ($restaurant->type)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->type->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->stars)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.star_rating') }}</label>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $restaurant->stars)
                                            <i class="ki-filled ki-star text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="ki-outline ki-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm text-secondary-foreground ml-2">{{ $restaurant->stars }}
                                        {{ __('main.stars') }}</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'is_active',
                                    'value' => (bool) $restaurant->is_active,
                                    'table' => 'restaurants',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.wheelchair_accessible') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'wheelchair_accessible',
                                    'value' => (bool) $restaurant->wheelchair_accessible,
                                    'table' => 'wheelchair_accessible',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.free_wifi') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'free_wifi',
                                    'value' => (bool) $restaurant->free_wifi,
                                    'table' => 'free_wifi',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.parking') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'parking',
                                    'value' => (bool) $restaurant->parking,
                                    'table' => 'parking',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.swimming_pool') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'swimming_pool',
                                    'value' => (bool) $restaurant->swimming_pool,
                                    'table' => 'swimming_pool',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.gym') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'gym',
                                    'value' => (bool) $restaurant->gym,
                                    'table' => 'gym',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.indoor') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'indoor',
                                    'value' => (bool) $restaurant->indoor,
                                    'table' => 'indoor',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.outdoor') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'outdoor',
                                    'value' => (bool) $restaurant->outdoor,
                                    'table' => 'outdoor',
                                ])
                            </div>
                        </div>
                        <div>
                            <label class="kt-label mb-1">{{ __('main.spa') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $restaurant->id,
                                    'modelType' => '\\App\\Models\\Restaurant',
                                    'field' => 'spa',
                                    'value' => (bool) $restaurant->spa,
                                    'table' => 'spa',
                                ])
                            </div>
                        </div>
                    </div>
                    @if ($restaurant->description)
                        <div class="mt-6">
                            <label class="kt-label mb-1">{{ __('main.description') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $restaurant->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Location Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($restaurant->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->region->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($restaurant->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $restaurant->country?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($restaurant->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $restaurant->state?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($restaurant->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $restaurant->city?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($restaurant->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->street }}</p>
                            </div>
                        @endif
                        @if ($restaurant->latitude && $restaurant->longitude)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.coordinates') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $restaurant->latitude }}, {{ $restaurant->longitude }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if ($restaurant->phone || $restaurant->email || $restaurant->website)
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @if ($restaurant->phone)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->phone }}</p>
                                </div>
                            @endif
                            @if ($restaurant->email)
                                <div>
                                    <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                    <p class="text-sm text-secondary-foreground">{{ $restaurant->email }}</p>
                                </div>
                            @endif
                            @if ($restaurant->website)
                                <div class="lg:col-span-2">
                                    <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                    <p class="text-sm text-secondary-foreground">
                                        <a href="{{ $restaurant->website }}" target="_blank"
                                            class="text-primary hover:underline">
                                            {{ $restaurant->website }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($restaurant->photo)
                <!-- Photo -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.photo') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <img src="{{ asset('storage/' . $restaurant->photo) }}" alt="{{ $restaurant->name }}"
                            class="max-w-md rounded-lg">
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
                        @if ($restaurant->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $restaurant->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($restaurant->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $restaurant->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $restaurant->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'restaurants',
                    'id' => $restaurant->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'restaurant',
                    'modelId' => $restaurant->id,
                    'modelType' => '\\App\\Models\\Restaurant',
                    'table' => 'restaurants',
                ])
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.restaurants')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
