@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tours.guide-review')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $tourGuideReview->tour_guide->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $tourGuideReview->rating }}/5
                    <i class="fas fa-star" style="color: #ffdd00"></i>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.guides-reviews.edit', $tourGuideReview->id) }}" class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('dashboard.tourguides.guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides-reviews')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">

            <!-- Review Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.review')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @if ($tourGuideReview->tour_guide->name)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.tour_guide_name') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ $tourGuideReview->tour_guide->name ?: __('main.na') }}
                                </p>
                            </div>
                        @endif
                        @if ($tourGuideReview->rating)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.rating') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    {{ number_format($tourGuideReview->rating, 0) ?: '0' }}/5
                                    <i class="fas fa-star" style="color: #ffdd00"></i>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $tourGuideReview->id,
                                    'modelType' => '\\Modules\\TourGuides\\Entities\\TourGuideReview',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuideReview->is_active,
                                    'table' => 'tours.guides-reviews',
                                ])
                            </div>
                        </div>
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuideReview,
                            'column' => 'review',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuideReview,
                            'column' => 'description',
                        ])
                        @include('components.elements.displayable-rich-text', [
                            'record' => $tourGuideReview,
                            'column' => 'notes',
                        ])
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            @include('components.metadata', ['record' => $tourGuideReview])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'dashboard.tourguides.guides-reviews',
                    'id' => $tourGuideReview->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'dashboard.tourguides.guides-reviews',
                    'id' => $tourGuideReview->id,
                ])
                <a href="{{ route('dashboard.tourguides.guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tours.guides-reviews')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
