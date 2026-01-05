@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-sites.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Tourist Site Photo -->
                @include('components.input-image', [
                    'column' => 'tourist-site',
                    'columnName' => 'photo',
                ])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        <livewire:regions.location-select-base />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                            ])

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="align-self-end">
                                <label for="postal_code" class="kt-label">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tourist Site Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-site')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label required">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Type -->
                            <div class="">
                                <label for="site_type" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.site_type') }}
                                </label>
                                <select name="site_type" id="site_type" class="kt-select basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($siteTypes as $key => $siteType)
                                        <option value="{{ $key }}"
                                            {{ old('site_type') == $key ? 'selected' : '' }}>
                                            {{ $siteType }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('site_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="">
                                <label for="category" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.category') }}
                                </label>
                                <select name="category" id="category" class="kt-select basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}"
                                            {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media & Resources -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media_resources')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Main Image -->
                            <div class="">
                                <label for="main_image" class="kt-label mb-2">{{ __('main.main_image') }}</label>
                                <input type="file" name="main_image" id="main_image" class="kt-input h-[45px]"
                                    accept="image/*">
                                @error('main_image')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <!-- Preview Main Image -->
                                <div id="main_image_preview" class="mt-3"></div>
                            </div>

                            <!-- Gallery Images -->
                            <div class="">
                                <label for="gallery_images" class="kt-label mb-2">{{ __('main.gallery_images') }}</label>
                                <input type="file" name="gallery_images[]" id="gallery_images"
                                    class="kt-input h-[45px]" accept="image/*" multiple>
                                @error('gallery_images')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <!-- Preview Gallery Images -->
                                <div id="gallery_preview" class="mt-3 grid grid-cols-4 gap-2"></div>
                            </div>

                            <!-- Video URL -->
                            <div class="">
                                <label for="video_url" class="kt-label mb-2">{{ __('main.video_url') }}</label>
                                <input type="url" name="video_url" id="video_url" class="kt-input h-[45px]"
                                    value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                                @error('video_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Virtual Tour URL -->
                            <div class="">
                                <label for="virtual_tour_url"
                                    class="kt-label mb-2">{{ __('main.virtual_tour_url') }}</label>
                                <input type="url" name="virtual_tour_url" id="virtual_tour_url"
                                    class="kt-input h-[45px]" value="{{ old('virtual_tour_url') }}"
                                    placeholder="https://...">
                                @error('virtual_tour_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitor Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.visitor')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <!-- Estimated Visit Duration -->
                            <div class="">
                                <label for="estimated_visit_duration"
                                    class="kt-label mb-2">{{ __('main.estimated_visit_duration') }}
                                    ({{ __('main.minutes') }})</label>
                                <input type="number" name="estimated_visit_duration" id="estimated_visit_duration"
                                    class="kt-input h-[45px]" value="{{ old('estimated_visit_duration') }}"
                                    placeholder="60">
                                @error('estimated_visit_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Difficulty Level -->
                            <div class="">
                                <label for="difficulty_level"
                                    class="kt-label mb-2">{{ __('main.difficulty_level') }}</label>
                                <select name="difficulty_level" id="difficulty_level" class="kt-select basic-single">
                                    <option value="" selected disabled></option>
                                    <option value="easy" {{ old('difficulty_level') == 'easy' ? 'selected' : '' }}>
                                        {{ __('main.easy') }}</option>
                                    <option value="moderate"
                                        {{ old('difficulty_level') == 'moderate' ? 'selected' : '' }}>
                                        {{ __('main.moderate') }}</option>
                                    <option value="challenging"
                                        {{ old('difficulty_level') == 'challenging' ? 'selected' : '' }}>
                                        {{ __('main.challenging') }}</option>
                                    <option value="extreme" {{ old('difficulty_level') == 'extreme' ? 'selected' : '' }}>
                                        {{ __('main.extreme') }}</option>
                                </select>
                                @error('difficulty_level')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Email -->
                            <div class="align-self-end">
                                <label for="email" class="kt-label">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="align-self-end">
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    value="{{ old('mobile') }}">
                                @error('mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Facebook URL -->
                            <div class="">
                                <label for="facebook_url" class="kt-label mb-2">{{ __('main.facebook_url') }}</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="kt-input h-[45px]"
                                    value="{{ old('facebook_url') }}">
                                @error('facebook_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instagram URL -->
                            <div class="">
                                <label for="instagram_url" class="kt-label mb-2">{{ __('main.instagram_url') }}</label>
                                <input type="url" name="instagram_url" id="instagram_url" class="kt-input h-[45px]"
                                    value="{{ old('instagram_url') }}">
                                @error('instagram_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Twitter URL -->
                            <div class="">
                                <label for="twitter_url" class="kt-label mb-2">{{ __('main.twitter_url') }}</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="kt-input h-[45px]"
                                    value="{{ old('twitter_url') }}">
                                @error('twitter_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entry Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.entry')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- entry_fee_adult -->
                            <div class="">
                                <label for="entry_fee_adult"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_adult') }}</label>
                                <input type="number" name="entry_fee_adult" id="entry_fee_adult"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_adult') }}" minLength="1"
                                    required>
                                @error('entry_fee_adult')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_child -->
                            <div class="">
                                <label for="entry_fee_child"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_child') }}</label>
                                <input type="number" name="entry_fee_child" id="entry_fee_child"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_child') }}" minLength="1"
                                    required>
                                @error('entry_fee_child')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_student -->
                            <div class="">
                                <label for="entry_fee_student"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_student') }}</label>
                                <input type="number" name="entry_fee_student" id="entry_fee_student"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_student') }}" minLength="1"
                                    required>
                                @error('entry_fee_student')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_senior -->
                            <div class="">
                                <label for="entry_fee_senior"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_senior') }}</label>
                                <input type="number" name="entry_fee_senior" id="entry_fee_senior"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_senior') }}" minLength="1"
                                    required>
                                @error('entry_fee_senior')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_group -->
                            <div class="">
                                <label for="entry_fee_group"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_group') }}</label>
                                <input type="number" name="entry_fee_group" id="entry_fee_group"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_group') }}" minLength="1"
                                    required>
                                @error('entry_fee_group')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- is_free_entry -->
                            {{-- <div class="">
                                <label for="is_free_entry"
                                    class="kt-label required mb-2">{{ __('main.is_free_entry') }}</label>
                                <input type="checkbox" name="is_free_entry" id="is_free_entry" class="kt-input h-[45px]"
                                    value="{{ old('is_free_entry') }}" minLength="1" required>
                                @error('is_free_entry')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Operating Hours Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.operating_hours')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Operating Days -->
                            <div class="">
                                <label for="operating_days" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.operating_days') }}
                                </label>
                                <select name="operating_days[]" id="operating_days" class="kt-select basic-multiple"
                                    multiple>
                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $key => $day)
                                        <option value="{{ $key }}"
                                            {{ is_array(old('operating_days')) && in_array($key, old('operating_days')) ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('operating_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Opening Time -->
                            <div class="">
                                <label for="opening_time"
                                    class="kt-label required mb-2">{{ __('main.opening_time') }}</label>
                                <input type="time" name="opening_time" id="opening_time" class="kt-input h-[45px]"
                                    value="{{ old('opening_time') }}" required>
                                @error('opening_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Best Time to Visit -->
                            {{-- <div class="">
                                <label for="best_time" class="kt-label required mb-2">{{ __('main.best_time') }}</label>
                                <input type="time" name="best_time" id="best_time" class="kt-input h-[45px]"
                                    value="{{ old('best_time') }}" required>
                                @error('best_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <!-- Duration -->
                            {{-- <div class="">
                                <label for="duration" class="kt-label required mb-2">{{ __('main.duration') }}</label>
                                <input type="text" name="duration" id="duration" class="kt-input h-[45px]"
                                    value="{{ old('duration') }}" required>
                                @error('duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <!-- Recommended Duration -->
                            <div class="">
                                <label for="recommended_duration"
                                    class="kt-label required mb-2">{{ __('main.recommended_duration') }}</label>
                                <input type="text" name="recommended_duration" id="recommended_duration"
                                    class="kt-input h-[45px]" value="{{ old('recommended_duration') }}" required>
                                @error('recommended_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Coordinates -->
                            <div class="">
                                <label for="coordinates"
                                    class="kt-label required mb-2">{{ __('main.coordinates') }}</label>
                                <input type="text" name="coordinates" id="coordinates" class="kt-input h-[45px]"
                                    value="{{ old('coordinates') }}" required>
                                @error('coordinates')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="">
                                <label for="status" class="mb-2 kt-label required">{{ __('main.status') }}</label>
                                <select name="status" id="status" class="kt-select basic-single" required>
                                    <option value="">--</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                        {{ __('main.active') }}</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        {{ __('main.inactive') }}</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                        {{ __('main.maintenance') }}</option>
                                    <option value="permanently_closed"
                                        {{ old('status') == 'permanently_closed' ? 'selected' : '' }}>
                                        {{ __('main.permanently_closed') }}</option>
                                    <option value="under_renovation"
                                        {{ old('status') == 'under_renovation' ? 'selected' : '' }}>
                                        {{ __('main.under_renovation') }}</option>
                                    <option value="seasonal" {{ old('status') == 'seasonal' ? 'selected' : '' }}>
                                        {{ __('main.seasonal') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <h3 class="mb-2 font-semibold">{{ __('main.facilities') }}</h3>
                    <div class="flex flex-wrap ps-4" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="wheelchair_accessible" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'wheelchair_accessible',
                                'id' => 'wheelchair_accessible',
                                'value' => '1',
                                'checked' => 1,
                                'label' => __('main.wheelchair_accessible'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="free_wifi" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'free_wifi',
                                'id' => 'free_wifi',
                                'value' => '1',
                                'label' => __('main.free_wifi'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="parking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'parking',
                                'id' => 'parking',
                                'value' => '1',
                                'label' => __('main.parking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="restrooms" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'restrooms',
                                'id' => 'restrooms',
                                'value' => '1',
                                'label' => __('main.restrooms'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="restaurants" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'restaurants',
                                'id' => 'restaurants',
                                'value' => '1',
                                'label' => __('main.restaurants'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="gift_shop" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'gift_shop',
                                'id' => 'gift_shop',
                                'value' => '1',
                                'label' => __('main.gift_shop'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="guided_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'guided_tours',
                                'id' => 'guided_tours',
                                'value' => '1',
                                'label' => __('main.guided_tours'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="audio_guide" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'audio_guide',
                                'id' => 'audio_guide',
                                'value' => '1',
                                'label' => __('main.audio_guide'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Activities -->
                <div class="mb-4">
                    <h3 class="mb-2 font-semibold">{{ __('main.activities') }}</h3>
                    <div class="flex flex-wrap ps-4" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="photography" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'photography',
                                'id' => 'photography',
                                'value' => '1',
                                'label' => __('main.photography'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="hiking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'hiking',
                                'id' => 'hiking',
                                'value' => '1',
                                'label' => __('main.hiking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="swimming" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'swimming',
                                'id' => 'swimming',
                                'value' => '1',
                                'label' => __('main.swimming'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="camping" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'camping',
                                'id' => 'camping',
                                'value' => '1',
                                'label' => __('main.camping'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="shopping" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'shopping',
                                'id' => 'shopping',
                                'value' => '1',
                                'label' => __('main.shopping'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="dining" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'dining',
                                'id' => 'dining',
                                'value' => '1',
                                'label' => __('main.dining'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="entertainment" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'entertainment',
                                'id' => 'entertainment',
                                'value' => '1',
                                'label' => __('main.entertainment'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="educational_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'educational_tours',
                                'id' => 'educational_tours',
                                'value' => '1',
                                'label' => __('main.educational_tours'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="mb-4">
                    <h3 class="mb-2 font-semibold">{{ __('main.services') }}</h3>
                    <div class="flex flex-wrap ps-4" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="translation" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'translation',
                                'id' => 'translation',
                                'value' => '1',
                                'label' => __('main.translation'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="special_events" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'special_events',
                                'id' => 'special_events',
                                'value' => '1',
                                'label' => __('main.special_events'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="group_bookings" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'group_bookings',
                                'id' => 'group_bookings',
                                'value' => '1',
                                'label' => __('main.group_bookings'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="online_booking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'online_booking',
                                'id' => 'online_booking',
                                'value' => '1',
                                'label' => __('main.online_booking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="mobile_app" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'mobile_app',
                                'id' => 'mobile_app',
                                'value' => '1',
                                'label' => __('main.mobile_app'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="virtual_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'virtual_tours',
                                'id' => 'virtual_tours',
                                'value' => '1',
                                'label' => __('main.virtual_tours'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Address -->
                @include('components.elements.input-text-editor', [
                    'column' => 'address',
                    'value' => old('address'),
                    'classes' => '',
                ])

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => old('description'),
                    'classes' => '',
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => old('notes'),
                    'classes' => '',
                ])

                <div class="flex flex-wrap ps-4" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.is_active'),
                        ])
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_featured" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_featured',
                            'id' => 'is_featured',
                            'value' => '1',
                            'label' => __('main.is_featured'),
                        ])
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_verified" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_verified',
                            'id' => 'is_verified',
                            'value' => '1',
                            'label' => __('main.is_verified'),
                        ])
                    </div>
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', ['models' => 'tourist-sites'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Image Preview for Main Image
        document.getElementById('main_image').addEventListener('change', function(e) {
            const preview = document.getElementById('main_image_preview');
            preview.innerHTML = '';

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.className = 'relative inline-block';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-32 w-32 rounded-lg shadow-md h-auto';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.className =
                        'absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center';
                    removeBtn.onclick = function() {
                        document.getElementById('main_image').value = '';
                        preview.innerHTML = '';
                    };

                    container.appendChild(img);
                    container.appendChild(removeBtn);
                    preview.appendChild(container);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Image Preview for Gallery Images
        const galleryInput = document.getElementById('gallery_images');
        const galleryDataTransfer = new DataTransfer();

        galleryInput.addEventListener('change', function(e) {
            const preview = document.getElementById('gallery_preview');
            preview.innerHTML = '';
            galleryDataTransfer.items.clear();

            if (this.files) {
                Array.from(this.files).forEach((file, index) => {
                    galleryDataTransfer.items.add(file);

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.dataset.index = index;

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'rounded-lg shadow-md w-full h-24 object-cover';

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '×';
                        removeBtn.className =
                            'absolute -top-2 -right-2 z-20 bg-danger text-white cursor-pointer rounded-full w-6 h-6 text-center';
                        removeBtn.onclick = function() {
                            // Remove from DataTransfer
                            const newDataTransfer = new DataTransfer();
                            for (let i = 0; i < galleryDataTransfer.files.length; i++) {
                                if (i !== index) {
                                    newDataTransfer.items.add(galleryDataTransfer.files[i]);
                                }
                            }

                            // Update the input files and preview
                            galleryInput.files = newDataTransfer.files;

                            // Trigger change to refresh preview
                            galleryInput.dispatchEvent(new Event('change'));
                        };

                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });

                galleryInput.files = galleryDataTransfer.files;
            }
        });
    </script>
@endpush
