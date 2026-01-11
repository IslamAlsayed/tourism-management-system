@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist-service')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist-service')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist-service')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-services.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist-services')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('tourist-services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Tourist Site Photo -->
                @include('components.input-image', [
                    'column' => 'tourist-service',
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
                        <!-- region_id, subregion_id, country_id, state_id, city_id -->
                        <livewire:regions.location-select-base />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            @include('components.selects.currency')

                            <!-- latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" min="-90" max="90" name="latitude"
                                    id="latitude" class="kt-input h-[45px]" value="{{ old('latitude') }}">
                            </div>

                            <!-- longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" min="-180" max="180" name="longitude"
                                    id="longitude" class="kt-input h-[45px]" value="{{ old('longitude') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="area" class="kt-label">{{ __('main.area') }}</label>
                                <input type="text" name="area" id="area" class="kt-input h-[45px]"
                                    value="{{ old('area') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="zone" class="kt-label">{{ __('main.zone') }}</label>
                                <input type="text" name="zone" id="zone" class="kt-input h-[45px]"
                                    value="{{ old('zone') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="district" class="kt-label">{{ __('main.district') }}</label>
                                <input type="text" name="district" id="district" class="kt-input h-[45px]"
                                    value="{{ old('district') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="neighborhood" class="kt-label">{{ __('main.neighborhood') }}</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="kt-input h-[45px]"
                                    value="{{ old('neighborhood') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="block" class="kt-label">{{ __('main.block') }}</label>
                                <input type="text" name="block" id="block" class="kt-input h-[45px]"
                                    value="{{ old('block') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="building" class="kt-label">{{ __('main.building') }}</label>
                                <input type="text" name="building" id="building" class="kt-input h-[45px]"
                                    value="{{ old('building') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="floor" class="kt-label">{{ __('main.floor') }}</label>
                                <input type="text" name="floor" id="floor" class="kt-input h-[45px]"
                                    value="{{ old('floor') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="apartment" class="kt-label">{{ __('main.apartment') }}</label>
                                <input type="text" name="apartment" id="apartment" class="kt-input h-[45px]"
                                    value="{{ old('apartment') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="landmark" class="kt-label">{{ __('main.landmark') }}</label>
                                <input type="text" name="landmark" id="landmark" class="kt-input h-[45px]"
                                    value="{{ old('landmark') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="directions" class="kt-label">{{ __('main.directions') }}</label>
                                <input type="text" name="directions" id="directions" class="kt-input h-[45px]"
                                    value="{{ old('directions') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.tourist-service')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }} <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                            </div>

                            <!-- name_ar -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                            </div>

                            <!-- code -->
                            <div>
                                <label for="code" class="kt-label required mb-2">{{ __('main.code') }}</label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10"
                                        value="{{ old('code', fake()->numerify('C-#####')) }}" required readonly>

                                    <button type="button" onclick="window.generateNewCode('code', 'TS-')" toggle-button
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-primary cursor-pointer hover:text-gray-700">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- site_type -->
                            <div class="align-self-end">
                                <label for="site_type" class="kt-label">{{ __('main.site_type') }}</label>
                                <input type="text" name="site_type" id="site_type" class="kt-input h-[45px]"
                                    value="{{ old('site_type') }}">
                            </div>

                            <!-- category -->
                            <div class="align-self-end">
                                <label for="category" class="kt-label">{{ __('main.category') }}</label>
                                <input type="text" name="category" id="category" class="kt-input h-[45px]"
                                    value="{{ old('category') }}">
                            </div>

                            <!-- rating -->
                            <div class="align-self-end">
                                <label for="rating" class="kt-label">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i . ' ' . __('main.stars') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- total_reviews -->
                            <div class="align-self-end">
                                <label for="total_reviews" class="kt-label">{{ __('main.total_reviews') }}</label>
                                <input type="number" name="total_reviews" id="total_reviews" class="kt-input h-[45px]"
                                    value="{{ old('total_reviews') }}">
                            </div>

                            <!-- popularity_score -->
                            <div class="align-self-end">
                                <label for="popularity_score" class="kt-label">{{ __('main.popularity_score') }}</label>
                                <input type="number" name="popularity_score" id="popularity_score"
                                    class="kt-input h-[45px]" value="{{ old('popularity_score') }}">
                            </div>

                            <!-- estimated_visit_duration -->
                            <div class="align-self-end">
                                <label for="estimated_visit_duration"
                                    class="kt-label">{{ __('main.estimated_visit_duration') }}</label>
                                <input type="number" name="estimated_visit_duration" id="estimated_visit_duration"
                                    class="kt-input h-[45px]" value="{{ old('estimated_visit_duration') }}">
                            </div>

                            <!-- difficulty_level -->
                            <div class="align-self-end">
                                <label for="difficulty_level" class="kt-label">{{ __('main.difficulty_level') }}</label>
                                <select name="difficulty_level" id="difficulty_level" class="kt-select basic-single">
                                    @foreach (['easy', 'moderate', 'challenging', 'extreme'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('difficulty_level') == $item ? 'selected' : '' }}>
                                            {{ __('main.' . $item) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- tags -->
                            <div class="align-self-end">
                                <label for="tags" class="kt-label">{{ __('main.tags') }}</label>
                                <select name="tags[]" id="tags" class="kt-input basic-multiple" multiple>
                                    @foreach (['family_friendly', 'adventure', 'cultural', 'historical', 'nature', 'romantic', 'luxury', 'budget', 'eco_friendly', 'accessible'] as $tag)
                                        <option value="{{ $tag }}" {{ old('tags') == $tag ? 'selected' : '' }}>
                                            {{ __('main.' . $tag) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- age_restrictions -->
                            <div class="align-self-end">
                                <label for="age_restrictions" class="kt-label">{{ __('main.age_restrictions') }}</label>
                                <select name="age_restrictions[]" id="age_restrictions" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['all_ages', '3+', '6+', '12+', '16+', '18+', '21+'] as $age)
                                        <option value="{{ $age }}">
                                            {{ $age }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- best_visit_time -->
                            <div class="align-self-end">
                                <label for="best_visit_time" class="kt-label">{{ __('main.best_visit_time') }}</label>
                                <select name="best_visit_time[]" id="best_visit_time" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['spring', 'summer', 'autumn', 'winter', 'morning', 'afternoon', 'evening', 'night'] as $time)
                                        <option value="{{ $time }}">
                                            {{ __('main.' . $time) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media_resources')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            <!-- video_url -->
                            <div>
                                <label for="video_url" class="kt-label">{{ __('main.video_url') }}</label>
                                <input type="url" name="video_url" id="video_url" class="kt-input h-[45px]"
                                    value="{{ old('video_url') }}">
                            </div>

                            <!-- virtual_tour_url -->
                            <div>
                                <label for="virtual_tour_url" class="kt-label">{{ __('main.virtual_tour_url') }}</label>
                                <input type="url" name="virtual_tour_url" id="virtual_tour_url"
                                    class="kt-input h-[45px]" value="{{ old('virtual_tour_url') }}">
                            </div>

                            <!-- main_image -->
                            <div class="col-span-full">
                                <label for="main_image" class="kt-label">{{ __('main.main_image') }}</label>
                                <input type="file" name="main_image" id="main_image" class="kt-input h-[45px]"
                                    accept="image/*">
                                <div class="main_image_preview mt-6" id="main_image_preview"></div>
                            </div>

                            <!-- gallery_images -->
                            <div class="col-span-full">
                                <label for="gallery_images" class="kt-label">{{ __('main.gallery_images') }}</label>
                                <input type="file" name="gallery_images[]" id="gallery_images"
                                    class="kt-input h-[45px]" accept="image/*" multiple>
                                <div class="flex flex-wrap gap-4 mt-6" id="gallery_preview"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket & Pricing Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.ticket_pricing')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- ticket_type -->
                            <div class="align-self-end">
                                <label for="ticket_type" class="kt-label">{{ __('main.ticket_type') }}</label>
                                <input type="text" name="ticket_type" id="ticket_type" class="kt-input h-[45px]"
                                    value="{{ old('ticket_type') }}">
                            </div>

                            <!-- ticket_price -->
                            <div class="align-self-end">
                                <label for="ticket_price" class="kt-label">{{ __('main.ticket_price') }}</label>
                                <input type="number" step="0.01" name="ticket_price" id="ticket_price"
                                    class="kt-input h-[45px]" value="{{ old('ticket_price') }}">
                            </div>

                            <!-- ticket_price_children -->
                            <div class="align-self-end">
                                <label for="ticket_price_children"
                                    class="kt-label">{{ __('main.ticket_price_children') }}</label>
                                <input type="number" step="0.01" name="ticket_price_children"
                                    id="ticket_price_children" class="kt-input h-[45px]"
                                    value="{{ old('ticket_price_children') }}">
                            </div>

                            <!-- ticket_price_students -->
                            <div class="align-self-end">
                                <label for="ticket_price_students"
                                    class="kt-label">{{ __('main.ticket_price_students') }}</label>
                                <input type="number" step="0.01" name="ticket_price_students"
                                    id="ticket_price_students" class="kt-input h-[45px]"
                                    value="{{ old('ticket_price_students') }}">
                            </div>

                            <!-- ticket_price_seniors -->
                            <div class="align-self-end">
                                <label for="ticket_price_seniors"
                                    class="kt-label">{{ __('main.ticket_price_seniors') }}</label>
                                <input type="number" step="0.01" name="ticket_price_seniors"
                                    id="ticket_price_seniors" class="kt-input h-[45px]"
                                    value="{{ old('ticket_price_seniors') }}">
                            </div>

                            <!-- ticket_price_groups -->
                            <div class="align-self-end">
                                <label for="ticket_price_groups"
                                    class="kt-label">{{ __('main.ticket_price_groups') }}</label>
                                <input type="number" step="0.01" name="ticket_price_groups" id="ticket_price_groups"
                                    class="kt-input h-[45px]" value="{{ old('ticket_price_groups') }}">
                            </div>

                            <!-- ticket_options -->
                            <div class="align-self-end">
                                <label for="ticket_options" class="kt-label">{{ __('main.ticket_options') }}</label>
                                <select name="ticket_options[]" id="ticket_options" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['standard', 'vip', 'family', 'group', 'student', 'senior'] as $option)
                                        <option value="{{ $option }}">
                                            {{ __('main.' . $option) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- discounts -->
                            <div class="align-self-end">
                                <label for="discounts" class="kt-label">{{ __('main.discounts') }}</label>
                                <select name="discounts[]" id="discounts" class="kt-input basic-multiple" multiple>
                                    @foreach (['early_booking', 'group_discount', 'student_discount', 'senior_discount', 'seasonal'] as $discount)
                                        <option value="{{ $discount }}">
                                            {{ __('main.' . $discount) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- special_offers -->
                            <div class="align-self-end">
                                <label for="special_offers" class="kt-label">{{ __('main.special_offers') }}</label>
                                <select name="special_offers[]" id="special_offers" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['buy_one_get_one', 'free_guide', 'free_meal', 'free_transport'] as $offer)
                                        <option value="{{ $offer }}">
                                            {{ __('main.' . $offer) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours & Schedule -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.opening_schedule')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- opening_hours -->
                            <div>
                                <label for="opening_hours" class="kt-label">{{ __('main.opening_hours') }}</label>
                                <textarea name="opening_hours" id="opening_hours" rows="3" class="kt-input"
                                    placeholder='{{ __('main.json_format_example') }}: {"monday":"09:00-17:00","tuesday":"09:00-17:00"}'>{{ old('opening_hours') }}</textarea>
                            </div>

                            <!-- holiday_hours -->
                            <div>
                                <label for="holiday_hours" class="kt-label">{{ __('main.holiday_hours') }}</label>
                                <textarea name="holiday_hours" id="holiday_hours" rows="3" class="kt-input"
                                    placeholder='{{ __('main.json_format_example') }}: {"friday":"12:00-17:00"}'>{{ old('holiday_hours') }}</textarea>
                            </div>

                            <!-- closed_dates -->
                            <div>
                                <label for="closed_dates" class="kt-label">{{ __('main.closed_dates') }}</label>
                                <select name="closed_dates[]" id="closed_dates" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_dates') }}</option>
                                </select>
                                <small class="text-gray-500">{{ __('main.closed_dates_help') }}</small>
                            </div>

                            <!-- event_schedules -->
                            <div>
                                <label for="event_schedules" class="kt-label">{{ __('main.event_schedules') }}</label>
                                <select name="event_schedules[]" id="event_schedules" class="kt-input basic-multiple"
                                    multiple>
                                    <option value="">{{ __('main.add_events') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facilities & Features -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.facilities_features')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- facilities -->
                            <div class="align-self-end">
                                <label for="facilities" class="kt-label">{{ __('main.facilities') }}</label>
                                <select name="facilities[]" id="facilities" class="kt-input basic-multiple" multiple>
                                    @foreach (['wifi', 'parking', 'restaurant', 'gift_shop', 'restrooms', 'atm', 'lockers'] as $facility)
                                        <option value="{{ $facility }}">
                                            {{ __('main.' . $facility) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- accessibility_features -->
                            <div class="align-self-end">
                                <label for="accessibility_features"
                                    class="kt-label">{{ __('main.accessibility_features') }}</label>
                                <select name="accessibility_features[]" id="accessibility_features"
                                    class="kt-input basic-multiple" multiple>
                                    @foreach (['wheelchair', 'elevator', 'ramps', 'accessible_restrooms', 'braille'] as $feature)
                                        <option value="{{ $feature }}">
                                            {{ __('main.' . $feature) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- safety_features -->
                            <div class="align-self-end">
                                <label for="safety_features" class="kt-label">{{ __('main.safety_features') }}</label>
                                <select name="safety_features[]" id="safety_features" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['cctv', 'security_guards', 'fire_extinguishers', 'first_aid', 'emergency_exits'] as $safety)
                                        <option value="{{ $safety }}">
                                            {{ __('main.' . $safety) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- health_measures -->
                            <div class="align-self-end">
                                <label for="health_measures" class="kt-label">{{ __('main.health_measures') }}</label>
                                <select name="health_measures[]" id="health_measures" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['sanitizer', 'regular_cleaning', 'temperature_checks', 'medical_assistance'] as $health)
                                        <option value="{{ $health }}">
                                            {{ __('main.' . $health) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- covid_measures -->
                            <div class="align-self-end">
                                <label for="covid_measures" class="kt-label">{{ __('main.covid_measures') }}</label>
                                <select name="covid_measures[]" id="covid_measures" class="kt-input basic-multiple"
                                    multiple>
                                    @foreach (['masks_required', 'social_distancing', 'capacity_limits', 'vaccination_proof'] as $covid)
                                        <option value="{{ $covid }}">
                                            {{ __('main.' . $covid) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services & Activities -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.services_activities')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- services -->
                            <div class="align-self-end">
                                <label for="services" class="kt-label">{{ __('main.services') }}</label>
                                <select name="services[]" id="services" class="kt-input basic-multiple" multiple>
                                    @foreach (['guided_tour', 'audio_guide', 'photography', 'transport', 'catering'] as $service)
                                        <option value="{{ $service }}">
                                            {{ __('main.' . $service) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- activities -->
                            <div class="align-self-end">
                                <label for="activities" class="kt-label">{{ __('main.activities') }}</label>
                                <select name="activities[]" id="activities" class="kt-input basic-multiple" multiple>
                                    @foreach (['hiking', 'photography', 'bird_watching', 'camping', 'swimming'] as $activity)
                                        <option value="{{ $activity }}">
                                            {{ __('main.' . $activity) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- events -->
                            <div class="align-self-end">
                                <label for="events" class="kt-label">{{ __('main.events') }}</label>
                                <select name="events[]" id="events" class="kt-input basic-multiple" multiple>
                                    @foreach (['festivals', 'concerts', 'exhibitions', 'conferences'] as $event)
                                        <option value="{{ $event }}">
                                            {{ __('main.' . $event) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- workshops -->
                            <div class="align-self-end">
                                <label for="workshops" class="kt-label">{{ __('main.workshops') }}</label>
                                <select name="workshops[]" id="workshops" class="kt-input basic-multiple" multiple>
                                    @foreach (['art', 'craft', 'cooking', 'photography', 'music'] as $workshop)
                                        <option value="{{ $workshop }}">
                                            {{ __('main.' . $workshop) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- tours -->
                            <div class="align-self-end">
                                <label for="tours" class="kt-label">{{ __('main.tours') }}</label>
                                <select name="tours[]" id="tours" class="kt-input basic-multiple" multiple>
                                    @foreach (['walking', 'bus', 'boat', 'helicopter', 'bike'] as $tour)
                                        <option value="{{ $tour }}">
                                            {{ __('main.' . $tour) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- programs -->
                            <div class="align-self-end">
                                <label for="programs" class="kt-label">{{ __('main.programs') }}</label>
                                <select name="programs[]" id="programs" class="kt-input basic-multiple" multiple>
                                    @foreach (['educational', 'family', 'school', 'corporate'] as $program)
                                        <option value="{{ $program }}">
                                            {{ __('main.' . $program) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- packages -->
                            <div class="align-self-end">
                                <label for="packages" class="kt-label">{{ __('main.packages') }}</label>
                                <select name="packages[]" id="packages" class="kt-input basic-multiple" multiple>
                                    @foreach (['day_trip', 'weekend', 'full_package', 'custom'] as $package)
                                        <option value="{{ $package }}">
                                            {{ __('main.' . $package) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents & Media Files -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.documents_media')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- media_files -->
                            <div class="align-self-end">
                                <label for="media_files" class="kt-label">{{ __('main.media_files') }}</label>
                                <select name="media_files[]" id="media_files" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_media') }}</option>
                                </select>
                            </div>

                            <!-- documents -->
                            <div class="align-self-end">
                                <label for="documents" class="kt-label">{{ __('main.documents') }}</label>
                                <select name="documents[]" id="documents" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_documents') }}</option>
                                </select>
                            </div>

                            <!-- links -->
                            <div class="align-self-end">
                                <label for="links" class="kt-label">{{ __('main.links') }}</label>
                                <select name="links[]" id="links" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_links') }}</option>
                                </select>
                            </div>

                            <!-- brochures -->
                            <div class="align-self-end">
                                <label for="brochures" class="kt-label">{{ __('main.brochures') }}</label>
                                <select name="brochures[]" id="brochures" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_brochures') }}</option>
                                </select>
                            </div>

                            <!-- menus -->
                            <div class="align-self-end">
                                <label for="menus" class="kt-label">{{ __('main.menus') }}</label>
                                <select name="menus[]" id="menus" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_menus') }}</option>
                                </select>
                            </div>

                            <!-- maps -->
                            {{-- <div class="align-self-end">
                                <label for="maps" class="kt-label">{{ __('main.maps') }}</label>
                                <select name="maps[]" id="maps" class="kt-input basic-multiple" multiple>
                                    <option value="">{{ __('main.add_maps') }}</option>
                                </select>
                            </div> --}}

                            <!-- translations -->
                            <div class="align-self-end">
                                <label for="translations" class="kt-label">{{ __('main.translations') }}</label>
                                <select name="translations[]" id="translations" class="kt-input basic-multiple" multiple>
                                    @foreach (['ar', 'en', 'fr', 'de', 'es', 'it', 'ru', 'zh', 'ja'] as $lang)
                                        <option value="{{ $lang }}">
                                            {{ __('main.lang_' . $lang) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Fields & Extra -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.custom_extra')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- custom_fields -->
                            <div>
                                <label for="custom_fields" class="kt-label">{{ __('main.custom_fields') }}</label>
                                <textarea name="custom_fields" id="custom_fields" rows="3" class="kt-input"
                                    placeholder='{{ __('main.json_format_example') }}: {"field1":"value1","field2":"value2"}'>{{ old('custom_fields') }}</textarea>
                            </div>

                            <!-- extra -->
                            <div>
                                <label for="extra" class="kt-label">{{ __('main.extra') }}</label>
                                <textarea name="extra" id="extra" rows="3" class="kt-input"
                                    placeholder='{{ __('main.json_format_example') }}: {"extra1":"value1"}'>{{ old('extra') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.seo')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- slug -->
                            <div>
                                <label for="slug" class="kt-label">{{ __('main.slug') }}</label>
                                <input type="text" name="slug" id="slug" class="kt-input h-[45px]"
                                    value="{{ old('slug') }}">
                            </div>

                            <!-- meta_title -->
                            <div>
                                <label for="meta_title" class="kt-label">{{ __('main.meta_title') }}</label>
                                <input type="text" name="meta_title" id="meta_title" class="kt-input h-[45px]"
                                    value="{{ old('meta_title') }}">
                            </div>

                            <!-- meta_description -->
                            <div class="col-span-full">
                                <label for="meta_description" class="kt-label">{{ __('main.meta_description') }}</label>
                                <textarea name="meta_description" id="meta_description" rows="3" class="kt-input">{{ old('meta_description') }}</textarea>
                            </div>

                            <!-- meta_keywords -->
                            <div class="col-span-full">
                                <label for="meta_keywords" class="kt-label">{{ __('main.meta_keywords') }}</label>
                                <select name="meta_keywords[]" id="meta_keywords" class="kt-input basic-multiple"
                                    multiple>
                                    <option value="">{{ __('main.add_keywords') }}</option>
                                </select>
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
                            <div class="align-self-end">
                                <label for="contact_person" class="kt-label">{{ __('main.contact_person') }}</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" value="{{ old('contact_person') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="whatsapp" class="kt-label">{{ __('main.whatsapp') }}</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="kt-input h-[45px]"
                                    value="{{ old('whatsapp') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="telegram" class="kt-label">{{ __('main.telegram') }}</label>
                                <input type="text" name="telegram" id="telegram" class="kt-input h-[45px]"
                                    value="{{ old('telegram') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="snapchat" class="kt-label">{{ __('main.snapchat') }}</label>
                                <input type="text" name="snapchat" id="snapchat" class="kt-input h-[45px]"
                                    value="{{ old('snapchat') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="tiktok" class="kt-label">{{ __('main.tiktok') }}</label>
                                <input type="text" name="tiktok" id="tiktok" class="kt-input h-[45px]"
                                    value="{{ old('tiktok') }}">
                            </div>

                            <div class="align-self-end">
                                <label for="youtube" class="kt-label">{{ __('main.youtube') }}</label>
                                <input type="text" name="youtube" id="youtube" class="kt-input h-[45px]"
                                    value="{{ old('youtube') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- address -->
                @include('components.elements.input-text-editor', [
                    'column' => 'address',
                    'value' => old('address'),
                ])

                <!-- description -->
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => old('description'),
                ])

                <!-- notes -->
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    @foreach (['is_active', 'translation', 'special_events', 'group_bookings', 'online_booking', 'mobile_app', 'virtual_tours', 'has_parking', 'has_restaurant', 'has_gift_shop', 'has_restrooms', 'is_featured', 'is_verified'] as $input)
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="{{ $input }}" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => $input,
                                'id' => $input,
                                'value' => '1',
                                'checked' => $input == 'is_active' ? true : false,
                                'label' => __('main.' . $input),
                            ])
                        </div>
                    @endforeach
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
                    'models' => 'tourist-services',
                    'model' => 'tourist-service',
                ])
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
