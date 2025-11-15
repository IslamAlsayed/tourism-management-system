@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.air_transport')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.air_transport')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.air_transport')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('air-transports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.air_transports')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('air-transports.update', $airTransport->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Airport Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.airport_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- ICAO Code --}}
                        <div>
                            <label for="icao" class="kt-label mb-2">{{ __('main.icao') }}</label>
                            <input type="text" name="icao" id="icao" maxlength="4" class="kt-input h-[45px]"
                                value="{{ old('icao', $airTransport->icao) }}" placeholder="e.g., OERK">
                            @error('icao')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- IATA Code --}}
                        <div>
                            <label for="iata" class="kt-label mb-2">{{ __('main.iata') }}</label>
                            <input type="text" name="iata" id="iata" maxlength="3" class="kt-input h-[45px]"
                                value="{{ old('iata', $airTransport->iata) }}" placeholder="e.g., RUH">
                            @error('iata')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LID --}}
                        <div>
                            <label for="lid" class="kt-label mb-2">{{ __('main.lid') }}</label>
                            <input type="text" name="lid" id="lid" maxlength="10" class="kt-input h-[45px]"
                                value="{{ old('lid', $airTransport->lid) }}" placeholder="Local Identifier">
                            @error('lid')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Airport Name --}}
                        <div>
                            <label for="airport_name" class="kt-label required mb-2">{{ __('main.airport_name') }}</label>
                            <input type="text" name="airport_name" id="airport_name" class="kt-input h-[45px]"
                                value="{{ old('airport_name', $airTransport->airport_name) }}" required>
                            @error('airport_name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Airport Name Arabic --}}
                        <div>
                            <label for="airport_name_ar" class="kt-label mb-2">{{ __('main.airport_name_ar') }}</label>
                            <input type="text" name="airport_name_ar" id="airport_name_ar" class="kt-input h-[45px]"
                                value="{{ old('airport_name_ar', $airTransport->airport_name_ar) }}">
                            @error('airport_name_ar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subdivision/Type --}}
                        <div>
                            <label for="subd" class="kt-label mb-2">{{ __('main.subd') }}</label>
                            <select name="subd" id="subd" class="kt-input h-[45px]" special-search>
                                <option value="">--</option>
                                <option value="International"
                                    {{ old('subd', $airTransport->subd) == 'International' ? 'selected' : '' }}>
                                    {{ __('main.international') }}
                                </option>
                                <option value="Regional"
                                    {{ old('subd', $airTransport->subd) == 'Regional' ? 'selected' : '' }}>
                                    {{ __('main.regional') }}
                                </option>
                                <option value="Domestic"
                                    {{ old('subd', $airTransport->subd) == 'Domestic' ? 'selected' : '' }}>
                                    {{ __('main.domestic') }}
                                </option>
                                <option value="Military"
                                    {{ old('subd', $airTransport->subd) == 'Military' ? 'selected' : '' }}>
                                    {{ __('main.military') }}
                                </option>
                                <option value="Private"
                                    {{ old('subd', $airTransport->subd) == 'Private' ? 'selected' : '' }}>
                                    {{ __('main.private') }}
                                </option>
                            </select>
                            @error('subd')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        @include('components.regions.edit', [
                            'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                            'multiple' => false,
                            'record' => $airTransport,
                        ])

                        {{-- Elevation --}}
                        <div>
                            <label for="elevation" class="kt-label mb-2">{{ __('main.elevation') }}</label>
                            <input type="number" name="elevation" id="elevation" class="kt-input h-[45px]"
                                value="{{ old('elevation', $airTransport->elevation) }}" step="0.01"
                                placeholder="meters">
                            @error('elevation')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Latitude --}}
                        <div>
                            <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                            <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]"
                                value="{{ old('latitude', $airTransport->latitude) }}" step="any" min="-90"
                                max="90" placeholder="24.9576">
                            @error('latitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div>
                            <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                            <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]"
                                value="{{ old('longitude', $airTransport->longitude) }}" step="any" min="-180"
                                max="180" placeholder="46.6988">
                            @error('longitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Time Zone --}}
                        <div>
                            <label for="timezone" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                            <input type="text" name="timezone" id="timezone" class="kt-input h-[45px]"
                                value="{{ old('timezone', $airTransport->timezone) }}" placeholder="Asia/Riyadh">
                            @error('timezone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Local Phone --}}
                        <div>
                            <label for="local_phone_number"
                                class="kt-label mb-2">{{ __('main.local_phone_number') }}</label>
                            <input type="text" name="local_phone_number" id="local_phone_number"
                                class="kt-input h-[45px]"
                                value="{{ old('local_phone_number', $airTransport->local_phone_number) }}">
                            @error('local_phone_number')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- International Phone --}}
                        <div>
                            <label for="international_phone_number"
                                class="kt-label mb-2">{{ __('main.international_phone_number') }}</label>
                            <input type="text" name="international_phone_number" id="international_phone_number"
                                class="kt-input h-[45px]"
                                value="{{ old('international_phone_number', $airTransport->international_phone_number) }}">
                            @error('international_phone_number')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Website --}}
                        <div>
                            <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                            <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                value="{{ old('website', $airTransport->website) }}">
                            @error('website')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            @include('components.elements.update-submit', ['models' => 'air-transports'])
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
    </script>
@endpush

@include('components.regions.script-cascading')
