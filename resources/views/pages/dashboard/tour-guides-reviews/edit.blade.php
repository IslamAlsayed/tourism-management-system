@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tour-guide-review')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tour-guide-review')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tour-guide-review')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour-guide-reviews')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tour Guides Reviews Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide-review')]) }}
                    </h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tour-guides-reviews.update', $tourGuideReview->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-3 gap-6 mb-4">
                            <!-- Tour Guide -->
                            <div class="">
                                <label for="tour_guide_id" class="kt-label mb-2">{{ __('main.tour_guide') }}</label>
                                <select name="tour_guide_id" id="tour_guide_id" class="kt-select h-[45px]" special-search
                                    value="{{ $tourGuideReview->currency_id }}">
                                    <option value="">--</option>
                                    @foreach ($tourGuides as $tourGuide)
                                        <option value="{{ $tourGuide->id }}"
                                            {{ $tourGuideReview->tour_guide_id == $tourGuide->id ? 'selected' : '' }}>
                                            {{ $tourGuide->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tour_guide_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Review -->
                        <div class="mb-4">
                            <label for="review" class="kt-label mb-2">{{ __('main.review') }}</label>
                            <input id="review" type="hidden" name="review" value="{{ $tourGuideReview->review }}">
                            <trix-editor input="review"></trix-editor>
                            @error('review')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="space-y-6 mb-4">
                            <!-- Rating -->
                            <div class="">
                                <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                                <div class="flex flex-col">
                                    <div class="inline-flex flex-wrap items-center gap-6">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <div class="custom-input">
                                                <input type="radio" name="rating" class="mb-0 rating"
                                                    id="{{ $star }}" value="{{ $star }}"
                                                    {{ $tourGuideReview->rating == $star ? 'checked' : '' }}>

                                                <label for="{{ $star }}">
                                                    {{ $star }}

                                                    @for ($i = 0; $i < $star; $i++)
                                                        <i class="fas fa-star" style="color: #ffdd00"></i>
                                                    @endfor
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', ['models' => 'tour-guide-reviews'])
                    </form>
                </div>
            </div>

            <!-- Geographic Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.geographic_info') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.coordinates_hint') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.gender')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.gender'), 'type2' => __('main.tour-guide-review')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.country')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.country'), 'type2' => __('main.tour-guide-review')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.currency')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.currency'), 'type2' => __('main.tour-guide-review')]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
