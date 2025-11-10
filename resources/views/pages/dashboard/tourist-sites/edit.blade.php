@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tourist_site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tourist_site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tourist_site')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tourist-sites.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tourist_sites')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tourist Site Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tourist_site')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tourist-sites.update', $touristSite->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Country Photo -->
                        @include('components.input-image', [
                            'column' => 'tourist_site',
                            'columnName' => 'photo',
                            'photoUrl' => $touristSite->photo ? asset('storage/' . $touristSite->photo) : '',
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Site Name (Arabic) -->
                            <div class="">
                                <label for="name_ar"
                                    class="kt-label mb-2">{{ __('main.type_name_arabic', ['type' => __('main.tourist_site')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Name (English) -->
                            <div class="">
                                <label for="name"
                                    class="kt-label mb-2">{{ __('main.type_name_english', ['type' => __('main.tourist_site')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $touristSite->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Type -->
                            <div class="">
                                <label for="site_type" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.site_type') }}
                                </label>
                                <select name="site_type" id="site_type" class="kt-select h-[45px]" special-search
                                    data-current-value="{{ $touristSite->site_type }}"
                                    value="{{ $touristSite->site_type }}">
                                    <option value="">--</option>
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
                                <select name="category" id="category" class="kt-select h-[45px]" special-search
                                    data-current-value="{{ $touristSite->category }}"
                                    value="{{ $touristSite->category }}">
                                    <option value="">--</option>
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

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                                'record' => $touristSite,
                            ])
                        </div>

                        <div class="grid grid-cols-1 gap-2">
                            <!-- Address -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'address',
                                'value' => $touristSite->address,
                            ])

                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => $touristSite->description,
                            ])
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Phone -->
                            <div class="">
                                <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ $touristSite->phone }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ $touristSite->email }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="">
                                <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ $touristSite->website }}">
                                @error('website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Entrance Fee -->
                            <div class="">
                                <label for="entrance_fee" class="kt-label mb-2">{{ __('main.entrance_fee') }}</label>
                                <input type="text" name="entrance_fee" id="entrance_fee" class="kt-input h-[45px]"
                                    value="{{ $touristSite->entrance_fee }}">
                                @error('entrance_fee')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

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
                                <select name="status" id="status" class="kt-select h-[45px]" special-search
                                    data-current-value="{{ $touristSite->status }}" value="{{ $touristSite->status }}">
                                    <option value="">--</option>
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

                        <!-- Facilities -->
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.facilities') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[wheelchair_accessible]"
                                        id="wheelchair_accessible" class="kt-checkbox" value="wheelchair_accessible"
                                        {{ in_array('wheelchair_accessible', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="wheelchair_accessible"
                                        class="kt-label mb-0">{{ __('main.wheelchair_accessible') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[free_wifi]" id="free_wifi"
                                        class="kt-checkbox" value="free_wifi"
                                        {{ in_array('free_wifi', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="free_wifi" class="kt-label mb-0">{{ __('main.free_wifi') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[parking]" id="parking" class="kt-checkbox"
                                        value="parking"
                                        {{ in_array('parking', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="parking" class="kt-label mb-0">{{ __('main.parking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[restrooms]" id="restrooms"
                                        class="kt-checkbox" value="restrooms"
                                        {{ in_array('restrooms', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="restrooms" class="kt-label mb-0">{{ __('main.restrooms') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[restaurants]" id="restaurants"
                                        class="kt-checkbox" value="restaurants"
                                        {{ in_array('restaurants', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="restaurants" class="kt-label mb-0">{{ __('main.restaurants') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[gift_shop]" id="gift_shop"
                                        class="kt-checkbox" value="gift_shop"
                                        {{ in_array('gift_shop', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="gift_shop" class="kt-label mb-0">{{ __('main.gift_shop') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[guided_tours]" id="guided_tours"
                                        class="kt-checkbox" value="guided_tours"
                                        {{ in_array('guided_tours', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="guided_tours" class="kt-label mb-0">{{ __('main.guided_tours') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="facilities[audio_guide]" id="audio_guide"
                                        class="kt-checkbox" value="audio_guide"
                                        {{ in_array('audio_guide', $touristSite->facilities) ? 'checked' : '' }}>
                                    <label for="audio_guide" class="kt-label mb-0">{{ __('main.audio_guide') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.activities') }}</h4>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[photography]" id="photography"
                                        class="kt-checkbox" value="photography"
                                        {{ in_array('photography', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="photography" class="kt-label mb-0">{{ __('main.photography') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[hiking]" id="hiking" class="kt-checkbox"
                                        value="hiking"
                                        {{ in_array('hiking', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="hiking" class="kt-label mb-0">{{ __('main.hiking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[swimming]" id="swimming"
                                        class="kt-checkbox" value="swimming"
                                        {{ in_array('swimming', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="swimming" class="kt-label mb-0">{{ __('main.swimming') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[camping]" id="camping" class="kt-checkbox"
                                        value="camping"
                                        {{ in_array('camping', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="camping" class="kt-label mb-0">{{ __('main.camping') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[shopping]" id="shopping"
                                        class="kt-checkbox" value="shopping"
                                        {{ in_array('shopping', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="shopping" class="kt-label mb-0">{{ __('main.shopping') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[dining]" id="dining" class="kt-checkbox"
                                        value="dining"
                                        {{ in_array('dining', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="dining" class="kt-label mb-0">{{ __('main.dining') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[entertainment]" id="entertainment"
                                        class="kt-checkbox" value="entertainment"
                                        {{ in_array('entertainment', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="entertainment"
                                        class="kt-label mb-0">{{ __('main.entertainment') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="activities[educational_tours]" id="educational_tours"
                                        class="kt-checkbox" value="educational_tours"
                                        {{ in_array('educational_tours', $touristSite->activities) ? 'checked' : '' }}>
                                    <label for="educational_tours"
                                        class="kt-label mb-0">{{ __('main.educational_tours') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="mb-4">
                            <h4 class="mb-2 font-semibold">{{ __('main.services') }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[translation]" id="translation"
                                        class="kt-checkbox" value="translation"
                                        {{ in_array('translation', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="translation" class="kt-label mb-0">{{ __('main.translation') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[special_events]" id="special_events"
                                        class="kt-checkbox" value="special_events"
                                        {{ in_array('special_events', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="special_events"
                                        class="kt-label mb-0">{{ __('main.special_events') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[group_bookings]" id="group_bookings"
                                        class="kt-checkbox" value="group_bookings"
                                        {{ in_array('group_bookings', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="group_bookings"
                                        class="kt-label mb-0">{{ __('main.group_bookings') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[online_booking]" id="online_booking"
                                        class="kt-checkbox" value="online_booking"
                                        {{ in_array('online_booking', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="online_booking"
                                        class="kt-label mb-0">{{ __('main.online_booking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[mobile_app]" id="mobile_app"
                                        class="kt-checkbox" value="mobile_app"
                                        {{ in_array('mobile_app', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="mobile_app" class="kt-label mb-0">{{ __('main.mobile_app') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="" value="0">
                                    <input type="checkbox" name="services[virtual_tours]" id="virtual_tours"
                                        class="kt-checkbox" value="virtual_tours"
                                        {{ in_array('virtual_tours', $touristSite->services) ? 'checked' : '' }}>
                                    <label for="virtual_tours"
                                        class="kt-label mb-0">{{ __('main.virtual_tours') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => $touristSite->notes,
                        ])

                        <!-- Save Submit Buttons -->
                        @include('components.elements.update-submit', ['models' => 'tourist-sites'])
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.tourist_site_tips') }}</h3>
                </div>
                <div class="p-2 kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-success-light">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.detailed_information') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.detailed_information_description') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-success-light">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.high_quality_photos') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.high_quality_photos_description') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-full bg-primary-light">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.visitor_experience') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.visitor_experience_description') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </script>
@endpush

@include('components.regions.script-cascading')
