@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.crossing_port')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.crossing_port')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.crossing_port')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('crossings-ports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.crossings_ports')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('crossings-ports.update', $crossingPort->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Basic Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                            <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                value="{{ $crossingPort->name }}">
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Arabic Name --}}
                        <div>
                            <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                            <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                value="{{ $crossingPort->name_ar }}">
                            @error('name_ar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Code --}}
                        <div>
                            <label for="code" class="kt-label mb-2">{{ __('main.code') }}</label>
                            <input type="text" name="code" id="code" class="kt-input h-[45px]"
                                value="{{ $crossingPort->code }}" placeholder="e.g., RUH, JED" disabled />
                            @error('code')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div>
                            <label for="crossings-ports-type" class="kt-label mb-2">{{ __('main.type') }}</label>
                            <select name="type" id="crossings-ports-type" class="kt-input h-[45px]" special-search
                                data-current-value="{{ $crossingPort->type }}" data-value="{{ $crossingPort->type }}">
                                <option value="">--</option>
                                @foreach ($crossing_port_types as $key => $type)
                                    <option value="{{ $key }}"
                                        {{ $crossingPort->type == $key ? 'selected' : '' }}>
                                        {{ __('main.' . $type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    @include('components.elements.input-text-editor', [
                        'column' => 'description',
                        'value' => $crossingPort->description,
                    ])
                </div>
            </div>

            {{-- Location Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        @include('components.regions.edit', [
                            'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                            'multiple' => false,
                            'record' => $crossingPort,
                        ])

                        {{-- Latitude --}}
                        <div>
                            <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                            <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]"
                                value="{{ $crossingPort->latitude }}" step="any" min="-90" max="90"
                                placeholder="24.9576" />
                            @error('latitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div>
                            <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                            <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]"
                                value="{{ $crossingPort->longitude }}" step="any" min="-180" max="180"
                                placeholder="46.6988" />
                            @error('longitude')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Address --}}
                         @include('components.elements.input-text-editor', [
                        'column' => 'address',
                        'value' => $crossingPort->address,
                    ])
                </div>
            </div>

            {{-- Operating Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.operating_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        {{-- Opening Time --}}
                        <div>
                            <label for="opening_time" class="kt-label mb-2">{{ __('main.opening_time') }}</label>
                            <input type="time" name="opening_time" id="opening_time" class="kt-input h-[45px]"
                                value="{{ $crossingPort->opening_time }}">
                            @error('opening_time')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Closing Time --}}
                        <div>
                            <label for="closing_time" class="kt-label mb-2">{{ __('main.closing_time') }}</label>
                            <input type="time" name="closing_time" id="closing_time" class="kt-input h-[45px]"
                                value="{{ $crossingPort->closing_time }}">
                            @error('closing_time')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Capacity --}}
                        <div>
                            <label for="capacity" class="kt-label mb-2">{{ __('main.capacity') }}</label>
                            <input type="number" name="capacity" id="capacity" class="kt-input h-[45px]"
                                value="{{ $crossingPort->capacity }}" min="1"
                                placeholder="{{ __('main.passengers_per_hour') }}" />
                            @error('capacity')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Elevation (for airports) --}}
                        <div>
                            <label for="elevation" class="kt-label mb-2">{{ __('main.elevation') }}</label>
                            <input type="text" name="elevation" id="elevation" class="kt-input h-[45px]"
                                value="{{ $crossingPort->elevation }}" placeholder="2049 ft" />
                            @error('elevation')
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                            <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                value="{{ $crossingPort->phone }}">
                            @error('phone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                            <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                value="{{ $crossingPort->email }}">
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Website --}}
                        <div>
                            <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                            <input type="url" name="website" id="website" class="kt-input h-[45px]"
                                value="{{ $crossingPort->website }}">
                            @error('website')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="kt-card-body p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                    {{-- Is Operational --}}
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_operational" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_operational',
                                'id' => 'is_operational',
                                'value' => '1',
                                'checked' => $crossingPort->is_operational,
                                'label' => __('main.operational'),
                            ])
                        </div>
                        @error('is_operational')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Is 24 Hours --}}
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_24_hours" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_24_hours',
                                'id' => 'is_24_hours',
                                'value' => '1',
                                'checked' => $crossingPort->is_24_hours,
                                'label' => __('main.is_24_hours'),
                            ])
                        </div>
                        @error('is_24_hours')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @include('components.elements.update-submit', ['models' => 'crossings-ports'])
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let crossingsPortsType = document.getElementById("crossings-ports-type");
            let facilitiesParent = document.getElementById("facilities");
            let servicesParent = document.getElementById("services");

            crossingsPortsType.addEventListener('updatedSelect', (e) => {
                let type = e.detail.value;
                let facilitiesTypes = document.querySelectorAll(".facility_type");
                let serviceTypes = document.querySelectorAll(".service_type");

                facilitiesTypes.forEach((facility) => {
                    let facilityType = facility.dataset.facilityType;

                    if (type) {
                        if (type == 'international_airport') {
                            facilitiesParent.parentElement.style.display = 'block';
                            if (facilityType == 'duty_free' || facilityType == 'vip_lounge' ||
                                facilityType == 'restaurants' || facilityType ==
                                'currency_exchange' ||
                                facilityType == 'shops') {
                                facility.style.display = 'flex';
                            } else {
                                facility.style.display = 'none';
                                facility.querySelector('input[type="checkbox"]').checked = false;
                            }
                        } else if (type == 'domestic_airport') {
                            facilitiesParent.parentElement.style.display = 'block';
                            if (facilityType == 'restaurants' || facilityType ==
                                'currency_exchange' ||
                                facilityType == 'shops') {
                                facility.style.display = 'flex';
                            } else {
                                facility.style.display = 'none';
                                facility.querySelector('input[type="checkbox"]').checked =
                                    false;
                            }
                        } else if (type == 'seaport') {
                            facilitiesParent.parentElement.style.display = 'block';
                            if (facilityType == 'cargo_handling' ||
                                facilityType ==
                                'passenger_terminal' || facilityType ==
                                'parking') {
                                facility.style.display = 'flex';
                            } else {
                                facility.style.display = 'none';
                                facility.querySelector('input[type="checkbox"]')
                                    .checked = false;
                            }
                        } else {
                            facilitiesParent.parentElement.style.display = 'block';
                            if (facilityType == 'customs' || facilityType == 'immigration' ||
                                facilityType == 'security') {
                                facility.style.display = 'flex';
                            } else {
                                facility.style.display = 'none';
                                facility.querySelector('input[type="checkbox"]').checked = false;
                            }
                        }
                    } else {
                        facilitiesParent.parentElement.style.display = 'none';
                        facilitiesTypes.forEach((facility) => {
                            facility.style.display = 'none';
                            facility.querySelector('input[type="checkbox"]').checked =
                                false;
                        });
                    }
                });

                serviceTypes.forEach((service) => {
                    let serviceType = service.dataset.serviceType;

                    if (type) {
                        if (type == 'international_airport' || type == 'domestic_airport') {
                            servicesParent.parentElement.style.display = 'block';
                            if (serviceType == 'baggage_handling' || serviceType ==
                                'ground_services' ||
                                serviceType == 'fueling') {
                                service.style.display = 'flex';
                            } else {
                                service.style.display = 'none';
                                service.querySelector('input[type="checkbox"]').checked = false;
                            }
                        } else if (type == 'seaport') {
                            servicesParent.parentElement.style.display = 'block';
                            if (serviceType == 'cargo_services' || serviceType ==
                                'passenger_services' ||
                                serviceType == 'ship_services') {
                                service.style.display = 'flex';
                            } else {
                                service.style.display = 'none';
                                service.querySelector('input[type="checkbox"]').checked = false;
                            }
                        } else {
                            servicesParent.parentElement.style.display = 'block';
                            if (serviceType == 'inspection_services' || serviceType ==
                                'document_processing') {
                                service.style.display = 'flex';
                            } else {
                                service.style.display = 'none';
                                service.querySelector('input[type="checkbox"]').checked = false;
                            }
                        }
                    } else {
                        servicesParent.parentElement.style.display = 'none';
                        servicesTypes.forEach((service) => {
                            service.style.display = 'none';
                            service.querySelector('input[type="checkbox"]').checked =
                                false;
                        });
                    }
                });

            });
        });
    </script>
@endpush
