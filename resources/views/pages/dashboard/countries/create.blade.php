@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.country')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.country')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.country')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.country')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <!-- Country Photo -->
                        @include('components.input-image', ['column' => 'country', 'columnName' => 'flag'])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Country Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div class="">
                                <label for="phone_code" class="kt-label mb-2">{{ __('main.phone_code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input h-[45px]"
                                    maxLength="10" value="{{ old('phone_code') }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label required mb-2">{{ __('main.iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]" maxLength="2"
                                    required value="{{ old('iso2') }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" maxLength="3"
                                    value="{{ old('iso3') }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numeric Code -->
                            <div class="">
                                <label for="numeric_code" class="kt-label mb-2">{{ __('main.numeric_code') }}</label>
                                <input type="number" name="numeric_code" id="numeric_code" class="kt-input h-[45px]"
                                    value="{{ old('numeric_code') }}">
                                @error('numeric_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capital City -->
                            <div class="">
                                <label for="capital" class="kt-label mb-2">{{ __('main.capital') }}</label>
                                <input type="text" name="capital" id="capital" class="kt-input h-[45px]"
                                    value="{{ old('capital') }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- TLD (Top Level Domain) -->
                            <div class="">
                                <label for="tld" class="kt-label mb-2">{{ __('main.tld') }}</label>
                                <input type="text" name="tld" id="tld" class="kt-input h-[45px]" maxLength="10"
                                    value="{{ old('tld') }}" placeholder=".com, .eg, .sa">
                                @error('tld')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Native Name -->
                            <div class="">
                                <label for="native" class="kt-label mb-2">{{ __('main.native') }}</label>
                                <input type="text" name="native" id="native" class="kt-input h-[45px]"
                                    value="{{ old('native') }}">
                                @error('native')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]"
                                    value="{{ old('population') }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">
                                    {{ __('main.location_information', ['type' => __('main.location')]) }}</h3>
                            </div>
                            <div class="kt-card-body p-4 pb-0">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    {{-- Regions [region, subregion, state, city] --}}
                                    @include('components.regions.create', [
                                        'levels' => ['region', 'subregion', 'state', 'city'],
                                        'multiple' => true,
                                    ])

                                    <!-- Timezone -->
                                    <div class="">
                                        <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                        <select name="timezone_id" id="timezone_id" class="kt-select basic-single">
                                            <option value="" selected disabled></option>
                                            @foreach ($timezones as $zone)
                                                <option value="{{ $zone['id'] }}"
                                                    {{ old('timezone_id') == $zone['id'] ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? ($zone['name_ar'] ? $zone['name_ar'] . ' ' : '') : ($zone['name'] ? $zone['name'] . ' ' : '') }}({{ $zone['abbreviation'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('timezone_id')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Currency -->
                                    <div class="">
                                        <label for="currency_id" class="kt-label mb-2 flex items-center justify-between">
                                            {{ __('main.currency') }}
                                            <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                                {{ __('main.add') }}
                                            </a>
                                        </label>
                                        <select name="currency_id" id="currency_id" class="kt-select basic-single">
                                            <option value="" selected disabled></option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                                    {{ $currency->code }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Language -->
                                    <div class="">
                                        <label for="language_id"
                                            class="kt-label required mb-2 flex items-center justify-between">
                                            {{ __('main.language') }}
                                            <a href="{{ route('languages.create') }}" class="text-blue-600 text-2sm">
                                                {{ __('main.add') }}
                                            </a>
                                        </label>
                                        <select name="language_id" id="language_id" class="kt-select basic-single"
                                            required>
                                            <option value="" selected disabled></option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}"
                                                    {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                                    {{ $language->name }}{{ $language->name_ar ? ' - ' . $language->name_ar : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('language_id')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Area (km²) -->
                            <div class="">
                                <label for="area" class="kt-label mb-2">{{ __('main.area') }}</label>
                                <input type="number" step="any" name="area" id="area"
                                    class="kt-input h-[45px]" value="{{ old('area') }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => old('description'),
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => old('notes'),
                        ])

                        <!-- Country Settings -->
                        <div class="flex flex-wrap gap-10 mb-4">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => 1,
                                    'label' => __('main.activate_country'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_independent" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_independent',
                                    'id' => 'is_independent',
                                    'value' => '1',
                                    'label' => __('main.independent_country'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_developed" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_developed',
                                    'id' => 'is_developed',
                                    'value' => '1',
                                    'label' => __('main.developed_country'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_landlocked" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_landlocked',
                                    'id' => 'is_landlocked',
                                    'value' => '1',
                                    'label' => __('main.landlocked_country'),
                                ])
                            </div>
                        </div>

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', ['models' => 'countries'])
                    </form>
                </div>
            </div>

            <!-- Geographic Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.geographic')]) }}</h3>
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
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.iso_codes') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.iso_codes_hint') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.official_currency') }}</div>
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
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });
    </script>
@endpush

@include('components.regions.script-countries-cascading')
