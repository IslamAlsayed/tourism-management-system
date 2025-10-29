@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.tour-guide-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.tour-guide-type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.tour-guide-type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.tour-guide-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Tour Guides Types Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.tour-guide-type')]) }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('tour-guides-types.update', $tourGuideType->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label required mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" required
                                    value="{{ $tourGuideType->type }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price --}}
                            <div class="">
                                <label for="price" class="kt-label required mb-2">{{ __('main.price') }}</label>
                                <input type="text" name="price" min="1" id="price" class="kt-input h-[45px]"
                                    required value="{{ $tourGuideType->price }}">
                                @error('price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Currency --}}
                            <div class="">
                                <label for="currency_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div class="text-nowrap">
                                        {{ __('main.currency') }}
                                        <strong class="dataLength text-primary">({{ $currencies->count() ?: 0 }})</strong>
                                    </div>
                                    <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="currency_id" id="currency_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $tourGuideType->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.edit', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'record' => $tourGuideType,
                            ])
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.update_type', ['type' => __('main.tour-guide-type')]) }}
                            </button>
                            <a href="{{ route('tour-guides-types.index') }}" class="kt-btn kt-btn-outline">
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
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.gender')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.gender'), 'type2' => __('main.tour-guide-type')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.country')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.country'), 'type2' => __('main.tour-guide-type')]) }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.type_selection', ['type' => __('main.currency')]) }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.must_select_type1_before_creating_type2', ['type1' => __('main.currency'), 'type2' => __('main.tour-guide-type')]) }}
                                </div>
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
                filterByForeignId("subregion_id", "country", "country_id", "edit");
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
            const countrySelect = getSelect("country_id");
            const stateSelect = getSelect("state_id");
            const citySelect = getSelect("city_id");
            const allStates = getSelect("all_states");
            const allCities = getSelect("all_cities");

            if (!countrySelect || !stateSelect || !citySelect) return;

            // STATE MANAGEMENT
            let isLoading = false;

            // ========================================
            // MAIN LOGIC
            // ========================================
            async function handleStateChange(triggerType) {
                const stateIds = getSelectedIds("state_id[]");
                const countryId = getInput("country_id")?.dataset.id;

                await resetDependentTags("state_id", getInput("city_id"));

                if (allStates?.checked) {
                    stateSelect.disabled = true;
                    getSelect("state_id").nextElementSibling?.classList.add('loading');
                    await loadData("country_id", "city", "city_id", countryId);
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

                if (allCities?.checked) {
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
            if (!countrySelect.dataset.bound) {
                countrySelect.dataset.bound = "true";
                countrySelect?.addEventListener("updatedSelect", async () => {
                    if (isLoading) return;
                    isLoading = true;

                    const countryId = getInput("country_id")?.dataset.id;

                    if (!countryId) {
                        stateSelect.innerHTML = '<option value="">--</option>';
                        citySelect.innerHTML = '<option value="">--</option>';
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        document.querySelectorAll(`input[name='state_id[]']`).forEach(i => i.remove());
                        isLoading = false;
                        return;
                    }

                    if (allStates?.checked) {
                        stateSelect.disabled = true;
                        getSelect("state_id").nextElementSibling?.classList.add('loading');
                        await loadData("country_id", "city", "city_id", countryId);
                    } else {
                        stateSelect.disabled = false;
                        getSelect("state_id").nextElementSibling?.classList.remove('loading');
                        await loadData("country_id", "state", "state_id", countryId);
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

            if (!allStates.dataset.bound) {
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

            if (!allCities.dataset.bound) {
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
