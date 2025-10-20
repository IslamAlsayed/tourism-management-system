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
                    {{ __('main.back_to_types', ['type' => __('main.tour-guide-types')]) }}
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
                                    <div>
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

                            {{-- Region --}}
                            <div class="">
                                <label for="region_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div>
                                        {{ __('main.region') }}
                                        <strong class="dataLength text-primary">({{ $regions->count() ?: 0 }})</strong>
                                    </div>

                                    <a href="{{ route('regions.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="region_id" id="region_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}"
                                            {{ $tourGuideType->region_id == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Subregion --}}
                            <div class="loading">
                                <label for="subregion_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div>
                                        {{ __('main.subregion') }}
                                        <strong class="dataLength text-primary"></strong>
                                        <i id="subregion_id-loader"
                                            class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                        <span class="text-red-600 text-sm span-info show" id="subregion_id-info">
                                            (You must select region first)
                                        </span>
                                    </div>
                                    <a href="{{ route('subregions.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]" special-search
                                    data-current-value="{{ $tourGuideType->subregion_id }}"
                                    value="{{ $tourGuideType->subregion_id }}">
                                    <option value="">--</option>
                                    {{-- Subregions will be loaded dynamically based on selected region --}}
                                </select>
                                @error('subregion_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Country --}}
                            <div class="loading">
                                <label for="country_id" class="kt-label required mb-2 flex items-center justify-between">
                                    <div>
                                        {{ __('main.country') }}
                                        <strong class="dataLength text-primary"></strong>
                                        <i id="country_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                        <span class="text-red-600 text-sm span-info show" id="country_id-info">
                                            (You must select subregion first)
                                        </span>
                                    </div>
                                    <a href="{{ route('countries.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]" special-search
                                    data-current-value="{{ $tourGuideType->country_id }}"
                                    value="{{ $tourGuideType->country_id }}">
                                    <option value="">--</option>
                                    {{-- Countries will be loaded dynamically based on selected subregion --}}
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- State --}}
                            {{-- <div class="{{ !$tourGuideType->state_id ? 'loading' : '' }}"> --}}
                            <div class="loading">
                                <label for="all_states" class="kt-label required mb-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-2">
                                            <input type="hidden" name="all_states" value="0">
                                            <input type="checkbox" name="all_states" id="all_states" class="kt-checkbox"
                                                style="width: 17px; height: 17px;" value="1"
                                                {{ $tourGuideType->all_states == 1 ? 'checked' : '' }}>
                                            {{ __('main.all_types', ['types' => __('main.states')]) }}
                                            <strong class="dataLength text-primary"></strong>
                                            <i id="state_id-loader"
                                                class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                        </div>
                                        {{-- <span class="text-red-600 text-sm span-info {{ !$tourGuideType->state_id ? 'show' : '' }}" id="state_id-info"> --}}
                                        <span class="text-red-600 text-sm span-info show" id="state_id-info">
                                            (You must select country first)
                                        </span>
                                    </div>
                                    <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="state_id[]" id="state_id" class="kt-select h-[45px]" special-multiple
                                    data-current-value="{{ $tourGuideType->state_id }}"
                                    value="{{ $tourGuideType->state_id }}">
                                    <option value="">--</option>
                                    {{-- States will be loaded dynamically based on selected country --}}
                                </select>
                                @if (!empty($tourGuideType->state_list))
                                    @foreach ($tourGuideType->state_list as $item)
                                        <input type="hidden" name="state_id[]" data-name="{{ $item['name'] }}"
                                            value="{{ $item['id'] }}">
                                    @endforeach
                                @endif
                                @error('state_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- City --}}
                            {{-- <div class="{{ !$tourGuideType->city_id ? 'loading' : '' }}"> --}}
                            <div class="loading">
                                <label for="all_cities" class="kt-label required mb-2 flex items-center justify-between">
                                    <div class="flex items-center justify-between gap-1">
                                        <div class="flex items-center justify-between gap-1">
                                            <input type="hidden" name="all_cities" value="0">
                                            <input type="checkbox" name="all_cities" id="all_cities" class="kt-checkbox"
                                                style="width: 17px; height: 17px;" value="1"
                                                {{ $tourGuideType->all_cities == 1 ? 'checked' : '' }}>
                                            {{ __('main.all_types', ['types' => __('main.cities')]) }}
                                            <strong class="dataLength text-primary"></strong>
                                            <i id="city_id-loader"
                                                class="i-loader fas fa-refresh fa-spin text-primary"></i>
                                        </div>
                                        {{-- class="text-red-600 text-sm span-info {{ !$tourGuideType->city_id ? 'show' : '' }}" --}}
                                        <span class="text-red-600 text-sm span-info show" id="city_id-info">
                                            (You must select state first)
                                        </span>
                                    </div>

                                    <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="city_id[]" id="city_id" class="kt-select h-[45px]" special-multiple
                                    data-current-value="{{ $tourGuideType->city_id }}"
                                    value="{{ $tourGuideType->city_id }}">
                                    <option value="">--</option>
                                    {{-- Cities will be loaded dynamically based on selected state --}}
                                </select>
                                @if (!empty($tourGuideType->city_list))
                                    @foreach ($tourGuideType->city_list as $item)
                                        <input type="hidden" name="city_id[]" data-name="{{ $item['name'] }}"
                                            value="{{ $item['id'] }}">
                                    @endforeach
                                @endif
                                @error('city_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
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
            filterByForeignId("region_id", "subregion", "subregion_id", "edit");
            filterByForeignId("subregion_id", "country", "country_id", "edit");
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const getSelect = (id) => document.getElementById(id);
            const getInput = (key) => document.querySelector(`[data-for='${key}'] .tag-input`);

            const countrySelect = getSelect("country_id");
            const stateSelect = getSelect("state_id");
            const citySelect = getSelect("city_id");
            const allStates = getSelect("all_states");
            const allCities = getSelect("all_cities");

            // لو أي حاجة مش موجودة، متكملش
            if (!countrySelect || !stateSelect || !citySelect) return;

            // ✅ دالة تحميل البيانات
            const loadData = async (fromId, model, toId, value) => {
                const ref = filterByForeignId(fromId, model, toId);
                if (ref && typeof ref.loadReferenceData === "function") {
                    await ref.loadReferenceData(value);
                }
            };

            const getSelectedIds = (name) => {
                return [...document.querySelectorAll(`input[name='${name}']`)]
                    .map(input => input.value)
                    .filter(v => v !== "");
            };

            // ✅ منع التكرار (عشان الـ MutationObserver مش مستخدم دلوقتي)
            let isLoading = false;

            // ✅ عند اختيار الدولة
            countrySelect?.addEventListener("updatedSelect", async () => {
                if (isLoading) return;
                isLoading = true;

                const countryId = getInput("country_id")?.dataset.id;
                if (!countryId) {
                    stateSelect.innerHTML = '<option value="">--</option>';
                    citySelect.innerHTML = '<option value="">--</option>';
                    isLoading = false;
                    return;
                }

                // لو allStates متعلم عليها → هنعرض كل المدن بناءً على الدولة
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

            stateSelect?.addEventListener("updatedSelect", async () => {
                console.log("updatedSelect");

                if (isLoading) return;
                isLoading = true;
                await handleStateChange("updatedSelect");
                isLoading = false;
            });

            stateSelect?.addEventListener("multiSelectUpdated", async () => {
                console.log("multiSelectUpdated");

                if (isLoading) return;
                isLoading = true;
                await handleStateChange("multiSelectUpdated");
                isLoading = false;
            });

            allStates?.addEventListener("change", async () => {
                if (isLoading) return;
                isLoading = true;
                await handleStateChange("allStatesChange");
                isLoading = false;
            });

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

            async function handleStateChange(triggerType) {
                const stateIds = getSelectedIds("state_id[]");
                const countryId = getInput("country_id")?.dataset.id;

                await resetDependentTags("state_id", getInput("city_id"));

                // ✅ حالة "كل الولايات"
                if (allStates?.checked) {
                    stateSelect.disabled = true;
                    getSelect("state_id").nextElementSibling?.classList.add('loading');
                    await loadData("country_id", "city", "city_id", countryId);
                    return;
                }

                // ✅ الحالة العادية
                stateSelect.disabled = false;
                getSelect("state_id").nextElementSibling?.classList.remove('loading');
                if (!stateIds.length) {
                    citySelect.disabled = false;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.parentElement.classList.add('loading');
                    document.getElementById(`city_id-info`)?.classList.add("show");
                    const label = document
                        .getElementById("city_id")
                        ?.parentElement.querySelector(".dataLength");
                    if (label) label.innerText = '';
                    return;
                }

                // ✅ لو allCities متعلم عليها → نجيب كل المدن في الدولة
                if (allCities?.checked) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">--</option>';
                    getSelect("city_id")?.nextElementSibling.classList.add('loading');
                    return;
                }

                // ✅ تحميل المدن بناءً على الولاية
                citySelect.disabled = false;
                getSelect("city_id")?.nextElementSibling.classList.remove('loading');
                await loadData("state_id", "city", "city_id", stateIds);
            }
        });
    </script>
@endpush
