@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.air_transport')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.air_transport')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.air_transport')]) }}
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
        <form class="space-y-6" method="POST" action="{{ route('air-transports.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Basic Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
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

                        {{-- Code --}}
                        <div>
                            <label for="code" class="kt-label required mb-2">{{ __('main.code') }}</label>
                            <input type="text" name="code" id="code" maxlength="3" class="kt-input h-[45px]"
                                value="{{ old('code') }}" placeholder="e.g., SV, EK, QR" required />
                            @error('code')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="air-transports-type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                            <select name="type" id="air-transports-type" class="kt-input h-[45px]" special-search
                                required>
                                <option value="">--</option>
                                @foreach ($airTransportTypes as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                        {{ __('main.' . $type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Service Type --}}
                        <div>
                            <label for="service_type" class="kt-label mb-2">{{ __('main.service_type') }}</label>
                            <select name="service_type" id="service_type" class="kt-input h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($airTransportServiceTypes as $service_type)
                                    <option value="{{ $service_type }}"
                                        {{ old('service_type') == $service_type ? 'selected' : '' }}>
                                        {{ __('main.' . $service_type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_type')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="kt-label mb-2">{{ __('main.status') }}</label>
                            <select name="status" id="status" class="kt-input h-[45px]" special-search>
                                <option value="">--</option>
                                @foreach ($airTransportStatuses as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                        {{ __('main.' . $status) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="kt-label mb-2">{{ __('main.description') }}</label>
                        <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                        <trix-editor input="description" class="trix-content"></trix-editor>
                        @error('description')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        @include('components.regions.create', [
                            'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                            'multiple' => false,
                        ])

                        {{-- Hub Airport --}}
                        <div>
                            <label for="hub_airport" class="kt-label mb-2">{{ __('main.hub_airport') }}</label>
                            <input type="text" name="hub_airport" id="hub_airport" maxlength="10"
                                class="kt-input h-[45px]" value="{{ old('hub_airport') }}"
                                placeholder="e.g., RUH, DXB, DOH" />
                            @error('hub_airport')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Established Date --}}
                        <div>
                            <label for="established_date" class="kt-label mb-2">{{ __('main.established_date') }}</label>
                            <input type="date" name="established_date" id="established_date" class="kt-input h-[45px]"
                                value="{{ old('established_date') }}" />
                            @error('established_date')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Latitude --}}
                        <div>
                            <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                            <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]"
                                value="{{ old('latitude') }}" step="any" minlength="-90" maxlength="90"
                                placeholder="24.9576" />
                            @error('latitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div>
                            <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                            <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]"
                                value="{{ old('longitude') }}" step="any" minlength="-180" maxlength="180"
                                placeholder="46.6988" />
                            @error('longitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="">
                        <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                        <input id="address" type="hidden" name="address" value="{{ old('address') }}">
                        <trix-editor input="address"></trix-editor>
                        @error('address')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Fleet Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.fleet')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Fleet Size --}}
                        <div>
                            <label for="fleet_size" class="kt-label mb-2">{{ __('main.fleet_size') }}</label>
                            <input type="number" name="fleet_size" id="fleet_size" class="kt-input h-[45px]"
                                value="{{ old('fleet_size') }}" minlength="1"
                                placeholder="{{ __('main.number_of_aircraft') }}" />
                            @error('fleet_size')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Passenger Capacity --}}
                        <div>
                            <label for="passenger_capacity"
                                class="kt-label mb-2">{{ __('main.passenger_capacity') }}</label>
                            <input type="number" name="passenger_capacity" id="passenger_capacity"
                                class="kt-input h-[45px]" value="{{ old('passenger_capacity') }}" minlength="1"
                                placeholder="{{ __('main.total_passenger_capacity') }}" />
                            @error('passenger_capacity')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cargo Capacity --}}
                        <div>
                            <label for="cargo_capacity" class="kt-label mb-2">{{ __('main.cargo_capacity') }}</label>
                            <input type="number" name="cargo_capacity" id="cargo_capacity" class="kt-input h-[45px]"
                                value="{{ old('cargo_capacity') }}" minlength="1"
                                placeholder="{{ __('main.cargo_capacity_tons') }}" />
                            @error('cargo_capacity')
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
                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                            <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Booking Phone --}}
                        <div>
                            <label for="booking_phone" class="kt-label mb-2">{{ __('main.booking_phone') }}</label>
                            <input type="text" name="booking_phone" id="booking_phone" class="kt-input h-[45px]"
                                value="{{ old('booking_phone') }}">
                            @error('booking_phone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Customer Service Phone --}}
                        <div>
                            <label for="customer_service_phone"
                                class="kt-label mb-2">{{ __('main.customer_service_phone') }}</label>
                            <input type="text" name="customer_service_phone" id="customer_service_phone"
                                class="kt-input h-[45px]" value="{{ old('customer_service_phone') }}">
                            @error('customer_service_phone')
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

            {{-- Safety Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.safety')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Safety Rating --}}
                        <div>
                            <label for="safety_rating" class="kt-label mb-2">{{ __('main.safety_rating') }}</label>
                            <input type="number" name="safety_rating" id="safety_rating" class="kt-input h-[45px]"
                                value="{{ old('safety_rating') }}" minlength="1" maxlength="10" step="0.1"
                                placeholder="7.5" />
                            @error('safety_rating')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Safety Rating Agency --}}
                        <div>
                            <label for="safety_rating_agency"
                                class="kt-label mb-2">{{ __('main.safety_rating_agency') }}</label>
                            <input type="text" name="safety_rating_agency" id="safety_rating_agency"
                                class="kt-input h-[45px]" value="{{ old('safety_rating_agency') }}"
                                placeholder="Skytrax, AirlineRatings" />
                            @error('safety_rating_agency')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- On-time Performance --}}
                        <div>
                            <label for="on_time_performance"
                                class="kt-label mb-2">{{ __('main.on_time_performance') }}</label>
                            <input type="number" name="on_time_performance" id="on_time_performance"
                                class="kt-input h-[45px]" value="{{ old('on_time_performance') }}" minlength="0"
                                maxlength="100" step="0.01" placeholder="85.5" />
                            @error('on_time_performance')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    {{-- Notes --}}
                    <div>
                        <label for="notes" class="kt-label mb-2">{{ __('main.notes') }}</label>
                        <input id="notes" type="hidden" name="notes" value="{{ old('notes') }}">
                        <trix-editor input="notes" class="trix-content"></trix-editor>
                        @error('notes')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Is Active --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="kt-label mb-0">{{ __('main.active') }}</label>
                            @error('is_active')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is International --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_international" value="0">
                            <input type="checkbox" name="is_international" id="is_international" class="kt-checkbox"
                                value="1" {{ old('is_international') ? 'checked' : '' }}>
                            <label for="is_international" class="kt-label mb-0">{{ __('main.international') }}</label>
                            @error('is_international')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is Domestic --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_domestic" value="0">
                            <input type="checkbox" name="is_domestic" id="is_domestic" class="kt-checkbox"
                                value="1" {{ old('is_domestic') ? 'checked' : '' }}>
                            <label for="is_domestic" class="kt-label mb-0">{{ __('main.domestic') }}</label>
                            @error('is_domestic')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Has Frequent Flyer --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="has_frequent_flyer" value="0">
                            <input type="checkbox" name="has_frequent_flyer" id="has_frequent_flyer" class="kt-checkbox"
                                value="1" {{ old('has_frequent_flyer') ? 'checked' : '' }}>
                            <label for="has_frequent_flyer"
                                class="kt-label mb-0">{{ __('main.frequent_flyer_program') }}</label>
                            @error('has_frequent_flyer')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            @include('components.elements.save-submit', ['models' => 'air-transports'])
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

{{-- @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let airTransportsType = document.getElementById("air-transports-type");
            let serviceTypeSelect = document.getElementById("service_type");

            airTransportsType.addEventListener('updatedSelect', (e) => {
                let type = e.detail.value;

                // Clear service type when type changes
                serviceTypeSelect.value = '';

                // Show/hide fields based on type
                let passengerCapacityField = document.getElementById("passenger_capacity").closest('.grid')
                    .querySelector('[id="passenger_capacity"]').closest('div');
                let cargoCapacityField = document.getElementById("cargo_capacity").closest('div');
                let frequentFlyerField = document.getElementById("has_frequent_flyer").closest('div');

                if (type === 'cargo_airline') {
                    passengerCapacityField.style.display = 'none';
                    cargoCapacityField.style.display = 'block';
                    frequentFlyerField.style.display = 'none';
                } else if (type === 'aircraft_manufacturer') {
                    passengerCapacityField.style.display = 'none';
                    cargoCapacityField.style.display = 'none';
                    frequentFlyerField.style.display = 'none';
                } else {
                    passengerCapacityField.style.display = 'block';
                    cargoCapacityField.style.display = 'block';
                    frequentFlyerField.style.display = 'block';
                }
            });
        });
    </script>
@endpush --}}
