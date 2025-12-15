@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.tourist_site')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.tourist_site')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.tourist_site')]) }}
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
                    <form method="POST" action="{{ route('tourist-sites.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <!-- Country Photo -->
                        @include('components.input-image', [
                            'column' => 'tourist_site',
                            'columnName' => 'photo',
                        ])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Site Name (Arabic) -->
                            <div class="">
                                <label for="name_ar"
                                    class="kt-label mb-2">{{ __('main.type_name_arabic', ['type' => __('main.tourist_site')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Name (English) -->
                            <div class="">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.type_name_english', ['type' => __('main.tourist_site')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Site Type -->
                            <div class="">
                                <label for="site_type" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.site_type') }}
                                </label>
                                <select name="site_type" id="site_type" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
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
                                <select name="category" id="category" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
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

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])
                        </div>

                        <div class="grid grid-cols-1 gap-2">
                            <!-- Address -->
                            @include('components.elements.input-text-editor', [
                                'column' => 'address',
                                'value' => old('address'),
                            ])

                            @include('components.elements.input-text-editor', [
                                'column' => 'description',
                                'value' => old('description'),
                            ])
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Phone -->
                            <div class="">
                                <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="">
                                <label for="website" class="kt-label required mb-2">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}" required>
                                @error('website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- entry_fee_adult -->
                            <div class="">
                                <label for="entry_fee_adult"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_adult') }}</label>
                                <input type="text" name="entry_fee_adult" id="entry_fee_adult" class="kt-input h-[45px]"
                                    value="{{ old('entry_fee_adult') }}" required>
                                @error('entry_fee_adult')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- entry_fee_child -->
                            <div class="">
                                <label for="entry_fee_child"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_child') }}</label>
                                <input type="text" name="entry_fee_child" id="entry_fee_child" class="kt-input h-[45px]"
                                    value="{{ old('entry_fee_child') }}" required>
                                @error('entry_fee_child')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- entry_fee_student -->
                            <div class="">
                                <label for="entry_fee_student"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_student') }}</label>
                                <input type="text" name="entry_fee_student" id="entry_fee_student"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_student') }}" required>
                                @error('entry_fee_student')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- entry_fee_senior -->
                            <div class="">
                                <label for="entry_fee_senior"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_senior') }}</label>
                                <input type="text" name="entry_fee_senior" id="entry_fee_senior"
                                    class="kt-input h-[45px]" value="{{ old('entry_fee_senior') }}" required>
                                @error('entry_fee_senior')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- entry_fee_group -->
                            <div class="">
                                <label for="entry_fee_group"
                                    class="kt-label required mb-2">{{ __('main.entry_fee_group') }}</label>
                                <input type="text" name="entry_fee_group" id="entry_fee_group" class="kt-input h-[45px]"
                                    value="{{ old('entry_fee_group') }}" required>
                                @error('entry_fee_group')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- is_free_entry -->
                            <div class="">
                                <label for="is_free_entry"
                                    class="kt-label required mb-2">{{ __('main.is_free_entry') }}</label>
                                <input type="text" name="is_free_entry" id="is_free_entry" class="kt-input h-[45px]"
                                    value="{{ old('is_free_entry') }}" required>
                                @error('is_free_entry')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Opening Hours -->
                            <div class="">
                                <label for="opening_hours"
                                    class="kt-label required mb-2">{{ __('main.opening_hours') }}</label>
                                <input type="text" name="opening_hours" id="opening_hours" class="kt-input h-[45px]"
                                    value="{{ old('opening_hours') }}" required>
                                @error('opening_hours')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Best Time to Visit -->
                            <div class="">
                                <label for="best_time" class="kt-label required mb-2">{{ __('main.best_time') }}</label>
                                <input type="time" name="best_time" id="best_time" class="kt-input h-[45px]"
                                    value="{{ old('best_time') }}" required>
                                @error('best_time')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="">
                                <label for="duration" class="kt-label required mb-2">{{ __('main.duration') }}</label>
                                <input type="text" name="duration" id="duration" class="kt-input h-[45px]"
                                    value="{{ old('duration') }}" required>
                                @error('duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

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
                                <label for="status" class="mb-2 kt-label required">Status</label>
                                <select name="status" id="status" class="kt-select h-[45px]" special-search required>
                                    <option value="">--</option>
                                    <option value="active">{{ __('main.active') }}</option>
                                    <option value="inactive">{{ __('main.inactive') }}</option>
                                    <option value="maintenance">{{ __('main.maintenance') }}</option>
                                    <option value="permanently_closed">{{ __('main.permanently_closed') }}</option>
                                    <option value="under_renovation">{{ __('main.under_renovation') }}</option>
                                    <option value="seasonal">{{ __('main.seasonal') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="mb-4">
                            <h3 class="mb-2 font-semibold">{{ __('main.facilities') }}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 mb-4 ps-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'wheelchair_accessible',
                                        'id' => 'wheelchair_accessible',
                                        'value' => '1',
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 mb-4 ps-4">
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 mb-4 ps-4">
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

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => old('notes'),
                        ])

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', ['models' => 'tourist-sites'])
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
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-cascading')
