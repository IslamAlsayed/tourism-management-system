@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.country')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.country')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.country')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.geography.countries.update', $country->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-4 lg:gap-6">
                <!-- Country Photo -->
                @include('components.input-image', [
                    'modelKey' => $country->name ?? 'C',
                    'column' => 'country',
                    'columnName' => 'photo',
                    'record' => $country,
                ])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [region, subregion, state, city] --}}
                        @livewire('geography::livewire.regions.location-to-country', ['record' => $country, 'multiple' => ['states', 'cities']])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="0.00000001" name="latitude" id="latitude" class="kt-input h-[45px]" value="{{ $country->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="0.00000001" name="longitude" id="longitude" class="kt-input h-[45px]"
                                    value="{{ $country->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capital City -->
                            <div class="">
                                <label for="capital" class="kt-label mb-2">{{ __('main.capital') }}</label>
                                <input type="text" name="capital" id="capital" class="kt-input h-[45px]" value="{{ $country->capital }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Timezone --}}
                            @include('components.selects.timezone', ['record' => $country])

                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $country])

                            {{-- Language --}}
                            @include('components.selects.language', [
                                'name' => 'language_id',
                                'languages' => $languages,
                                'record' => $country,
                            ])
                        </div>
                    </div>
                </div>

                <!-- Country Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.country')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Country Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $country->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $country->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div class="">
                                <label for="phone_code" class="kt-label mb-2">{{ __('main.phone_code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input h-[45px]" maxLength="10"
                                    value="{{ $country->phone_code }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label mb-2">{{ __('main.iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]" maxLength="2" value="{{ $country->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" maxLength="3" value="{{ $country->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numeric Code -->
                            <div class="">
                                <label for="numeric_code" class="kt-label mb-2">{{ __('main.numeric_code') }}</label>
                                <input type="number" name="numeric_code" id="numeric_code" class="kt-input h-[45px]" value="{{ $country->numeric_code }}">
                                @error('numeric_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- TLD (Top Level Domain) -->
                            <div class="">
                                <label for="tld" class="kt-label mb-2">{{ __('main.tld') }}</label>
                                <input type="text" name="tld" id="tld" class="kt-input h-[45px]" maxLength="10" value="{{ $country->tld }}"
                                    placeholder=".com, .eg, .sa">
                                @error('tld')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Native Name -->
                            <div class="">
                                <label for="native" class="kt-label mb-2">{{ __('main.native') }}</label>
                                <input type="text" name="native" id="native" class="kt-input h-[45px]" value="{{ $country->native }}">
                                @error('native')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]" value="{{ $country->population }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Area (km²) -->
                            <div class="">
                                <label for="area" class="kt-label mb-2">{{ __('main.area') }}</label>
                                <input type="number" step="any" name="area" id="area" class="kt-input h-[45px]" value="{{ $country->area }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $country->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $country->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $country->is_active,
                            'label' => __('main.is_active'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_independent" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_independent',
                            'id' => 'is_independent',
                            'value' => '1',
                            'checked' => $country->is_independent,
                            'label' => __('main.is_independent'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_developed" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_developed',
                            'id' => 'is_developed',
                            'value' => '1',
                            'checked' => $country->is_developed,
                            'label' => __('main.is_developed'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_landlocked" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_landlocked',
                            'id' => 'is_landlocked',
                            'value' => '1',
                            'checked' => $country->is_landlocked,
                            'label' => __('main.is_landlocked'),
                        ])
                    </div>
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', ['models' => 'dashboard.geography.countries', 'model' => 'country'])
            </div>
        </form>
    </div>
@endsection
