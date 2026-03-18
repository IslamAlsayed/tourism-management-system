@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.meal')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.meal')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.meal')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.restaurants.meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Restaurants\Entities\Restaurant::count() > 0,
                    'route' => route('dashboard.restaurants.index'),
                    'label' => __('main.restaurants'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.restaurants.meals.store') }}">
                    @csrf

                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- Country Select --}}
                            <div class="align-self-end">
                                <label for="country_id" class="kt-label">
                                    {{ __('main.country') }}
                                </label>
                                <select name="country_id" id="country_id" class="kt-select basic-single">
                                    <option value="" disabled selected>{{ __('main.select') }}</option>
                                    @foreach (\Modules\Geography\Entities\Country::orderBy('name')->get(['id', 'name']) as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                                    @if (old('restaurant_id') && isset($restaurants[old('restaurant_id')]))
                                        <option value="{{ old('restaurant_id') }}" selected>
                                            {{ $restaurants[old('restaurant_id')] }}
                                        </option>
                                    @endif
                                </select>
                                @error('restaurant_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Currency --}}
                            <div class="align-self-end">
                                @include('components.selects.currency')
                            </div>
                        </div>

                        <!-- Meals Repeater Container -->
                        <div id="meals_container" class="space-y-8 mt-8">
                        </div>

                        <!-- Add Meal Button -->
                        <div class="flex justify-end mt-6">
                            <button type="button" class="kt-btn kt-btn-primary font-bold shadow-sm" onclick="addMealBlock()">
                                <i class="ki-outline ki-plus fs-3"></i>
                                {{ __('main.add_another_meal_or_price') ?? 'Add Another Meal / Price' }}
                            </button>
                        </div>

                        <!-- Save Submit -->
                        <div class="mt-8 border-t border-gray-200 pt-6 pb-24 lg:pb-0">
                            @include('components.elements.save-submit', [
                                'models' => 'dashboard.restaurants.meals',
                                'model' => 'meal',
                            ])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Meal HTML Template -->
    <template id="meal_template">
        <div class="meal-block bg-gray-50 border border-gray-200 shadow-sm rounded-xl p-6 relative mb-6"
            data-index="__INDEX__">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h3 class="font-bold text-lg text-primary meal-title">Meal #__NUM__</h3>
                <button type="button" class="kt-btn kt-btn-sm kt-btn-light kt-btn-destructive remove-meal-btn" onclick="removeMealBlock(this)">
                    <i class="ki-outline ki-trash fs-4"></i> {{ __('main.remove') ?? 'Remove' }}
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                {{-- Name (English) --}}
                <div class="align-self-end">
                    <label class="kt-label font-bold mb-2 required">
                        {{ __('main.name') }} <span class="text-red-600 font-bold">*</span>
                    </label>
                    <input type="text" class="kt-input h-[45px]" name="meals[__INDEX__][name]" required>
                </div>

                {{-- Name (Arabic) --}}
                <div class="align-self-end">
                    <label class="kt-label font-bold mb-2">
                        {{ __('main.name_ar') }}
                    </label>
                    <input type="text" class="kt-input h-[45px]" name="meals[__INDEX__][name_ar]">
                </div>
            </div>

            <!-- FIT Pricing -->
            <div class="mt-4 mb-4 bg-white p-4 rounded-lg border border-gray-100">
                <h4 class="text-md font-bold text-primary mb-3 flex items-center gap-2">
                    <i class="ki-outline ki-dollar fs-3"></i> {{ __('main.fit_pricing') }}
                    <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded currency-label">-</span>
                </h4>
                <div class="flex flex-wrap md:flex-nowrap gap-4 items-end">
                    {{-- Meal Type --}}
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1 required">
                            {{ __('main.meal_type') }} <span class="text-red-600 font-bold">*</span>
                        </label>
                        <select name="meals[__INDEX__][type]" class="kt-select template-select basic-single" required>
                            <option value="" disabled selected>{{ __('main.select') }}</option>
                            <option value="breakfast">{{ __('main.breakfast') }}</option>
                            <option value="lunch">{{ __('main.lunch') }}</option>
                            <option value="dinner">{{ __('main.dinner') }}</option>
                            <option value="other">{{ __('main.other') }}</option>
                        </select>
                    </div>

                    {{-- Season --}}
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">
                            {{ __('main.season') }}
                        </label>
                        <select name="meals[__INDEX__][season_id]" class="kt-select template-select basic-single">
                            <option value="" selected>{{ __('main.fixed_price_all_year') }}</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}">
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_adult') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][fit_price_adult]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_6_11') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][fit_price_child_6_11]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_under_6') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][fit_price_child_under_6]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Group Pricing -->
            <div class="mt-4 mb-4 bg-white p-4 rounded-lg border border-gray-100">
                <h4 class="text-md font-bold text-primary mb-3 flex items-center gap-2">
                    <i class="ki-outline ki-profile-2user fs-3"></i> {{ __('main.group_pricing') }}
                    <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-1 rounded currency-label">-</span>
                </h4>
                <div class="flex flex-wrap md:flex-nowrap gap-4 items-end">
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.min_group_size') }}</label>
                        <input type="number" name="meals[__INDEX__][min_group_size]"
                            class="kt-input text-sm w-full h-[38px]" value="1" min="1">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_adult') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][group_price_adult]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_6_11') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][group_price_child_6_11]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="kt-label text-sm font-semibold mb-1">{{ __('main.price_child_under_6') }}</label>
                        <input type="number" step="0.01" name="meals[__INDEX__][group_price_child_under_6]"
                            class="kt-input text-sm w-full h-[38px]" placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Textareas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="kt-label font-bold mb-2">{{ __('main.description') }}</label>
                    <textarea name="meals[__INDEX__][description]" class="kt-input w-full h-24 p-3 resize-y bg-white"
                        placeholder="{{ __('main.description') }}"></textarea>
                </div>
                <div>
                    <label class="kt-label font-bold mb-2">{{ __('main.notes') }}</label>
                    <textarea name="meals[__INDEX__][notes]" class="kt-input w-full h-24 p-3 resize-y bg-white"
                        placeholder="{{ __('main.notes') }}"></textarea>
                </div>
            </div>

            <!-- Toggles -->
            <div class="flex flex-wrap gap-8 mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <input type="hidden" name="meals[__INDEX__][is_active]" value="0">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input w-[40px] h-[20px]" type="checkbox"
                            name="meals[__INDEX__][is_active]" value="1" id="is_active___INDEX__" checked />
                        <label class="form-check-label font-bold text-gray-700 ml-2" for="is_active___INDEX__">
                            {{ __('main.is_active') }}
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="meals[__INDEX__][is_included]" value="0">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input w-[40px] h-[20px]" type="checkbox"
                            name="meals[__INDEX__][is_included]" value="1" id="is_included___INDEX__" />
                        <label class="form-check-label font-bold text-gray-700 ml-2" for="is_included___INDEX__">
                            {{ __('main.is_included') }}
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="meals[__INDEX__][is_supplement]" value="0">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input w-[40px] h-[20px]" type="checkbox"
                            name="meals[__INDEX__][is_supplement]" value="1" id="is_supplement___INDEX__" />
                        <label class="form-check-label font-bold text-gray-700 ml-2" for="is_supplement___INDEX__">
                            {{ __('main.is_supplement') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection
@push('scripts')
    <script>
        let mealIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = $('#country_id');
            const stateSelect = $('#state_id');
            const citySelect = $('#city_id');
            const restaurantSelect = $('#restaurant_id');
            const currencySelect = $('#currency_id');

            // --- Geolocation select cascades ---
            countrySelect.on('change', function() {
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

            stateSelect.on('change', function() {
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

            citySelect.on('change', function() {
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

            // --- Currency Reaction ---
            currencySelect.on('change', function() {
                updateCurrencyLabels();
            });

            // --- Initial Setup ---
            addMealBlock();

            setTimeout(() => {
                if (currencySelect.val()) {
                    updateCurrencyLabels();
                }
            }, 100);
        });

        function updateCurrencyLabels() {
            const selectHtml = document.getElementById('currency_id');
            if (selectHtml && selectHtml.options[selectHtml.selectedIndex]) {
                const text = selectHtml.options[selectHtml.selectedIndex].text;
                const code = text.split('-')[0].trim() || text;
                if (code) {
                    document.querySelectorAll('.currency-label').forEach(el => {
                        el.innerText = code;
                    });
                }
            }
        }

        function addMealBlock() {
            const template = document.getElementById('meal_template').innerHTML;

            const rowHtml = template
                .replace(/__INDEX__/g, mealIndex)
                .replace(/__NUM__/g, mealIndex + 1);

            $('#meals_container').append(rowHtml);

            const newBlock = $(`#meals_container .meal-block[data-index="${mealIndex}"]`);

            newBlock.find('.template-select').removeClass('template-select').addClass('basic-single').select2({
                placeholder: "{{ __('main.select') }}"
            });

            if (mealIndex === 0) {
                newBlock.find('.remove-meal-btn').hide();
            }

            updateCurrencyLabels();

            mealIndex++;
        }

        function removeMealBlock(btn) {
            const rowInfo = $(btn).closest('.meal-block');
            rowInfo.fadeOut(200, function() {
                $(this).remove();
                reindexMeals();
            });
        }

        function reindexMeals() {
            $('#meals_container .meal-block').each(function(index) {
                $(this).find('.meal-title').text(`Meal #${index + 1}`);
                if (index === 0) {
                    $(this).find('.remove-meal-btn').hide();
                } else {
                    $(this).find('.remove-meal-btn').show();
                }
            });
        }
    </script>
@endpush
