@extends('layouts.master')

@section('title', __('main.add_type', ['type' => __('main.country')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_type', ['type' => __('main.country')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_type_description', ['type' => __('main.country')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.country_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.update', $country->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Country Photo -->
                        @include('components.input-image', [
                            'columnName' => 'country',
                            'photoUrl' => asset('metronic/media/flags/' . $country->photo . '.svg'),
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Country Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.country_name_arabic') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $country->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.country_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $country->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div class="">
                                <label for="phone_code" class="kt-label mb-2">{{ __('main.phone_code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input h-[45px]"
                                    value="{{ $country->phone_code }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label mb-2">{{ __('main.country_code_iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]" max="2"
                                    value="{{ $country->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.country_code_iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" max="3"
                                    value="{{ $country->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capital City -->
                            <div class="">
                                <label for="capital" class="kt-label mb-2">{{ __('main.capital') }}</label>
                                <input type="text" name="capital" id="capital" class="kt-input h-[45px]"
                                    value="{{ $country->capital }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div class="">
                                <label for="currency_id" class="kt-label mb-2">{{ __('main.currency') }}</label>
                                <select name="currency_id" id="currency_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $country->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Region -->
                            <div class="">
                                <label for="region_id" class="kt-label mb-2">{{ __('main.region') }}</label>
                                <select name="region_id" id="region_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ $country->region_id == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} {{ $region->name_ar ? '- ' . $region->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language -->
                            <div class="">
                                <label for="language_id" class="kt-label mb-2">{{ __('main.language') }}</label>
                                <select name="language_id" id="language_id" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ $country->language_id == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}
                                            {{ $language->name_ar ? '- ' . $language->name_ar : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]"
                                    value="{{ $country->population }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Area (km²) -->
                            <div class="">
                                <label for="area" class="kt-label mb-2">{{ __('main.area') }}</label>
                                <input type="number" step="any" name="area" id="area"
                                    class="kt-input h-[45px]" value="{{ $country->area }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ $country->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ $country->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone" class="kt-label mb-2">{{ __('main.main_timezone') }}</label>
                                <select name="timezone" id="timezone" class="kt-select h-[45px]">
                                    <option value="">--</option>
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
                        <div class="">
                            <label for="description"
                                class="kt-label mb-2">{{ __('main.type_description', ['type' => __('main.country')]) }}</label>
                            <textarea name="description" id="description" rows="4" class="kt-input h-[45px]">{{ $country->description }}</textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country Settings -->
                        <div class="space-y-4 mb-4">
                            <label class="kt-label mb-2">{{ __('main.country_settings') }}</label>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ $country->is_active == 1 ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label">{{ __('main.activate_country') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_independent" value="0">
                                    <input type="checkbox" name="is_independent" id="is_independent" class="kt-checkbox"
                                        value="1" {{ $country->is_independent == 1 ? 'checked' : '' }}>
                                    <label for="is_independent"
                                        class="kt-label">{{ __('main.independent_country') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_developed" value="0">
                                    <input type="checkbox" name="is_developed" id="is_developed" class="kt-checkbox"
                                        value="1" {{ $country->is_developed == 1 ? 'checked' : '' }}>
                                    <label for="is_developed" class="kt-label">{{ __('main.developed_country') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_landlocked" value="0">
                                    <input type="checkbox" name="is_landlocked" id="is_landlocked" class="kt-checkbox"
                                        value="1" {{ $country->is_landlocked == 1 ? 'checked' : '' }}>
                                    <label for="is_landlocked"
                                        class="kt-label">{{ __('main.landlocked_country') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.update_type', ['type' => __('main.country')]) }}
                            </button>
                            <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
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
                                <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.coordinates_hint') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.iso_codes') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.iso_codes_hint') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.official_currency') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.currency_hint') }}</div>
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
        // Flag preview
        document.getElementById('flag').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('flag-preview');
                    const -arget.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-generate ISO codes
        document.getElementById('name').addEventListener('blur', function() {
            const name = this.value.toUpperCase();
            const iso2Field = document.getElementById('iso2');
            const iso3Field = document.getElementById('iso3');

            if (name && !iso2Field.value) {
                // Auto-generate basic codes (you can improve this logic)
                iso2Field.value = name.substring(0, 2);
            }

            if (name && !iso3Field.value) {
                iso3Field.value = name.substring(0, 3);
            }
        });

        // Phone code formatting
        document.getElementById('phone_code').addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');
            if (value && !value.startsWith('+')) {
                this.value = '+' + value;
            }
        });
    </script>
@endpush
