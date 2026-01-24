@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportations-route')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportations-route')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportations-route')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportations.routes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-routes')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\City::count() > 0,
                    'route' => route('cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('transportations.routes.store') }}" method="POST">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div>
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div>
                                <label for="code" class="kt-label">{{ __('main.code') }}</label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10"
                                        value="{{ old('code', fake()->numerify('TR-#####')) }}" required readonly>
                                    <button type="button" toggle-button onclick="window.generateCode('code', 'TR-',5)"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-primary cursor-pointer">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Route Type -->
                            <div>
                                <label for="route_type" class="kt-label required">
                                    {{ __('main.route_type') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="route_type" id="route_type" class="kt-select basic-single" required>
                                    <option value="" selected>--</option>
                                    <option value="one_way" {{ old('route_type') == 'one_way' ? 'selected' : '' }}>
                                        {{ __('main.one_way') }}
                                    </option>
                                    <option value="round_trip" {{ old('route_type') == 'round_trip' ? 'selected' : '' }}>
                                        {{ __('main.round_trip') }}
                                    </option>
                                    <option value="multi_stop" {{ old('route_type') == 'multi_stop' ? 'selected' : '' }}>
                                        {{ __('main.multi_stop') }}
                                    </option>
                                </select>
                                @error('route_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Distance -->
                            <div>
                                <label for="distance" class="kt-label">
                                    {{ __('main.distance') }}
                                    <span class="text-primary font-semibold">(km)</span>
                                </label>
                                <input type="number" name="distance" id="distance" step="0.01"
                                    class="kt-input h-[45px]" value="{{ old('distance') }}" placeholder="150.5">
                                @error('distance')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Estimated Duration -->
                            <div>
                                <label for="estimated_duration" class="kt-label">
                                    {{ __('main.estimated_duration') }}
                                    <span class="text-primary font-semibold">({{ __('main.minutes') }})</span>
                                </label>
                                <input type="number" name="estimated_duration" id="estimated_duration"
                                    class="kt-input h-[45px]" value="{{ old('estimated_duration') }}" placeholder="120">
                                @error('estimated_duration')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Origin Location -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.origin_city') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Origin City -->
                            <div>
                                <label for="origin_city_id" class="kt-label required">
                                    {{ __('main.city') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="origin_city_id" id="origin_city_id" class="kt-select cities-select" required>
                                    <option value="" selected>--</option>
                                </select>
                                @error('origin_city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Origin Address -->
                            <div>
                                <label for="origin_address" class="kt-label">{{ __('main.address') }}</label>
                                <input type="text" name="origin_address" id="origin_address" class="kt-input h-[45px]"
                                    value="{{ old('origin_address') }}" placeholder="Central Bus Station">
                                @error('origin_address')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Origin Latitude -->
                            <div>
                                <label for="origin_latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" name="origin_latitude" id="origin_latitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ old('origin_latitude') }}"
                                    placeholder="30.0444">
                                @error('origin_latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Origin Longitude -->
                            <div>
                                <label for="origin_longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" name="origin_longitude" id="origin_longitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ old('origin_longitude') }}"
                                    placeholder="31.2357">
                                @error('origin_longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Destination Location -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.destination_city') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Destination City -->
                            <div>
                                <label for="destination_city_id" class="kt-label required">
                                    {{ __('main.city') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="destination_city_id" id="destination_city_id"
                                    class="kt-select cities-select" required>
                                    <option value="" selected>--</option>
                                </select>
                                @error('destination_city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Destination Address -->
                            <div>
                                <label for="destination_address" class="kt-label">{{ __('main.address') }}</label>
                                <input type="text" name="destination_address" id="destination_address"
                                    class="kt-input h-[45px]" value="{{ old('destination_address') }}"
                                    placeholder="Main Terminal">
                                @error('destination_address')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Destination Latitude -->
                            <div>
                                <label for="destination_latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" name="destination_latitude" id="destination_latitude"
                                    step="0.0000001" class="kt-input h-[45px]" value="{{ old('destination_latitude') }}"
                                    placeholder="31.2001">
                                @error('destination_latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Destination Longitude -->
                            <div>
                                <label for="destination_longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" name="destination_longitude" id="destination_longitude"
                                    step="0.0000001" class="kt-input h-[45px]"
                                    value="{{ old('destination_longitude') }}" placeholder="29.9187">
                                @error('destination_longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Route Details -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.route_details') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Road Condition -->
                            <div>
                                <label for="road_condition" class="kt-label">{{ __('main.road_condition') }}</label>
                                <select name="road_condition" id="road_condition" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    <option value="excellent"
                                        {{ old('road_condition') == 'excellent' ? 'selected' : '' }}>
                                        {{ __('main.excellent') }}
                                    </option>
                                    <option value="good" {{ old('road_condition') == 'good' ? 'selected' : '' }}>
                                        {{ __('main.good') }}
                                    </option>
                                    <option value="fair" {{ old('road_condition') == 'fair' ? 'selected' : '' }}>
                                        {{ __('main.fair') }}
                                    </option>
                                    <option value="poor" {{ old('road_condition') == 'poor' ? 'selected' : '' }}>
                                        {{ __('main.poor') }}
                                    </option>
                                </select>
                                @error('road_condition')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Toll Fee -->
                            <div>
                                <label for="toll_fee" class="kt-label">{{ __('main.toll_fee') }}</label>
                                <input type="number" name="toll_fee" id="toll_fee" step="0.01"
                                    class="kt-input h-[45px]" value="{{ old('toll_fee') }}" placeholder="0.00">
                                @error('toll_fee')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => old('description'),
                ])

                <!-- Notes -->
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <!-- Is Active -->
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => old('is_active', 1),
                            'label' => __('main.active'),
                        ])
                    </div>

                    <!-- Is Toll Road -->
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_toll_road" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_toll_road',
                            'id' => 'is_toll_road',
                            'value' => '1',
                            'checked' => old('is_toll_road', 0),
                            'label' => __('main.is_toll_road'),
                        ])
                    </div>
                </div>

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', [
                    'models' => 'transportations.routes',
                    'model' => 'route',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize Select2 for cities with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const citiesSelects = $('.cities-select');

            citiesSelects.select2({
                ajax: {
                    url: '{{ route('routes.cities') }}',
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                placeholder: '{{ __('main.search') }}...',
                allowClear: true,
                language: {
                    inputTooShort: function(args) {
                        return '--';
                    },
                    noResults: function() {
                        return '{{ __('main.no_results_found') }}';
                    }
                }
            });

            // Load initial 25 cities
            citiesSelects.each(function() {
                $.ajax({
                    url: '{{ route('routes.cities') }}',
                    type: 'GET',
                    data: {
                        q: '',
                        page: 1
                    },
                    dataType: 'json',
                    success: function(data) {
                        const select = $(this);
                        data.results.forEach(function(city) {
                            const option = new Option(city.text.trim(), city.id);
                            select.append(option);
                        });
                    }.bind(this)
                });
            });
        });
    </script>
@endpush
