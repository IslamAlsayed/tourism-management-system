@extends('layouts.master')

@section('title', __('main.tour_guide_details'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $tourGuide->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $tourGuide->guide_type?->type }} • {{ $tourGuide->home_city }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides.edit', $tourGuide->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tour-guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides')]) }}
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
                        @if ($tourGuide->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->name_ar)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.name_ar') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->name_ar ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->guideType)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.guide_type') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->guideType->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->currency)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.currency') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->currency->name }}
                                    ({{ $tourGuide->currency->code }})</p>
                            </div>
                        @endif
                        @if ($tourGuide->tourGuideLanguages && $tourGuide->tourGuideLanguages->count() > 0)
                            <div class="col-span-full">
                                <label class="kt-label mb-1">{{ __('main.languages') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($tourGuide->tourGuideLanguages as $tourGuideLanguage)
                                        <span
                                            class="kt-badge kt-badge-info">{{ $tourGuideLanguage->language?->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($tourGuide->license_number)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.license_number') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->license_number }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->experience_years)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.experience_years') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->experience_years }}
                                    {{ __('main.years') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->price)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.price') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($tourGuide->price, 2) }} {{ $tourGuide->currency?->code }}
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $tourGuide->id,
                                    'modelType' => '\\App\\Models\\TourGuide',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuide->is_active,
                                    'table' => 'tourGuides',
                                ])
                            </div>
                        </div>
                    </div>
                    @if ($tourGuide->notes)
                        <div class="mt-6">
                            <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                            <div class="text-sm text-secondary-foreground prose max-w-none">
                                {!! $tourGuide->notes !!}
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
                        @if ($tourGuide->region)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.region') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->region->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->subregion)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.subregion') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->subregion->name }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->country)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.country') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->country?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->state)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.state') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->state?->name ?: __('main.na') }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->city)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.city') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuide->city?->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuide->street)
                            <div class="lg:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.street_address') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->street }}</p>
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
                        @if ($tourGuide->phone)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.phone') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->phone }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->mobile)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.mobile') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->mobile }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->email)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.email') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->email }}</p>
                            </div>
                        @endif
                        @if ($tourGuide->website)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.website') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <a href="{{ $tourGuide->website }}" target="_blank"
                                        class="text-primary hover:underline">
                                        {{ $tourGuide->website }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($tourGuide->photo)
                <!-- Photo -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.photo') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <img src="{{ asset('storage/' . $tourGuide->photo) }}" alt="{{ $tourGuide->name }}"
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
                        @if ($tourGuide->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuide->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($tourGuide->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuide->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuide->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tour-guides',
                    'id' => $tourGuide->id,
                ])
                @livewire('delete-bottom', [
                    'type' => 'tour-guide',
                    'modelId' => $tourGuide->id,
                    'modelType' => '\\App\\Models\\TourGuide',
                    'table' => 'tourGuides',
                ])
                <a href="{{ route('tour-guides.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour-guides')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
