@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.meal')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.meal')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.meal')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.restaurants.meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST"
                    action="{{ route('dashboard.restaurants.meals.update', $meal->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6 mb-4">
                            {{-- Country Select --}}
                            <div class="align-self-end">
                                <label for="country_id" class="kt-label">
                                    {{ __('main.country') }}
                                </label>
                                <select name="country_id" id="country_id" class="kt-select basic-single">
                                    <option value="" disabled selected>{{ __('main.select') }}</option>
                                    @php $currentCountry = old('country_id', $meal->restaurant->country_id ?? '') @endphp
                                    @foreach (\Modules\Geography\Entities\Country::orderBy('name')->get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $currentCountry == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- State Select --}}
                            <div class="align-self-end">
                                <label for="state_id" class="kt-label">
                                    {{ __('main.state') }}
                                </label>
                                <select name="state_id" id="state_id" class="kt-select basic-single">
                                    <option value="" disabled selected>{{ __('main.select') }}</option>
                                </select>
                            </div>

                            {{-- City Select --}}
                            <div class="align-self-end">
                                <label for="city_id" class="kt-label">
                                    {{ __('main.city') }}
                                </label>
                                <select name="city_id" id="city_id" class="kt-select basic-single">
                                    <option value="" disabled selected>{{ __('main.select') }}</option>
                                </select>
                            </div>

                            {{-- Restaurant Select --}}
                            <div class="align-self-end">
                                <label for="restaurant_id" class="kt-label">
                                    {{ __('main.restaurant') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="restaurant_id" id="restaurant_id" class="kt-select basic-single" required>
                                    <option value="" disabled selected>{{ __('main.select') }}</option>
                                </select>
                                @error('restaurant_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            @include('components.selects.currency', ['record' => $meal])

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label">
                                    {{ __('main.name') }}
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                    value="{{ $meal->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">
                                    {{ __('main.name_ar') }}
                                </label>
                                <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                    value="{{ $meal->name_ar }}">
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- FIT Pricing -->
                        <div class="mt-4 mb-4 bg-white p-4 rounded-lg border border-gray-100">
                            <h4 class="text-md font-bold text-primary mb-3 border-b pb-2">
                                <i class="ki-outline ki-dollar fs-3"></i> {{ __('main.fit_pricing') }}
                            </h4>
                            <div class="flex flex-wrap md:flex-nowrap gap-4 items-end">
                                {{-- Meal Type --}}
                                <div class="flex-1 min-w-[120px]">
                                    <label for="type" class="kt-label text-sm font-semibold mb-1 required">
                                        {{ __('main.meal_type') }} <span class="text-red-600 font-bold">*</span>
                                    </label>
                                    <select name="type" id="type" class="kt-select basic-single" required>
                                        <option value="" disabled selected>{{ __('main.select') }}</option>
                                        <option value="breakfast"
                                            {{ old('type', $meal->type) == 'breakfast' ? 'selected' : '' }}>
                                            {{ __('main.breakfast') }}</option>
                                        <option value="lunch" {{ old('type', $meal->type) == 'lunch' ? 'selected' : '' }}>
                                            {{ __('main.lunch') }}</option>
                                        <option value="dinner"
                                            {{ old('type', $meal->type) == 'dinner' ? 'selected' : '' }}>
                                            {{ __('main.dinner') }}</option>
                                        <option value="other" {{ old('type', $meal->type) == 'other' ? 'selected' : '' }}>
                                            {{ __('main.other') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Season --}}
                                <div class="flex-1 min-w-[120px]">
                                    <label for="season_id" class="kt-label text-sm font-semibold mb-1">
                                        {{ __('main.season') }}
                                    </label>
                                    <select name="season_id" id="season_id" class="kt-select basic-single">
                                        <option value="" selected>{{ __('main.fixed_price_all_year') }}</option>
                                        @foreach ($seasons as $season)
                                            <option value="{{ $season->id }}"
                                                {{ old('season_id', $meal->season_id) == $season->id ? 'selected' : '' }}>
                                                {{ $season->name }}
                                                ({{ \Carbon\Carbon::parse($season->season_from)->format('d/m/Y') }} -
                                                {{ \Carbon\Carbon::parse($season->season_to)->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('season_id')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="flex-1 min-w-[120px]">
                                    <label for="fit_price_adult"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_adult') }}</label>
                                    <input type="number" step="0.01" name="fit_price_adult" id="fit_price_adult"
                                        class="kt-input text-sm w-full h-[38px]" value="{{ $meal->fit_price_adult }}"
                                        placeholder="0.00">
                                </div>
                                <div class="flex-1 min-w-[120px]">
                                    <label for="fit_price_child_6_11"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_6_11') }}</label>
                                    <input type="number" step="0.01" name="fit_price_child_6_11"
                                        id="fit_price_child_6_11" class="kt-input text-sm w-full h-[38px]"
                                        value="{{ $meal->fit_price_child_6_11 }}" placeholder="0.00">
                                </div>
                                <div class="flex-1 min-w-[120px]">
                                    <label for="fit_price_child_under_6"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_under_6') }}</label>
                                    <input type="number" step="0.01" name="fit_price_child_under_6"
                                        id="fit_price_child_under_6" class="kt-input text-sm w-full h-[38px]"
                                        value="{{ $meal->fit_price_child_under_6 }}" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Group Pricing -->
                        <div class="mt-4 mb-4 bg-white p-4 rounded-lg border border-gray-100">
                            <h4 class="text-md font-bold text-primary mb-3 border-b pb-2">
                                <i class="ki-outline ki-profile-2user fs-3"></i> {{ __('main.group_pricing') }}
                            </h4>
                            <div class="flex flex-wrap md:flex-nowrap gap-4 items-end">
                                <div class="flex-1 min-w-[120px]">
                                    <label for="min_group_size"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.min_group_size') }}</label>
                                    <input type="number" name="min_group_size" id="min_group_size"
                                        class="kt-input text-sm w-full h-[38px]"
                                        value="{{ old('min_group_size', $meal->min_group_size) }}" min="1">
                                    @error('min_group_size')
                                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="flex-1 min-w-[120px]">
                                    <label for="group_price_adult"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_adult') }}</label>
                                    <input type="number" step="0.01" name="group_price_adult" id="group_price_adult"
                                        class="kt-input text-sm w-full h-[38px]" value="{{ $meal->group_price_adult }}"
                                        placeholder="0.00">
                                </div>
                                <div class="flex-1 min-w-[120px]">
                                    <label for="group_price_child_6_11"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_6_11') }}</label>
                                    <input type="number" step="0.01" name="group_price_child_6_11"
                                        id="group_price_child_6_11" class="kt-input text-sm w-full h-[38px]"
                                        value="{{ $meal->group_price_child_6_11 }}" placeholder="0.00">
                                </div>
                                <div class="flex-1 min-w-[120px]">
                                    <label for="group_price_child_under_6"
                                        class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_under_6') }}</label>
                                    <input type="number" step="0.01" name="group_price_child_under_6"
                                        id="group_price_child_under_6" class="kt-input text-sm w-full h-[38px]"
                                        value="{{ $meal->group_price_child_under_6 }}" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $meal->description,
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $meal->notes,
                        ])

                        <div class="flex flex-wrap gap-10">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $meal->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_included" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_included',
                                    'id' => 'is_included',
                                    'value' => '1',
                                    'checked' => $meal->is_included,
                                    'label' => __('main.is_included'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_supplement" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_supplement',
                                    'id' => 'is_supplement',
                                    'value' => '1',
                                    'checked' => $meal->is_supplement,
                                    'label' => __('main.is_supplement'),
                                ])
                            </div>
                        </div>

                        {{-- Dynamic Custom Fields --}}
                        <x-custom-fields module-name="restaurants" entity-type="RestaurantMeal" :entity="$meal" />

                        {{-- Update Submit --}}
                        <div class="pb-24 lg:pb-0">
                            @include('components.elements.update-submit', [
                                'models' => 'dashboard.restaurants.meals',
                                'model' => 'meal',
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = $('#country_id');
            const stateSelect = $('#state_id');
            const citySelect = $('#city_id');
            const restaurantSelect = $('#restaurant_id');

            const initCountryId = '{{ old('country_id', $meal->restaurant->country_id ?? '') }}';
            const initStateId = '{{ old('state_id', $meal->restaurant->state_id ?? '') }}';
            const initCityId = '{{ old('city_id', $meal->restaurant->city_id ?? '') }}';
            const initRestaurantId = '{{ old('restaurant_id', $meal->restaurant_id ?? '') }}';

            // Initialize on load
            if (initCountryId) {
                $.get(`/api/countries/${initCountryId}/states`, function(data) {
                    data.forEach(function(state) {
                        stateSelect.append(new Option(state.name, state.id, false, state.id ==
                            initStateId));
                    });
                    stateSelect.trigger('change.select2');

                    if (initStateId) {
                        $.get(`/api/states/${initStateId}/cities`, function(data) {
                            data.forEach(function(city) {
                                citySelect.append(new Option(city.name, city.id, false, city
                                    .id == initCityId));
                            });
                            citySelect.trigger('change.select2');

                            if (initCityId) {
                                $.get(`/api/cities/${initCityId}/restaurants`, function(data) {
                                    data.forEach(function(restaurant) {
                                        restaurantSelect.append(new Option(
                                            restaurant.name, restaurant.id,
                                            false, restaurant.id ==
                                            initRestaurantId));
                                    });
                                    restaurantSelect.trigger('change.select2');
                                });
                            }
                        });
                    }
                });
            }

            // Country change -> load states
            countrySelect.on('change', function(e) {
                if (!e.originalEvent) return; // Prevent triggering on initialization
                const countryId = $(this).val();
                stateSelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');
                citySelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');
                restaurantSelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');

                if (countryId) {
                    $.get(`/api/countries/${countryId}/states`, function(data) {
                        data.forEach(function(state) {
                            stateSelect.append(new Option(state.name, state.id));
                        });
                        stateSelect.trigger('change.select2');
                    });
                }
            });

            // State change -> load cities
            stateSelect.on('change', function(e) {
                if (!e.originalEvent) return; // Prevent triggering on initialization
                const stateId = $(this).val();
                citySelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');
                restaurantSelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');

                if (stateId) {
                    $.get(`/api/states/${stateId}/cities`, function(data) {
                        data.forEach(function(city) {
                            citySelect.append(new Option(city.name, city.id));
                        });
                        citySelect.trigger('change.select2');
                    });
                }
            });

            // City change -> load restaurants
            citySelect.on('change', function(e) {
                if (!e.originalEvent) return; // Prevent triggering on initialization
                const cityId = $(this).val();
                restaurantSelect.empty().append(
                    '<option value="" disabled selected>{{ __('main.select') }}</option>');

                if (cityId) {
                    $.get(`/api/cities/${cityId}/restaurants`, function(data) {
                        data.forEach(function(restaurant) {
                            restaurantSelect.append(new Option(restaurant.name, restaurant
                                .id));
                        });
                        restaurantSelect.trigger('change.select2');
                    });
                }
            });
        });
    </script>
@endpush
