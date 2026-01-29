@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.crossing-port')]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/tagify/tagify.css') }}">
@endpush

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.crossing-port')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.crossing-port')]) }}
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
        <form class="space-y-6" method="POST" action="{{ route('crossings-ports.update', $crossingPort) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                {{-- Location Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [country, state, city] --}}
                        <livewire:regions.location-select-base2 :record="$crossingPort" />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Latitude --}}
                            <div>
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]" value="{{ $crossingPort->latitude }}" step="any" min="-90" max="90" />
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Longitude --}}
                            <div>
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]" value="{{ $crossingPort->longitude }}" step="any" min="-180" max="180" />
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

                {{-- Crossing Port Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.crossing-port')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $crossingPort->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Arabic Name --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $crossingPort->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Code --}}
                            <div>
                                <label for="code" class="kt-label mb-2">{{ __('main.code') }}</label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10" value="{{ $crossingPort->code }}" readonly>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div>
                                <label for="crossings-ports-type" class="kt-label mb-2">
                                    {{ __('main.type') }}
                                    <strong class="dataLength text-primary">({{ count($crossing_port_types) ?: 0 }})</strong>
                                </label>
                                <select name="type" id="crossings-ports-type" class="kt-input basic-single">
                                    <option value="" selected disabled></option>
                                    @foreach ($crossing_port_types as $type)
                                        <option value="{{ $type }}" {{ $crossingPort->type == $type ? 'selected' : '' }}>
                                            {{ __('main.' . $type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div>
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]" value="{{ $crossingPort->sort_order ?? 0 }}" min="0">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.operating_hours') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <div class="col-span-full">
                                <div class="flex items-center gap-4">
                                    <input type="hidden" name="is_24_7" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_24_7',
                                        'id' => 'is_24_7',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_24_7 == 1,
                                        'label' => __('main.is_24_7'),
                                    ])
                                </div>
                            </div>
                            <div class="disabled" id="opening_time">
                                <label for="opening_time" class="kt-label">{{ __('main.opening_time') }}</label>
                                <input type="time" name="opening_time" id="opening_time" class="kt-input h-[45px]" value="{{ $crossingPort->opening_time }}">
                            </div>
                            <div class="disabled" id="closing_time">
                                <label for="closing_time" class="kt-label">{{ __('main.closing_time') }}</label>
                                <input type="time" name="closing_time" id="closing_time" class="kt-input h-[45px]" value="{{ $crossingPort->closing_time }}">
                            </div>
                            <div class="col-span-full border-custom-b pb-4">
                                <label for="operating_days" class="kt-label">{{ __('main.operating_days') }}</label>
                                <div class="flex flex-wrap gap-4 mt-2 ps-8">
                                    @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                        <div class="flex items-center gap-4">
                                            <input type="hidden" name="" value="">
                                            @include('components.elements.checkbox-button', [
                                                'name' => 'operating_days[]',
                                                'id' => 'operating_day_' . $day,
                                                'value' => $day,
                                                'checked' => $crossingPort->operating_days && in_array($day, $crossingPort->operating_days) ? true : false,
                                                'label' => __('main.' . $day),
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label class="kt-label mb-3">{{ __('main.additional_options') }}</label>
                            <div class="flex flex-wrap ps-8" style="gap: 10px 40px;">
                                {{-- Is 24/7 --}}
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_24_7" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_24_7',
                                        'id' => 'is_24_7',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_24_7 == 1,
                                        'label' => __('main.is_24_7'),
                                    ])
                                </div>

                                {{-- Is Commercial --}}
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_commercial" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_commercial',
                                        'id' => 'is_commercial',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_commercial == 1,
                                        'label' => __('main.is_commercial'),
                                    ])
                                </div>

                                {{-- Is Passenger --}}
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_passenger" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_passenger',
                                        'id' => 'is_passenger',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_passenger == 1,
                                        'label' => __('main.is_passenger'),
                                    ])
                                </div>

                                {{-- Is International --}}
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_international" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_international',
                                        'id' => 'is_international',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_international == 1,
                                        'label' => __('main.is_international'),
                                    ])
                                </div>

                                {{-- Is Major --}}
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_major" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'is_major',
                                        'id' => 'is_major',
                                        'value' => '1',
                                        'checked' => $crossingPort->is_major == 1,
                                        'label' => __('main.is_major'),
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Visa & Immigration Policies --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visa_immigration_policies') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Nationality Policy (Tagify) -->
                            <div class="col-span-full">
                                <label for="nationality_policy" class="kt-label">{{ __('main.nationality_policy') }}</label>
                                <input type="text" name="nationality_policy" id="nationality_policy" class="kt-input h-fit tagify-container"
                                    value="{{ $crossingPort->nationality_policy->implode(',') ?? '' }}">
                                <span class="text-xs text-gray-500 mt-1">{{ __('main.tagify_desc') }}</span>
                            </div>

                            {{-- Departure Tax --}}
                            <div>
                                <label for="departure_tax" class="kt-label mb-2">{{ __('main.departure_tax') }}</label>
                                <input type="number" name="departure_tax" id="departure_tax" class="kt-input h-[45px]" value="{{ $crossingPort->departure_tax }}" step="0.01" min="0">
                                @error('departure_tax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Departure Tax Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'departure_tax_currency_id',
                            ])
                        </div>

                        {{-- Allows Visa on Arrival --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="allows_visa_on_arrival" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'allows_visa_on_arrival',
                                'id' => 'allows_visa_on_arrival',
                                'value' => '1',
                                'checked' => $crossingPort->allows_visa_on_arrival == 1,
                                'label' => __('main.allows_visa_on_arrival'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Visa Requirements --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.visa_requirements') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Visa Fee --}}
                            <div>
                                <label for="visa_fee" class="kt-label mb-2">{{ __('main.visa_fee') }}</label>
                                <input type="number" name="visa_fee" id="visa_fee" class="kt-input h-[45px]" value="{{ $crossingPort->visa_fee }}" step="0.01" min="0">
                                @error('visa_fee')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Fee Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'visa_fee_currency_id',
                                'record' => $crossingPort,
                            ])

                            {{-- Visa Duration --}}
                            <div>
                                <label for="visa_duration" class="kt-label mb-2">{{ __('main.visa_duration') }}
                                    ({{ __('main.days') }})</label>
                                <input type="number" name="visa_duration" id="visa_duration" class="kt-input h-[45px]" value="{{ $crossingPort->visa_duration }}" min="1">
                                @error('visa_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Application URL --}}
                            <div>
                                <label for="visa_application_url" class="kt-label mb-2">{{ __('main.visa_application_url') }}</label>
                                <input type="url" name="visa_application_url" id="visa_application_url" class="kt-input h-[45px]" value="{{ $crossingPort->visa_application_url }}">
                                @error('visa_application_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Policy Source --}}
                            <div>
                                <label for="visa_policy_source" class="kt-label mb-2">{{ __('main.visa_policy_source') }}</label>
                                <input type="url" name="visa_policy_source" id="visa_policy_source" class="kt-input h-[45px]" value="{{ $crossingPort->visa_policy_source }}">
                                @error('visa_policy_source')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Last Update --}}
                            <div>
                                <label for="visa_last_update" class="kt-label mb-2">{{ __('main.visa_last_update') }}</label>
                                <input type="date" name="visa_last_update" id="visa_last_update" class="kt-input h-[45px]" value="{{ $crossingPort->visa_last_update }}">
                                @error('visa_last_update')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        {{-- Visa Last Update --}}
                        <div>
                            <label for="visa_conditions" class="kt-label mb-2">{{ __('main.visa_conditions') }}</label>
                            <textarea name="visa_conditions" id="visa_conditions" class="kt-textarea">{{ $crossingPort->visa_conditions }}</textarea>
                            @error('visa_conditions')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.contact')]) }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Email --}}
                            <div>
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]" value="{{ $crossingPort->email }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact Phone --}}
                            <div>
                                <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                <input type="text" name="phone" id="phone" class="kt-input h-[45px]" value="{{ $crossingPort->phone }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Website --}}
                            <div>
                                <label for="website" class="kt-label mb-2">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]" value="{{ $crossingPort->website }}">
                                @error('website')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'description',
                    'value' => $crossingPort->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => $crossingPort->notes,
                ])

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => $crossingPort->is_active == 1,
                        'label' => __('main.is_active'),
                    ])
                </div>

                {{-- Update Submit --}}
                @include('components.elements.update-submit', [
                    'models' => 'crossings-ports',
                    'model' => 'crossing-port',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/tagify/tagify.js') }}"></script>
    <script>
        // Initialize Tagify on Route Itinerary
        var inputs = document.querySelectorAll('.tagify-container');
        if (inputs) {
            inputs.forEach(input => {
                new Tagify(input, {
                    maxTags: 20,
                    dropdown: {
                        maxItems: 20, // <- mixumum allowed rendered suggestions
                        classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
                        enabled: 0, // <- show suggestions on focus
                        closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                    }
                });
            });
        }

        const is_24_7Checkbox = document.getElementById('is_24_7');
        const openingTimeInput = document.getElementById('opening_time');
        const closingTimeInput = document.getElementById('closing_time');
        is_24_7Checkbox.addEventListener('change', function() {
            if (this.checked) {
                openingTimeInput.classList.add('disabled');
                closingTimeInput.classList.add('disabled');
            } else {
                openingTimeInput.classList.remove('disabled');
                closingTimeInput.classList.remove('disabled');
            }
        });
    </script>
@endpush
