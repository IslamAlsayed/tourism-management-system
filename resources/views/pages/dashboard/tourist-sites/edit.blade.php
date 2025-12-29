@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tourist-site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tourist-site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tourist-site')]) }}
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
        <form action="{{ route('tourist-sites.update', $touristSite->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                                'record' => $touristSite,
                            ])

                            {{-- Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'currency_id',
                                'currencies' => $currencies,
                                'record' => $touristSite,
                            ])

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ $touristSite->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ $touristSite->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="align-self-end">
                                <label for="postal_code" class="kt-label">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ $touristSite->postal_code }}">
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
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name_ar }}">
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
                                    @foreach ($siteTypes as $key => $siteType)
                                        <option value="{{ $key }}"
                                            {{ $touristSite->site_type == $key ? 'selected' : '' }}>
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
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $key }}"
                                            {{ $touristSite->category == $key ? 'selected' : '' }}>
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
                                @if ($touristSite->main_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $touristSite->main_image) }}" alt="Main Image"
                                            class="w-32 h-32 object-cover rounded">
                                    </div>
                                @endif
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
                                @if ($touristSite->gallery_images && count($touristSite->gallery_images) > 0)
                                    <div class="mt-2 flex gap-2 flex-wrap">
                                        @foreach ($touristSite->gallery_images as $image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery"
                                                class="w-20 h-20 object-cover rounded">
                                        @endforeach
                                    </div>
                                @endif
                                <!-- Preview Gallery Images -->
                                <div id="gallery_preview" class="mt-3 grid grid-cols-4 gap-2"></div>
                            </div>

                            <!-- Video URL -->
                            <div class="">
                                <label for="video_url" class="kt-label mb-2">{{ __('main.video_url') }}</label>
                                <input type="url" name="video_url" id="video_url" class="kt-input h-[45px]"
                                    value="{{ $touristSite->video_url }}" placeholder="https://youtube.com/...">
                                @error('video_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Virtual Tour URL -->
                            <div class="">
                                <label for="virtual_tour_url"
                                    class="kt-label mb-2">{{ __('main.virtual_tour_url') }}</label>
                                <input type="url" name="virtual_tour_url" id="virtual_tour_url"
                                    class="kt-input h-[45px]" value="{{ $touristSite->virtual_tour_url }}"
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
                                    class="kt-input h-[45px]" value="{{ $touristSite->estimated_visit_duration }}"
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
                                    <option value="easy"
                                        {{ $touristSite->difficulty_level == 'easy' ? 'selected' : '' }}>
                                        {{ __('main.easy') }}</option>
                                    <option value="moderate"
                                        {{ $touristSite->difficulty_level == 'moderate' ? 'selected' : '' }}>
                                        {{ __('main.moderate') }}</option>
                                    <option value="challenging"
                                        {{ $touristSite->difficulty_level == 'challenging' ? 'selected' : '' }}>
                                        {{ __('main.challenging') }}</option>
                                    <option value="extreme"
                                        {{ $touristSite->difficulty_level == 'extreme' ? 'selected' : '' }}>
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
                                    value="{{ $touristSite->email }}">
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ $touristSite->phone }}">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="align-self-end">
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    value="{{ $touristSite->mobile }}">
                                @error('mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ $touristSite->website }}">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Facebook URL -->
                            <div class="">
                                <label for="facebook_url" class="kt-label mb-2">{{ __('main.facebook_url') }}</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="kt-input h-[45px]"
                                    value="{{ $touristSite->facebook_url }}">
                                @error('facebook_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instagram URL -->
                            <div class="">
                                <label for="instagram_url" class="kt-label mb-2">{{ __('main.instagram_url') }}</label>
                                <input type="url" name="instagram_url" id="instagram_url" class="kt-input h-[45px]"
                                    value="{{ $touristSite->instagram_url }}">
                                @error('instagram_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Twitter URL -->
                            <div class="">
                                <label for="twitter_url" class="kt-label mb-2">{{ __('main.twitter_url') }}</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="kt-input h-[45px]"
                                    value="{{ $touristSite->twitter_url }}">
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
                                    class="kt-label mb-2">{{ __('main.entry_fee_adult') }}</label>
                                <input type="text" name="entry_fee_adult" id="entry_fee_adult"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_adult }}">
                                @error('entry_fee_adult')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_child -->
                            <div class="">
                                <label for="entry_fee_child"
                                    class="kt-label mb-2">{{ __('main.entry_fee_child') }}</label>
                                <input type="text" name="entry_fee_child" id="entry_fee_child"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_child }}">
                                @error('entry_fee_child')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_student -->
                            <div class="">
                                <label for="entry_fee_student"
                                    class="kt-label mb-2">{{ __('main.entry_fee_student') }}</label>
                                <input type="text" name="entry_fee_student" id="entry_fee_student"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_student }}">
                                @error('entry_fee_student')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_senior -->
                            <div class="">
                                <label for="entry_fee_senior"
                                    class="kt-label mb-2">{{ __('main.entry_fee_senior') }}</label>
                                <input type="text" name="entry_fee_senior" id="entry_fee_senior"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_senior }}">
                                @error('entry_fee_senior')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_group -->
                            <div class="">
                                <label for="entry_fee_group"
                                    class="kt-label mb-2">{{ __('main.entry_fee_group') }}</label>
                                <input type="text" name="entry_fee_group" id="entry_fee_group"
                                    class="kt-input h-[45px]" value="{{ $touristSite->entry_fee_group }}">
                                @error('entry_fee_group')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- is_free_entry -->
                            <div class="">
                                <label for="is_free_entry" class="kt-label mb-2">{{ __('main.is_free_entry') }}</label>
                                <input type="text" name="is_free_entry" id="is_free_entry" class="kt-input h-[45px]"
                                    value="{{ $touristSite->is_free_entry }}">
                                @error('is_free_entry')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
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
                            <!-- Opening Hours -->
                            <div class="">
                                <label for="opening_hours" class="kt-label mb-2">{{ __('main.opening_hours') }}</label>
                                <input type="text" name="opening_hours" id="opening_hours" class="kt-input h-[45px]"
                                    value="{{ $touristSite->opening_hours }}">
                                @error('opening_hours')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Best Time to Visit -->
                            <div class="">
                                <label for="best_time" class="kt-label mb-2">{{ __('main.best_time') }}</label>
                                <input type="time" name="best_time" id="best_time" class="kt-input h-[45px]"
                                    value="{{ $touristSite->best_time }}">
                                @error('best_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="">
                                <label for="duration" class="kt-label mb-2">{{ __('main.duration') }}</label>
                                <input type="text" name="duration" id="duration" class="kt-input h-[45px]"
                                    value="{{ $touristSite->duration }}">
                                @error('duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Recommended Duration -->
                            <div class="">
                                <label for="recommended_duration"
                                    class="kt-label mb-2">{{ __('main.recommended_duration') }}</label>
                                <input type="text" name="recommended_duration" id="recommended_duration"
                                    class="kt-input h-[45px]" value="{{ $touristSite->recommended_duration }}">
                                @error('recommended_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Coordinates -->
                            <div class="">
                                <label for="coordinates" class="kt-label mb-2">{{ __('main.coordinates') }}</label>
                                <input type="text" name="coordinates" id="coordinates" class="kt-input h-[45px]"
                                    value="{{ $touristSite->coordinates }}">
                                @error('coordinates')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="">
                                <label for="status" class="mb-2 kt-label">{{ __('main.status') }}</label>
                                <select name="status" id="status" class="kt-select basic-single">
                                    <option value="active" {{ $touristSite->status == 'active' ? 'selected' : '' }}>
                                        {{ __('main.active') }}</option>
                                    <option value="inactive" {{ $touristSite->status == 'inactive' ? 'selected' : '' }}>
                                        {{ __('main.inactive') }}</option>
                                    <option value="maintenance"
                                        {{ $touristSite->status == 'maintenance' ? 'selected' : '' }}>
                                        {{ __('main.maintenance') }}</option>
                                    <option value="permanently_closed"
                                        {{ $touristSite->status == 'permanently_closed' ? 'selected' : '' }}>
                                        {{ __('main.permanently_closed') }}</option>
                                    <option value="under_renovation"
                                        {{ $touristSite->status == 'under_renovation' ? 'selected' : '' }}>
                                        {{ __('main.under_renovation') }}</option>
                                    <option value="seasonal" {{ $touristSite->status == 'seasonal' ? 'selected' : '' }}>
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
                                'checked' => $touristSite->wheelchair_accessible,
                                'label' => __('main.wheelchair_accessible'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="free_wifi" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'free_wifi',
                                'id' => 'free_wifi',
                                'value' => '1',
                                'checked' => $touristSite->free_wifi,
                                'label' => __('main.free_wifi'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="parking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'parking',
                                'id' => 'parking',
                                'value' => '1',
                                'checked' => $touristSite->parking,
                                'label' => __('main.parking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="restrooms" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'restrooms',
                                'id' => 'restrooms',
                                'value' => '1',
                                'checked' => $touristSite->restrooms,
                                'label' => __('main.restrooms'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="restaurants" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'restaurants',
                                'id' => 'restaurants',
                                'value' => '1',
                                'checked' => $touristSite->restaurants,
                                'label' => __('main.restaurants'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="gift_shop" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'gift_shop',
                                'id' => 'gift_shop',
                                'value' => '1',
                                'checked' => $touristSite->gift_shop,
                                'label' => __('main.gift_shop'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="guided_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'guided_tours',
                                'id' => 'guided_tours',
                                'value' => '1',
                                'checked' => $touristSite->guided_tours,
                                'label' => __('main.guided_tours'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="audio_guide" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'audio_guide',
                                'id' => 'audio_guide',
                                'value' => '1',
                                'checked' => $touristSite->audio_guide,
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
                                'checked' => $touristSite->photography,
                                'label' => __('main.photography'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="hiking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'hiking',
                                'id' => 'hiking',
                                'value' => '1',
                                'checked' => $touristSite->hiking,
                                'label' => __('main.hiking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="swimming" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'swimming',
                                'id' => 'swimming',
                                'value' => '1',
                                'checked' => $touristSite->swimming,
                                'label' => __('main.swimming'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="camping" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'camping',
                                'id' => 'camping',
                                'value' => '1',
                                'checked' => $touristSite->camping,
                                'label' => __('main.camping'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="shopping" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'shopping',
                                'id' => 'shopping',
                                'value' => '1',
                                'checked' => $touristSite->shopping,
                                'label' => __('main.shopping'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="dining" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'dining',
                                'id' => 'dining',
                                'value' => '1',
                                'checked' => $touristSite->dining,
                                'label' => __('main.dining'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="entertainment" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'entertainment',
                                'id' => 'entertainment',
                                'value' => '1',
                                'checked' => $touristSite->entertainment,
                                'label' => __('main.entertainment'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="educational_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'educational_tours',
                                'id' => 'educational_tours',
                                'value' => '1',
                                'checked' => $touristSite->educational_tours,
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
                                'checked' => $touristSite->translation,
                                'label' => __('main.translation'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="special_events" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'special_events',
                                'id' => 'special_events',
                                'value' => '1',
                                'checked' => $touristSite->special_events,
                                'label' => __('main.special_events'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="group_bookings" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'group_bookings',
                                'id' => 'group_bookings',
                                'value' => '1',
                                'checked' => $touristSite->group_bookings,
                                'label' => __('main.group_bookings'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="online_booking" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'online_booking',
                                'id' => 'online_booking',
                                'value' => '1',
                                'checked' => $touristSite->online_booking,
                                'label' => __('main.online_booking'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="mobile_app" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'mobile_app',
                                'id' => 'mobile_app',
                                'value' => '1',
                                'checked' => $touristSite->mobile_app,
                                'label' => __('main.mobile_app'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="virtual_tours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'virtual_tours',
                                'id' => 'virtual_tours',
                                'value' => '1',
                                'checked' => $touristSite->virtual_tours,
                                'label' => __('main.virtual_tours'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Address -->
                @include('components.elements.input-text-editor', [
                    'column' => 'address',
                    'value' => $touristSite->address,
                    'classes' => '',
                ])

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => $touristSite->description,
                    'classes' => '',
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $touristSite->notes,
                    'classes' => '',
                ])

                <div class="flex flex-wrap ps-4" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $touristSite->is_active,
                            'label' => __('main.is_active'),
                        ])
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_featured" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_featured',
                            'id' => 'is_featured',
                            'value' => '1',
                            'checked' => $touristSite->is_featured,
                            'label' => __('main.is_featured'),
                        ])
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_verified" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_verified',
                            'id' => 'is_verified',
                            'value' => '1',
                            'checked' => $touristSite->is_verified,
                            'label' => __('main.is_verified'),
                        ])
                    </div>
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', ['models' => 'tourist-sites'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id", "edit");
                filterByForeignId("subregion_id", "country", "country_id", "edit");
                filterByForeignId("country_id", "state", "state_id", "edit");
                filterByForeignId("state_id", "city", "city_id", "edit");
            }, 500);
        });

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
                    img.className = 'rounded-lg shadow-md max-w-xs h-auto';

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

@include('components.regions.script-cascading')
