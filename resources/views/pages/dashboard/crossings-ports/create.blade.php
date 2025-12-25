@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.crossing_port')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.crossing_port')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.crossing_port')]) }}
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
        <form class="space-y-6" method="POST" action="{{ route('crossings-ports.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                {{-- Location Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])

                            {{-- Latitude --}}
                            <div>
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" name="latitude" id="latitude" class="kt-input h-[45px]"
                                    value="{{ old('latitude') }}" step="any" min="-90" max="90"
                                    placeholder="24.9576" />
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Longitude --}}
                            <div>
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" name="longitude" id="longitude" class="kt-input h-[45px]"
                                    value="{{ old('longitude') }}" step="any" min="-180" max="180"
                                    placeholder="46.6988" />
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Address --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'address',
                            'value' => old('address'),
                        ])
                    </div>
                </div>

                {{-- Crossing Port Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.crossing_port')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
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
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10"
                                        value="{{ old('code', fake()->numerify('CP-#####')) }}" required readonly>

                                    <button type="button" onclick="generateNewCode()" toggle-button
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-primary cursor-pointer hover:text-gray-700">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div>
                                <label for="crossings-ports-type"
                                    class="kt-label required mb-2">{{ __('main.type') }}</label>
                                <select name="type" id="crossings-ports-type" class="kt-input basic-single" required>
                                    <option value="" selected disabled></option>
                                    @foreach ($crossing_port_types as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                            {{ __('main.' . $type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Operating Information --}}
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.operating_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Operating days --}}
                            <div>
                                <label for="operating_days" class="kt-label mb-2">{{ __('main.operating_days') }}</label>
                                <select name="operating_days[]" id="operating_days" class="kt-select basic-multiple"
                                    multiple>
                                    @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $days)
                                        <option value="{{ $days }}"
                                            {{ in_array($days, old('operating_days', [])) ? 'selected' : '' }}>
                                            {{ __('main.' . $days) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('operating_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Operating Hours --}}
                            <div>
                                <label for="operating_hours" class="kt-label mb-2">{{ __('main.operating_hours') }}</label>
                                <input type="text" name="operating_hours" id="operating_hours"
                                    class="kt-input h-[45px]" value="{{ old('operating_hours') }}"
                                    placeholder="e.g., 24/7, 08:00-18:00">
                                @error('operating_hours')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div>
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            {{-- Is 24/7 --}}
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_24_7" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_24_7',
                                    'id' => 'is_24_7',
                                    'value' => '1',
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
                                    'label' => __('main.is_major'),
                                ])
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
                            {{-- Departure Tax --}}
                            <div>
                                <label for="departure_tax" class="kt-label mb-2">{{ __('main.departure_tax') }}</label>
                                <input type="number" name="departure_tax" id="departure_tax" class="kt-input h-[45px]"
                                    value="{{ old('departure_tax') }}" step="0.01" min="0">
                                @error('departure_tax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Departure Tax Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'departure_tax_currency',
                                'currencies' => $currencies,
                            ])
                        </div>

                        {{-- Allows Visa on Arrival --}}
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="allows_visa_on_arrival" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'allows_visa_on_arrival',
                                'id' => 'allows_visa_on_arrival',
                                'value' => '1',
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
                                <input type="number" name="visa_fee" id="visa_fee" class="kt-input h-[45px]"
                                    value="{{ old('visa_fee') }}" step="0.01" min="0">
                                @error('visa_fee')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Fee Currency --}}
                            @include('components.selects.currency', [
                                'name' => 'visa_fee_currency',
                                'currencies' => $currencies,
                            ])

                            {{-- Visa Duration --}}
                            <div>
                                <label for="visa_duration" class="kt-label mb-2">{{ __('main.visa_duration') }}
                                    ({{ __('main.days') }})</label>
                                <input type="number" name="visa_duration" id="visa_duration" class="kt-input h-[45px]"
                                    value="{{ old('visa_duration') }}" min="1">
                                @error('visa_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Application URL --}}
                            <div>
                                <label for="visa_application_url"
                                    class="kt-label mb-2">{{ __('main.visa_application_url') }}</label>
                                <input type="url" name="visa_application_url" id="visa_application_url"
                                    class="kt-input h-[45px]" value="{{ old('visa_application_url') }}">
                                @error('visa_application_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Policy Source --}}
                            <div>
                                <label for="visa_policy_source"
                                    class="kt-label mb-2">{{ __('main.visa_policy_source') }}</label>
                                <input type="url" name="visa_policy_source" id="visa_policy_source"
                                    class="kt-input h-[45px]" value="{{ old('visa_policy_source') }}">
                                @error('visa_policy_source')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Visa Last Update --}}
                            <div>
                                <label for="visa_last_update"
                                    class="kt-label mb-2">{{ __('main.visa_last_update') }}</label>
                                <input type="date" name="visa_last_update" id="visa_last_update"
                                    class="kt-input h-[45px]" value="{{ old('visa_last_update') }}">
                                @error('visa_last_update')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Visa Conditions --}}
                        @include('components.elements.input-text-editor', [
                            'column' => 'visa_conditions',
                            'value' => old('visa_conditions'),
                        ])
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
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact Phone --}}
                            <div>
                                <label for="contact_phone" class="kt-label mb-2">{{ __('main.contact_phone') }}</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="kt-input h-[45px]"
                                    value="{{ old('contact_phone') }}">
                                @error('contact_phone')
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
                    'column' => 'description',
                    'value' => old('description'),
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'column' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    @include('components.elements.checkbox-button', [
                        'name' => 'is_active',
                        'id' => 'is_active',
                        'value' => '1',
                        'checked' => 1,
                        'label' => __('main.is_active'),
                    ])
                </div>

                @include('components.elements.save-submit', ['models' => 'crossings-ports'])
            </div>
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

        function generateNewCode() {
            function getRandomCode() {
                const randomNum = Math.floor(Math.random() * 99999) + 1;
                const paddedNum = String(randomNum).padStart(5, '0');
                return 'CP-' + paddedNum;
            }
            document.getElementById('code').value = getRandomCode();
        }
    </script>
@endpush

@include('components.regions.script-cascading')
