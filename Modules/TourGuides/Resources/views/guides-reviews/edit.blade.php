@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tours.guide-review')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tours.guide-review')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tours.guide-review')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.tourguides.guides-reviews.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.reviews')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.tourguides.guides-reviews.update', $tourGuideReview->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Tour Guide -->
                            <div class="">
                                <label for="tour_guide_id" class="kt-label required mb-2 flex items-center justify-between">
                                    {{ __('main.tours.guide') }}
                                    <a href="{{ route('dashboard.tourguides.guides.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="tour_guide_id" id="tour_guide_id" class="kt-select basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($tourGuides as $tourGuide)
                                        <option value="{{ $tourGuide->id }}" {{ $tourGuideReview->tour_guide_id == $tourGuide->id ? 'selected' : '' }}>
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
                        @include('components.elements.input-text-editor', [
                            'column' => 'review',
                            'value' => $tourGuideReview->review,
                        ])

                        <!-- Rating -->
                        <div class="">
                            <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                            <div class="flex flex-col">
                                <div class="inline-flex flex-wrap items-center gap-6">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <div class="custom-input">
                                            <input type="radio" name="rating" class="mb-0 rating" id="{{ $star }}" value="{{ $star }}"
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

                        <!-- Update Submit -->
                        @include('components.elements.update-submit', [
                            'models' => 'dashboard.tourguides.guides-reviews',
                            'model' => 'review',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
