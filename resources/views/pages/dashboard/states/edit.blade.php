@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.state')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.state')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.state')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('states.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_states') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- State Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.state')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('states.update', $state->id) }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid lg:grid-cols-3 gap-4 mb-4">
                            <!-- State Name (Arabic) -->
                            <div class="">
                                <label for="name_ar"
                                    class="kt-label required mb-2">{{ __('main.type_name_arabic', ['type' => __('main.state')]) }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required
                                    value="{{ $state->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Name (English) -->
                            <div class="">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.type_name_english', ['type' => __('main.state')]) }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ $state->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- FIPS Code -->
                            <div class="">
                                <label for="fips_code" class="kt-label mb-2">{{ __('main.fips_code') }}</label>
                                <input type="text" name="fips_code" id="fips_code" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.fips_code_example') }}" value="{{ $state->fips_code }}">
                                @error('fips_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label required mb-2">{{ __('main.code_iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.iso2_example') }}" max="2" required
                                    value="{{ $state->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.code_iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" max="3"
                                    value="{{ $state->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="">
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]"
                                    value="{{ $state->type }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Level -->
                            <div class="">
                                <label for="level" class="kt-label mb-2">{{ __('main.level') }}</label>
                                <input type="text" name="level" id="level" class="kt-input h-[45px]"
                                    value="{{ $state->level }}">
                                @error('level')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" placeholder="{{ __('main.latitude_example') }}"
                                    value="{{ $state->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" placeholder="{{ __('main.longitude_example') }}"
                                    value="{{ $state->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone" id="timezone" class="kt-select h-[45px]">
                                    <option value="">--</option>
                                    @foreach (config('helpers.timezones') as $zone)
                                        <option value="{{ $zone }}"
                                            {{ $state->timezone == $zone ? 'selected' : '' }}>
                                            {{ __('main.maps.' . $zone) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-4 mb-4">
                            <!-- Description -->
                            <div class="">
                                <label for="description"
                                    class="kt-label mb-2">{{ __('main.type_description', ['type' => __('main.state')]) }}</label>
                                <textarea name="description" id="description" rows="4" class="kt-input h-[45px]">{{ $state->description }}</textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- State Settings -->
                        <div class="space-y-4 mb-4">
                            <h4 class="font-semibold mb-1">{{ __('main.type_settings', ['type' => __('main.state')]) }}
                            </h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ $state->is_active == '1' ? 'checked' : '' }}>
                                    <label for="is_active"
                                        class="kt-label mb-0">{{ __('main.activate_type', ['type' => __('main.state')]) }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_independent" value="0">
                                    <input type="checkbox" name="is_independent" id="is_independent" class="kt-checkbox"
                                        value="1" {{ $state->is_independent == '1' ? 'checked' : '' }}>
                                    <label for="is_independent"
                                        class="kt-label mb-0">{{ __('main.independent_type', ['type' => __('main.state')]) }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_developed" value="0">
                                    <input type="checkbox" name="is_developed" id="is_developed" class="kt-checkbox"
                                        value="1" {{ $state->is_developed == '1' ? 'checked' : '' }}>
                                    <label for="is_developed"
                                        class="kt-label mb-0">{{ __('main.developed_type', ['type' => __('main.state')]) }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_landlocked" value="0">
                                    <input type="checkbox" name="is_landlocked" id="is_landlocked" class="kt-checkbox"
                                        value="1" {{ $state->is_landlocked == '1' ? 'checked' : '' }}>
                                    <label for="is_landlocked"
                                        class="kt-label mb-0">{{ __('main.landlocked_type', ['type' => __('main.state')]) }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.update_type', ['type' => __('main.state')]) }}
                            </button>
                            <a href="{{ route('states.index') }}" class="kt-btn kt-btn-outline">
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
                    const placeholder = document.getElementById('flag-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
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
