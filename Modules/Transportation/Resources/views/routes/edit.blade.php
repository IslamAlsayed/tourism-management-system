@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.transportations-route')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.transportations-route')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.transportations-route')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.transportation.routes.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportations-routes')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.transportation.routes.update', $route->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $route->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div>
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $route->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div>
                                <label for="code" class="kt-label">{{ __('main.code') }}</label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10"
                                        value="{{ $route->code }}" readonly>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Route Type -->
                            <div>
                                <label for="route_type" class="kt-label">
                                    {{ __('main.route_type') }}
                                </label>
                                <select name="route_type" id="route_type" class="kt-select basic-single">
                                    <option value="" selected>--</option>
                                    <option value="one_way" {{ $route->route_type == 'one_way' ? 'selected' : '' }}>
                                        {{ __('main.one_way') }}
                                    </option>
                                    <option value="round_trip" {{ $route->route_type == 'round_trip' ? 'selected' : '' }}>
                                        {{ __('main.round_trip') }}
                                    </option>
                                    <option value="multi_stop" {{ $route->route_type == 'multi_stop' ? 'selected' : '' }}>
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
                                    class="kt-input h-[45px]" value="{{ $route->distance }}" placeholder="150.5">
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
                                    class="kt-input h-[45px]" value="{{ $route->estimated_duration }}" placeholder="120">
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
                                <label for="origin_city_id" class="kt-label">{{ __('main.city') }}</label>
                                <select name="origin_city_id" id="origin_city_id" class="kt-select cities-select"
                                    data-value="{{ $route->origin_city_id }}">
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
                                    value="{{ $route->origin_address }}" placeholder="Central Bus Station">
                                @error('origin_address')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Origin Latitude -->
                            <div>
                                <label for="origin_latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" name="origin_latitude" id="origin_latitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ $route->origin_latitude }}"
                                    placeholder="30.0444">
                                @error('origin_latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Origin Longitude -->
                            <div>
                                <label for="origin_longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" name="origin_longitude" id="origin_longitude" step="0.0000001"
                                    class="kt-input h-[45px]" value="{{ $route->origin_longitude }}"
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
                                <label for="destination_city_id" class="kt-label">{{ __('main.city') }}</label>
                                <select name="destination_city_id" id="destination_city_id"
                                    class="kt-select cities-select" data-value="{{ $route->destination_city_id }}">
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
                                    class="kt-input h-[45px]" value="{{ $route->destination_address }}"
                                    placeholder="Main Terminal">
                                @error('destination_address')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Destination Latitude -->
                            <div>
                                <label for="destination_latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" name="destination_latitude" id="destination_latitude"
                                    step="0.0000001" class="kt-input h-[45px]"
                                    value="{{ $route->destination_latitude }}" placeholder="31.2001">
                                @error('destination_latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Destination Longitude -->
                            <div>
                                <label for="destination_longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" name="destination_longitude" id="destination_longitude"
                                    step="0.0000001" class="kt-input h-[45px]"
                                    value="{{ $route->destination_longitude }}" placeholder="29.9187">
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
                                        {{ $route->road_condition == 'excellent' ? 'selected' : '' }}>
                                        {{ __('main.excellent') }}
                                    </option>
                                    <option value="good" {{ $route->road_condition == 'good' ? 'selected' : '' }}>
                                        {{ __('main.good') }}
                                    </option>
                                    <option value="fair" {{ $route->road_condition == 'fair' ? 'selected' : '' }}>
                                        {{ __('main.fair') }}
                                    </option>
                                    <option value="poor" {{ $route->road_condition == 'poor' ? 'selected' : '' }}>
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
                                    class="kt-input h-[45px]" value="{{ $route->toll_fee }}" placeholder="0.00">
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
                    'value' => $route->description,
                ])

                <!-- Notes -->
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $route->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <!-- Is Active -->
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $route->is_active,
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
                            'checked' => $route->is_toll_road,
                            'label' => __('main.is_toll_road'),
                        ])
                    </div>
                </div>

                {{-- Custom Fields --}}
                <x-custom-fields module-name="transportation" entity-type="Route" :entity="$route" />

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'dashboard.transportation.routes',
                    'model' => 'route',
                ])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citiesSelects = $('.cities-select');

            // Initialize Select2
            citiesSelects.select2({
                ajax: {
                    url: '{{ route('routes.cities') }}',
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
                placeholder: '{{ __('main.search') }}...',
                allowClear: true,
                minimumInputLength: 0,
                language: {
                    inputTooShort: function() {
                        return '--';
                    },
                    noResults: function() {
                        return '{{ __('main.no_results_found') }}';
                    }
                }
            });

            // ✅ Handle EDIT MODE for each select
            citiesSelects.each(function() {
                const select = $(this); // ✅ مهم
                const selectedCityId = select.data('value');
                if (!selectedCityId) return;
                $.ajax({
                    url: '{{ url('api/routes/cities') }}/' + selectedCityId,
                    type: 'GET',
                    dataType: 'json'
                }).done(function(data) {
                    if (select.find("option[value='" + data.id + "']").length) {
                        return;
                    }
                    const option = new Option(data.text, data.id, true, true);
                    select.append(option).trigger('change');
                });
            });
        });
    </script>
@endpush
