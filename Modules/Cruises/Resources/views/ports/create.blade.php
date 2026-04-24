@extends('layouts.master')

@section('title', __('main.create_vessel') /* Can be replaced with main.create_port later */)

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.ports')]) }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('dashboard.cruises.ports.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.general_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Arabic Name --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div>
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <select name="type" id="type" class="kt-input">
                                    <option value="" selected disabled>{{ __('main.select_option') }}</option>
                                    <option value="Ocean" {{ old('type') == 'Ocean' ? 'selected' : '' }}>
                                        {{ __('main.type_ocean') }}</option>
                                    <option value="River" {{ old('type') == 'River' ? 'selected' : '' }}>
                                        {{ __('main.type_river') }}</option>
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.location') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Country --}}
                            <div>
                                <label for="country_id" class="kt-label mb-2">{{ __('main.country') }}</label>
                                <select name="country_id" id="country_id" class="kt-input">
                                    <option value="">{{ __('main.select_option') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City --}}
                            <div>
                                <label for="city_id" class="kt-label mb-2">{{ __('main.city') }}</label>
                                <select name="city_id" id="city_id" class="kt-input">
                                    <option value="">{{ __('main.select_option') }}</option>
                                    {{-- Cities should be populated via Ajax based on Country selected, leaving generic for now --}}
                                </select>
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Latitude --}}
                            <div>
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Longitude --}}
                            <div>
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('dashboard.cruises.ports.index') }}"
                        class="kt-btn kt-btn-outline">{{ __('main.cancel') }}</a>
                    <button type="submit" class="kt-btn kt-btn-primary">{{ __('main.save_and_continue') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('country_id');
            const citySelect = document.getElementById('city_id');
            const oldCityId = '{{ old('city_id') }}';

            function loadCities(countryId, selectedCityId = null) {
                citySelect.innerHTML = '<option value="">{{ __('main.loading') }}...</option>';
                citySelect.disabled = true;

                if (!countryId) {
                    citySelect.innerHTML = '<option value="">{{ __('main.select_option') }}</option>';
                    citySelect.disabled = false;
                    return;
                }

                fetch(`/api/countries/${countryId}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="">{{ __('main.select_option') }}</option>';
                        if (data && data.length > 0) {
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name + (city.name_ar ? ' / ' + city.name_ar :
                                    '');
                                if (selectedCityId && selectedCityId == city.id) {
                                    option.selected = true;
                                }
                                citySelect.appendChild(option);
                            });
                        }
                        citySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching cities:', error);
                        citySelect.innerHTML = '<option value="">{{ __('main.select_option') }}</option>';
                        citySelect.disabled = false;
                    });
            }

            countrySelect.addEventListener('change', function() {
                loadCities(this.value);
            });

            // Initialize on page load if country is selected
            if (countrySelect.value) {
                loadCities(countrySelect.value, oldCityId);
            }
        });
    </script>
@endpush
