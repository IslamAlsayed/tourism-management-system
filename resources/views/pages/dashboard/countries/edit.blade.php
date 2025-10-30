@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.country')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.country')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.country')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.countries')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.country_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.update', $country->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Country Photo -->
                        @include('components.input-image', [
                            'modelKey' => $country->name ?? 'C',
                            'column' => 'country',
                            'columnName' => 'flag',
                            'photoUrl' => $country->photo ? asset('storage/' . $country->photo) : '',
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Country Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.country_name_arabic') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $country->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.country_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $country->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div class="">
                                <label for="phone_code" class="kt-label mb-2">{{ __('main.phone_code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input h-[45px]"
                                    value="{{ $country->phone_code }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label mb-2">{{ __('main.country_code_iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]" max="2"
                                    value="{{ $country->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.country_code_iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" max="3"
                                    value="{{ $country->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capital City -->
                            <div class="">
                                <label for="capital" class="kt-label mb-2">{{ __('main.capital') }}</label>
                                <input type="text" name="capital" id="capital" class="kt-input h-[45px]"
                                    value="{{ $country->capital }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div class="">
                                <label for="currency_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.currency') }}
                                    <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="currency_id" id="currency_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $country->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language -->
                            <div class="">
                                <label for="language_id" class="kt-label mb-2 flex items-center justify-between">
                                    {{ __('main.language') }}
                                    <a href="{{ route('languages.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="language_id" id="language_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ $country->language_id == $language->id ? 'selected' : '' }}>
                                            {{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="">
                                <label for="population" class="kt-label mb-2">{{ __('main.population') }}</label>
                                <input type="number" name="population" id="population" class="kt-input h-[45px]"
                                    value="{{ $country->population }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Regions [region, subregion, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'state', 'city'],
                                'record' => $country,
                            ])

                            <!-- Area (km²) -->
                            <div class="">
                                <label for="area" class="kt-label mb-2">{{ __('main.area') }}</label>
                                <input type="number" step="any" name="area" id="area"
                                    class="kt-input h-[45px]" value="{{ $country->area }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="">
                                <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="kt-input h-[45px]" value="{{ $country->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="">
                                <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="kt-input h-[45px]" value="{{ $country->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone" class="kt-label mb-2">{{ __('main.main_timezone') }}</label>
                                <select name="timezone" id="timezone" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach (config('helpers.timezones') as $zone)
                                        <option value="{{ $zone }}"
                                            {{ $country->timezone == $zone ? 'selected' : '' }}>
                                            {{ __('main.maps.' . $zone) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Country Settings -->
                        <div class="space-y-4 mb-4">
                            <label class="kt-label mb-2">{{ __('main.country_settings') }}</label>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    @component('components.elements.checkbox-button', [
                                        'name' => 'is_active',
                                        'id' => 'is_active',
                                        'value' => $country->is_active,
                                        'label' => __('main.activate_country'),
                                    ])
                                        {{ $country->is_active == '1' ? 'checked' : '' }}
                                    @endcomponent
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_independent" value="0">
                                    @component('components.elements.checkbox-button', [
                                        'name' => 'is_independent',
                                        'id' => 'is_independent',
                                        'value' => $country->is_independent,
                                        'label' => __('main.independent_country'),
                                    ])
                                        {{ $country->is_independent == '1' ? 'checked' : '' }}
                                    @endcomponent
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_developed" value="0">
                                    @component('components.elements.checkbox-button', [
                                        'name' => 'is_developed',
                                        'id' => 'is_developed',
                                        'value' => $country->is_developed,
                                        'label' => __('main.developed_country'),
                                    ])
                                        {{ $country->is_developed == '1' ? 'checked' : '' }}
                                    @endcomponent
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_landlocked" value="0">
                                    @component('components.elements.checkbox-button', [
                                        'name' => 'is_landlocked',
                                        'id' => 'is_landlocked',
                                        'value' => $country->is_landlocked,
                                        'label' => __('main.landlocked_country'),
                                    ])
                                        {{ $country->is_landlocked == '1' ? 'checked' : '' }}
                                    @endcomponent
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.country')]) }}
                            </button>
                            <button type="submit" name="save_and_edit" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_edit_another') }}
                            </button>
                            <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Geographic Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.geographic_info') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.coordinates_hint') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.iso_codes') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.iso_codes_hint') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.official_currency') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.currency_hint') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id", "edit");
                filterByForeignId("subregion_id", "state", "state_id", "edit");
                filterByForeignId("state_id", "city", "city_id", "edit");
            }, 500);
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // ========================================
            // HELPER FUNCTIONS
            // ========================================
            const getSelect = (id) => document.getElementById(id);
            const getInput = (key) => document.querySelector(`[data-for='${key}'] .tag-input`);

            const getSelectedIds = (name) => {
                return [...document.querySelectorAll(`input[name='${name}']`)]
                    .map(input => input.value)
                    .filter(v => v !== "");
            };

            const loadData = async (fromId, model, toId, value, append = false) => {
                const ref = filterByForeignId(fromId, model, toId);
                if (ref && typeof ref.loadReferenceData === "function") {
                    await ref.loadReferenceData(value, append);
                }
            };

            // ========================================
            // DOM ELEMENTS
            // ========================================
            const subregionSelect = getSelect("subregion_id");
            const stateSelect = getSelect("state_id");
            const citySelect = getSelect("city_id");
            const allStates = getSelect("all_states");
            const allCities = getSelect("all_cities");

            if (!subregionSelect || !stateSelect || !citySelect) return;

            // STATE MANAGEMENT
            let isLoading = false;

            // ========================================
            // MAIN LOGIC
            // ========================================
            async function handleStateChange(triggerType) {
                const stateIds = getSelectedIds("state_id[]");
                const subregionId = getInput("subregion_id")?.dataset.id;

                await resetDependentTags("state_id", getInput("city_id"));

                if (allStates && allStates?.checked) {
                    stateSelect.disabled = true;
                    getSelect("state_id").nextElementSibling?.classList.add('loading');
                    await loadData("subregion_id", "city", "city_id", subregionId);
                    return;
                }

                stateSelect.disabled = false;
                getSelect("state_id").nextElementSibling?.classList.remove('loading');

                if (!stateIds.length) {
                    citySelect.disabled = false;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.parentElement.classList.add('loading');
                    document.getElementById(`city_id-info`)?.classList.add("show");
                    const label = document.getElementById("city_id")?.parentElement.querySelector(
                        ".dataLength");
                    if (label) label.innerText = '';
                    return;
                }

                if (allCities && allCities?.checked) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    return;
                }

                citySelect.disabled = false;
                getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                await loadData("state_id", "city", "city_id", stateIds);
            }

            // ========================================
            // EVENT HANDLERS
            // ========================================
            if (!subregionSelect.dataset.bound) {
                subregionSelect.dataset.bound = "true";
                subregionSelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    const subregionId = getInput("subregion_id")?.dataset.id;

                    if (!subregionId) {
                        stateSelect.innerHTML = '<option value="">--</option>';
                        citySelect.innerHTML = '<option value="">--</option>';
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        document.querySelectorAll(`input[name='state_id[]']`).forEach(i => i.remove());
                        isLoading = false;
                        return;
                    }

                    if (allStates && allStates?.checked) {
                        stateSelect.disabled = true;
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        await loadData("subregion_id", "city", "city_id", subregionId);
                    } else {
                        stateSelect.disabled = false;
                        getSelect("state_id").nextElementSibling?.classList.remove('loading');
                        await loadData("subregion_id", "state", "state_id", subregionId);
                    }

                    isLoading = false;
                });
            }

            if (!stateSelect.dataset.bound) {
                stateSelect.dataset.bound = "true";
                stateSelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;
                    getSelect("city_id").nextElementSibling?.classList.add('loading');
                    document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i.remove());
                    await handleStateChange("updatedSelect");
                    isLoading = false;
                });
            }

            if (!stateSelect.dataset.bound) {
                stateSelect.dataset.bound = "true";
                stateSelect?.addEventListener("multiSelectUpdated", async () => {
                    if (isLoading) return;
                    isLoading = true;
                    // getSelect("city_id").nextElementSibling?.classList.add('loading');
                    // document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i.remove());
                    await handleStateChange("multiSelectUpdated");
                    isLoading = false;
                });
            }

            if (allStates && !allStates.dataset.bound) {
                allStates.dataset.bound = "true";
                allStates?.addEventListener("change", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    // getSelect("city_id").nextElementSibling?.classList.add('loading');
                    // document.querySelectorAll(`input[name='city_id[]']`).forEach(i => i.remove());
                    await handleStateChange("allStatesChange");
                    isLoading = false;
                });
            }

            if (allCities && !allCities.dataset.bound) {
                allCities.dataset.bound = "true";
                allCities?.addEventListener("change", async () => {
                    if (allCities.checked) {
                        citySelect.disabled = true;
                        getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    } else {
                        citySelect.disabled = false;
                        getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                        const stateId = getInput("state_id")?.dataset.id;
                        if (stateId) await loadData("state_id", "city", "city_id", stateIds);
                    }
                });
            }
        });
    </script>
@endpush
