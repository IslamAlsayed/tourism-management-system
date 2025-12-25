@extends('layouts.master')

@section('title', __('main.type_details', ['type' => __('main.tour_guide_review')]))

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
                <a href="{{ route('tour-guides-reviews.edit', $tourGuideReview->id) }}"
                    class="kt-btn kt-btn-primary md:hidden">
                    <i class="ki-filled ki-pencil text-sm me-2"></i>
                    {{ __('main.edit') }}
                </a>
                <a href="{{ route('tour-guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides_reviews')]) }}
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
                                    {{ $tourGuideReview->rating . '/5' ?: __('main.na') }}
                                    <i class="fas fa-star" style="color: #ffdd00"></i>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.is_active') }}</label>
                            <div class="flex items-center gap-2">
                                @livewire('toggle-switch', [
                                    'modelId' => $tourGuideReview->id,
                                    'modelType' => '\\App\\Models\\TourGuideReview',
                                    'field' => 'is_active',
                                    'value' => (bool) $tourGuideReview->is_active,
                                    'table' => 'tour-guides-reviews',
                                ])
                            </div>
                        </div>
                        @if ($tourGuideReview->review)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.review') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $tourGuideReview->review !!}
                                </div>
                            </div>
                        @endif
                        @if ($tourGuideReview->description)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.description') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $tourGuideReview->description !!}
                                </div>
                            </div>
                        @endif
                        @if ($tourGuideReview->notes)
                            <div class="col-span-full border-custom p-3 pt-0 rounded-[9px]">
                                <label class="kt-label mb-1">{{ __('main.notes') }}</label>
                                <div class="text-sm text-secondary-foreground prose max-w-none">
                                    {!! $tourGuideReview->notes !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.metadata') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                        @if ($tourGuideReview->creator)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.created_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideReview->creator->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.created_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuideReview->created_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        @if ($tourGuideReview->updater)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.updated_by') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $tourGuideReview->updater->name }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="kt-label mb-1">{{ __('main.updated_at') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                {{ $tourGuideReview->updated_at?->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @include('components.elements.edit-button', [
                    'models' => 'tour-guides-reviews',
                    'id' => $tourGuideReview->id,
                ])
                @include('components.elements.delete-form', [
                    'model' => 'tour-guides-reviews',
                    'id' => $tourGuideReview->id,
                ])
                <a href="{{ route('tour-guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour_guides_reviews')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection
