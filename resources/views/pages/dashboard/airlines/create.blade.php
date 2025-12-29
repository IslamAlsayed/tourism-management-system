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
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('airlines.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Location Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.type_information', ['type' => __('main.location')]) }}
                    </h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        @include('components.regions.create', [
                            'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                            'multiple' => false,
                        ])

                        {{-- Timezone --}}
                        @include('components.selects.timezone', [
                            'name' => 'timezone_id',
                            'timezones' => $timezones,
                        ])

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

            {{-- Airport Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.airport')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        {{-- ICAO Code --}}
                        <div>
                            <label for="icao" class="kt-label mb-2">{{ __('main.icao') }}</label>
                            <input type="text" name="icao" id="icao" maxlength="4" class="kt-input h-[45px]"
                                value="{{ old('icao') }}" placeholder="e.g., OERK">
                            @error('icao')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- IATA Code --}}
                        <div>
                            <label for="iata" class="kt-label mb-2">{{ __('main.iata') }}</label>
                            <input type="text" name="iata" id="iata" maxlength="3" class="kt-input h-[45px]"
                                value="{{ old('iata') }}" placeholder="e.g., RUH">
                            @error('iata')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LID --}}
                        <div>
                            <label for="lid" class="kt-label mb-2">{{ __('main.lid') }}</label>
                            <input type="text" name="lid" id="lid" maxlength="10" class="kt-input h-[45px]"
                                value="{{ old('lid') }}" placeholder="Local Identifier">
                            @error('lid')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Airport Name --}}
                        <div>
                            <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                            <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Airport Name Arabic --}}
                        <div>
                            <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                            <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                value="{{ old('name_ar') }}">
                            @error('name_ar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Subdivision/Type --}}
                        <div>
                            <label for="subd" class="kt-label mb-2">{{ __('main.subd') }}</label>
                            <select name="subd" id="subd" class="kt-input basic-single">
                                <option value="" selected disabled></option>
                                <option value="International" {{ old('subd') == 'International' ? 'selected' : '' }}>
                                    {{ __('main.international') }}
                                </option>
                                <option value="Regional" {{ old('subd') == 'Regional' ? 'selected' : '' }}>
                                    {{ __('main.regional') }}
                                </option>
                                <option value="Domestic" {{ old('subd') == 'Domestic' ? 'selected' : '' }}>
                                    {{ __('main.domestic') }}
                                </option>
                                <option value="Military" {{ old('subd') == 'Military' ? 'selected' : '' }}>
                                    {{ __('main.military') }}
                                </option>
                                <option value="Private" {{ old('subd') == 'Private' ? 'selected' : '' }}>
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

            {{-- Contact Information --}}
            <div class="kt-card mb-6">
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

            <div class="flex flex-wrap gap-10 mb-4">
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
            </div>

            {{-- Save Submit --}}
            @include('components.elements.save-submit', ['models' => 'airlines'])
        </form>
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
