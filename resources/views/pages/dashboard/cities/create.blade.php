@extends('layouts.master')

@section('title', __('main.add_new_city'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_new_city') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_city_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_cities') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- City Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.city_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('cities.store') }}" class="space-y-6 p-4">
                        @csrf

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- City Name (Arabic) -->
                            <div class="mb-4">
                                <label for="name_ar"
                                    class="kt-label required mb-2">{{ __('main.city_name_arabic') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.enter_city_name_arabic') }}" required>
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City Name (English) -->
                            <div class="mb-4">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.city_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.enter_city_name_english') }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between">
                                    <label for="country_id" class="kt-label required mb-2">{{ __('main.country') }}</label>
                                    <a href="{{ route('countries.create') }}"
                                        class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
                                </div>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]" required>
                                    <option value="">{{ __('main.select_country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name_ar }} -
                                            {{ $country->name_en }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- State -->
                            <div class="mb-4">
                                <label for="state_id" class="kt-label mb-2">{{ __('main.state') }}</label>
                                <select name="state_id" id="state_id" class="kt-select h-[45px]">
                                    <option value="">{{ __('main.select_state') }}</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name_ar }} - {{ $state->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="mb-4">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" placeholder="{{ __('main.latitude_example') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="mb-4">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" placeholder="{{ __('main.longitude_example') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Population -->
                            <div class="mb-4">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.population_example') }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="mb-3">
                                <label for="timezone" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone" id="timezone" class="kt-select h-[45px]">
                                    <option value="">{{ __('main.select_timezone') }}</option>
                                    @foreach (config('helpers.timezones') as $zone)
                                        <option value="{{ $zone }}"
                                            {{ old('timezone') == $zone ? 'selected' : '' }}>
                                            {{ __('main.maps.' . $zone) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="kt-label mb-2">{{ __('main.city_description') }}</label>
                            <textarea name="description" id="description" rows="4" class="kt-input h-[45px]"
                                placeholder="{{ __('main.additional_city_info') }}"></textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                    value="1" checked>
                                <label for="is_active" class="kt-label mb-0">{{ __('main.activate_city') }}</label>
                            </div>
                            <div class="text-sm text-secondary-foreground mt-1">
                                {{ __('main.active_cities_will_appear') }}
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_city') }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') }}
                            </button>
                            <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Quick Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.verify_city_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.use_map_services') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.country_selection') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.must_select_country') }}</div>
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
        // Auto-generate English name from Arabic
        document.getElementById('name_ar').addEventListener('input', function() {
            const arabicName = this.value;
            // You can add transliteration logic here if needed
        });

        // Country change handler
        document.getElementById('country_id').addEventListener('change', function() {
            const countryId = this.value;
            if (countryId) {
                // You can load timezone and other country-specific data here
            }
        });
    </script>
@endpush
