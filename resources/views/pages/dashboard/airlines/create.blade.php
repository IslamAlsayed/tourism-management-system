@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.airline')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.airline')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.airline')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('airlines.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.airlines')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\Region::count() > 0,
                    'route' => route('regions.index'),
                    'label' => __('main.regions'),
                ],
                [
                    'condition' => \App\Models\Subregion::count() > 0,
                    'route' => route('subregions.index'),
                    'label' => __('main.subregions'),
                ],
                [
                    'condition' => \App\Models\Country::count() > 0,
                    'route' => route('countries.index'),
                    'label' => __('main.countries'),
                ],
                [
                    'condition' => \App\Models\State::count() > 0,
                    'route' => route('states.index'),
                    'label' => __('main.states'),
                ],
                [
                    'condition' => \App\Models\City::count() > 0,
                    'route' => route('cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('airlines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                {{-- Airline Photo --}}
                @include('components.input-image', [
                    'column' => 'airline',
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
                            {{-- Timezone --}}
                            @include('components.selects.timezone')

                            {{-- Elevation --}}
                            <div>
                                <label for="elevation" class="kt-label mb-2">{{ __('main.elevation') }}</label>
                                <input type="number" name="elevation" id="elevation" class="kt-input h-[45px]"
                                    value="{{ old('elevation') }}" step="0.01" placeholder="meters">
                                @error('elevation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Latitude --}}
                            <div>
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]"
                                    value="{{ old('latitude') }}" step="any" min="-90" max="90"
                                    placeholder="24.9576">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Longitude --}}
                            <div>
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]"
                                    value="{{ old('longitude') }}" step="any" min="-180" max="180"
                                    placeholder="46.6988">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Airline Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.airline')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end mb-4">
                            {{-- Airline IATA Code --}}
                            <div>
                                <label for="iata_code" class="kt-label mb-2">IATA Code</label>
                                <input type="text" name="iata_code" id="iata_code" maxlength="3"
                                    class="kt-input h-[45px]" value="{{ old('iata_code') }}" placeholder="e.g., SV">
                                @error('iata_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline ICAO Code --}}
                            <div>
                                <label for="icao_code" class="kt-label mb-2">ICAO Code</label>
                                <input type="text" name="icao_code" id="icao_code" maxlength="4"
                                    class="kt-input h-[45px]" value="{{ old('icao_code') }}" placeholder="e.g., SVA">
                                @error('icao_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Parent Airline ICAO Code --}}
                            <div>
                                <label for="parent_airline_icao_code" class="kt-label mb-2">Parent ICAO Code</label>
                                <input type="text" name="parent_airline_icao_code" id="parent_airline_icao_code"
                                    maxlength="4" class="kt-input h-[45px]" value="{{ old('parent_airline_icao_code') }}"
                                    placeholder="e.g., SVX">
                                @error('parent_airline_icao_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Marketing Name --}}
                            <div>
                                <label for="marketing_name" class="kt-label mb-2">{{ __('main.marketing_name') }}</label>
                                <input type="text" name="marketing_name" id="marketing_name" class="kt-input h-[45px]"
                                    value="{{ old('marketing_name') }}">
                                @error('marketing_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Official Full Name --}}
                            <div>
                                <label for="official_full_name"
                                    class="kt-label mb-2">{{ __('main.official_full_name') }}</label>
                                <input type="text" name="official_full_name" id="official_full_name"
                                    class="kt-input h-[45px]" value="{{ old('official_full_name') }}">
                                @error('official_full_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alliance --}}
                            <div>
                                <label for="alliance" class="kt-label mb-2">{{ __('main.alliance') }}</label>
                                <input type="text" name="alliance" id="alliance" class="kt-input h-[45px]"
                                    value="{{ old('alliance') }}">
                                @error('alliance')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Frequent Flyer Program Name --}}
                            <div>
                                <label for="frequent_flyer_program_name"
                                    class="kt-label mb-2">{{ __('main.frequent_flyer_program_name') }}</label>
                                <input type="text" name="frequent_flyer_program_name" id="frequent_flyer_program_name"
                                    class="kt-input h-[45px]" value="{{ old('frequent_flyer_program_name') }}">
                                @error('frequent_flyer_program_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Type --}}
                            <div>
                                <label for="airline_type" class="kt-label mb-2">{{ __('main.airline_type') }}</label>
                                <input type="text" name="airline_type" id="airline_type" class="kt-input h-[45px]"
                                    value="{{ old('airline_type') }}" placeholder="Full Service, Low Cost, Regional">
                                @error('airline_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Type Code --}}
                            <div>
                                <label for="airline_type_code"
                                    class="kt-label mb-2">{{ __('main.airline_type_code') }}</label>
                                <input type="text" name="airline_type_code" id="airline_type_code"
                                    class="kt-input h-[45px]" value="{{ old('airline_type_code') }}"
                                    placeholder="FSC, LCC, REG">
                                @error('airline_type_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Home Country --}}
                            <div>
                                <label for="airline_home_country"
                                    class="kt-label mb-2">{{ __('main.airline_home_country') }}</label>
                                <input type="text" name="airline_home_country" id="airline_home_country"
                                    class="kt-input h-[45px]" value="{{ old('airline_home_country') }}">
                                @error('airline_home_country')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Home Country Alpha 2 --}}
                            <div>
                                <label for="airline_home_country_alpha_2_code"
                                    class="kt-label mb-2">{{ __('main.airline_home_country_alpha_2_code') }}</label>
                                <input type="text" name="airline_home_country_alpha_2_code"
                                    id="airline_home_country_alpha_2_code" maxlength="2" class="kt-input h-[45px]"
                                    value="{{ old('airline_home_country_alpha_2_code') }}" placeholder="SA">
                                @error('airline_home_country_alpha_2_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Home Country Alpha 3 --}}
                            <div>
                                <label for="airline_home_country_alpha_3_code"
                                    class="kt-label mb-2">{{ __('main.airline_home_country_alpha_3_code') }}</label>
                                <input type="text" name="airline_home_country_alpha_3_code"
                                    id="airline_home_country_alpha_3_code" maxlength="3" class="kt-input h-[45px]"
                                    value="{{ old('airline_home_country_alpha_3_code') }}" placeholder="SAU">
                                @error('airline_home_country_alpha_3_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Airline Home City IATA Code --}}
                            <div>
                                <label for="airline_home_city_iata_code"
                                    class="kt-label mb-2">{{ __('main.airline_home_city_iata_code') }}</label>
                                <input type="text" name="airline_home_city_iata_code" id="airline_home_city_iata_code"
                                    maxlength="3" class="kt-input h-[45px]"
                                    value="{{ old('airline_home_city_iata_code') }}" placeholder="RUH">
                                @error('airline_home_city_iata_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Year of Foundation --}}
                            <div>
                                <label for="year_of_foundation"
                                    class="kt-label mb-2">{{ __('main.year_of_foundation') }}</label>
                                <input type="number" name="year_of_foundation" id="year_of_foundation"
                                    class="kt-input h-[45px]" value="{{ old('year_of_foundation') }}" min="1900"
                                    max="{{ date('Y') }}">
                                @error('year_of_foundation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Official Website --}}
                            <div>
                                <label for="official_website"
                                    class="kt-label mb-2">{{ __('main.official_website') }}</label>
                                <input type="url" name="official_website" id="official_website"
                                    class="kt-input h-[45px]" value="{{ old('official_website') }}">
                                @error('official_website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Baggage Policy URL --}}
                            <div>
                                <label for="baggage_policy_url"
                                    class="kt-label mb-2">{{ __('main.baggage_policy_url') }}</label>
                                <input type="url" name="baggage_policy_url" id="baggage_policy_url"
                                    class="kt-input h-[45px]" value="{{ old('baggage_policy_url') }}">
                                @error('baggage_policy_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Web Check-in URL --}}
                            <div>
                                <label for="web_check_in_url"
                                    class="kt-label mb-2">{{ __('main.web_check_in_url') }}</label>
                                <input type="url" name="web_check_in_url" id="web_check_in_url"
                                    class="kt-input h-[45px]" value="{{ old('web_check_in_url') }}">
                                @error('web_check_in_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Local Phone --}}
                            <div>
                                <label for="local_phone_number"
                                    class="kt-label mb-2">{{ __('main.local_phone_number') }}</label>
                                <input type="text" name="local_phone_number" id="local_phone_number"
                                    class="kt-input h-[45px]" value="{{ old('local_phone_number') }}">
                                @error('local_phone_number')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- International Phone --}}
                            <div>
                                <label for="international_phone_number"
                                    class="kt-label mb-2">{{ __('main.international_phone_number') }}</label>
                                <input type="text" name="international_phone_number" id="international_phone_number"
                                    class="kt-input h-[45px]" value="{{ old('international_phone_number') }}">
                                @error('international_phone_number')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div>
                                <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                    value="{{ old('website') }}">
                                @error('website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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

                <div class="flex flex-wrap" style="gap: 10px 40px">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_lowcost" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_lowcost',
                            'id' => 'is_lowcost',
                            'value' => '1',
                            'label' => __('main.is_lowcost'),
                        ])
                    </div>
                </div>

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', ['models' => 'airlines'])
            </div>
        </form>
    </div>
@endsection
