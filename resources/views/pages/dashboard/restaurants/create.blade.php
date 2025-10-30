@extends('layouts.master')

@section('title', 'Create New Restaurant')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Create New Restaurant
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Add a new restaurant to the system
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                    Back to Restaurants
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            {{-- Accommodation Form --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Basic Information</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6 p-4" method="POST" action="{{ route('restaurants.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Restaurant Photo --}}
                        @include('components.input-image', [
                            'column' => 'restaurant',
                            'columnName' => 'photo',
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            {{-- Name --}}
                            <div class="">
                                <label for="name" class="kt-label required mb-2">Name (English)</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required>
                            </div>

                            {{-- Name Arabic --}}
                            <div class="">
                                <label for="name_ar" class="kt-label required mb-2">Name (Arabic)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required>
                            </div>

                            {{-- Type --}}
                            <div class="">
                                <label for="type" class="kt-label required mb-2 flex items-center justify-between">
                                    Type
                                    <a href="{{ route('types.create') }}" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="type_id" id="type_id" class="kt-select h-[45px]" special-search required>
                                    <option value="">--</option>
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])

                            {{-- Rating --}}
                            <div class="">
                                <label for="rating" class="kt-label required mb-2">Rating</label>
                                <select name="rating" id="rating" class="kt-select h-[45px]" special-search required>
                                    <option value="">--</option>
                                    @foreach (range(1, 5) as $item)
                                        <option value="{{ $item }}">
                                            {{ $item }} Star{{ $item > 1 ? 's' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Specialty --}}
                            <div class="">
                                <label for="specialty_id" class="kt-label required mb-2 flex items-center justify-between">
                                    Specialty
                                    {{-- <a href="{{ route('regions.create') }}" class="text-blue-600 text-2sm"> --}}
                                    <a href="#" class="text-blue-600 text-2sm">
                                        {{ __('main.add') }}
                                    </a>
                                </label>
                                <select name="specialty_id" id="specialty_id" class="kt-select h-[45px]" special-search
                                    required>
                                    <option value="">--</option>
                                    @foreach ($specialties ?? [] as $specialty)
                                        {{-- <option value="{{ $specialty->id }}">{{ $specialty->name }}</option> --}}
                                        <option value="">--</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Company Name (Arabic) --}}
                            <div class="">
                                <label for="company_name_ar" class="kt-label required mb-2">Company Name
                                    (Arabic)</label>
                                <input type="text" name="company_name_ar" id="company_name_ar" class="kt-input h-[45px]"
                                    required>
                            </div>

                            {{-- phone_01 --}}
                            <div class="">
                                <label for="phone_01" class="kt-label required mb-2">Phone 01</label>
                                <input type="text" name="phone_01" id="phone_01" class="kt-input h-[45px]" required>
                            </div>

                            {{-- phone_02 --}}
                            <div class="">
                                <label for="phone_02" class="kt-label required mb-2">Phone 02</label>
                                <input type="text" name="phone_02" id="phone_02" class="kt-input h-[45px]" required>
                            </div>

                            {{-- fax --}}
                            <div class="">
                                <label for="fax" class="kt-label required mb-2">Fax</label>
                                <input type="text" name="fax" id="fax" class="kt-input h-[45px]" required>
                            </div>

                            {{-- email_01 --}}
                            <div class="">
                                <label for="email_01" class="kt-label required mb-2">Email 1</label>
                                <input type="text" name="email_01" id="email_01" class="kt-input h-[45px]" required>
                            </div>

                            {{-- email_02 --}}
                            <div class="">
                                <label for="email_02" class="kt-label required mb-2">Email 2</label>
                                <input type="text" name="email_02" id="email_02" class="kt-input h-[45px]" required>
                            </div>

                            {{-- Contact Person --}}
                            <div class="">
                                <label for="contact_person" class="kt-label required mb-2">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person"
                                    class="kt-input h-[45px]" required>
                            </div>

                            {{-- Box --}}
                            <div class="">
                                <label for="box" class="kt-label required mb-2">Box</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]" required>
                            </div>

                            {{-- Postal Code --}}
                            <div class="">
                                <label for="postal_code" class="kt-label required mb-2">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    required>
                            </div>

                            {{-- Mobile --}}
                            <div class="">
                                <label for="mobile" class="kt-label required mb-2">Mobile</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]" required>
                            </div>

                            {{-- Website --}}
                            <div class="">
                                <label for="website" class="kt-label required mb-2">Website</label>
                                <input type="text" name="website" id="website" class="kt-input h-[45px]" required>
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="mb-4">
                            <label for="note" class="kt-label mb-2">Note</label>
                            <input id="note" type="hidden" name="note">
                            <trix-editor input="note"></trix-editor>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                    value="1">
                                <label for="is_active" class="kt-label mb-0">{{ __('main.is_active') }}</label>
                            </div>
                        </div>

                        {{-- Facilities --}}
                        <div class="mb-4">
                            <label class="kt-label mb-2">Facilities</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
                                    <input type="checkbox" name="wheelchair_accessible" id="wheelchair_accessible"
                                        class="kt-checkbox" value="1">
                                    <label for="wheelchair_accessible"
                                        class="kt-label mb-0">{{ __('main.wheelchair_accessible') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="free_wifi" value="0">
                                    <input type="checkbox" name="free_wifi" id="free_wifi" class="kt-checkbox"
                                        value="1">
                                    <label for="free_wifi" class="kt-label mb-0">{{ __('main.free_wifi') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="parking" value="0">
                                    <input type="checkbox" name="parking" id="parking" class="kt-checkbox"
                                        value="1">
                                    <label for="parking" class="kt-label mb-0">{{ __('main.parking') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="swimming_pool" value="0">
                                    <input type="checkbox" name="swimming_pool" id="swimming_pool" class="kt-checkbox"
                                        value="1">
                                    <label for="swimming_pool"
                                        class="kt-label mb-0">{{ __('main.swimming_pool') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="gym" value="0">
                                    <input type="checkbox" name="gym" id="gym" class="kt-checkbox"
                                        value="1">
                                    <label for="gym" class="kt-label mb-0">{{ __('main.gym') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="indoor" value="0">
                                    <input type="checkbox" name="indoor" id="indoor" class="kt-checkbox"
                                        value="1">
                                    <label for="indoor" class="kt-label mb-0">{{ __('main.indoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="outdoor" value="0">
                                    <input type="checkbox" name="outdoor" id="outdoor" class="kt-checkbox"
                                        value="1">
                                    <label for="outdoor" class="kt-label mb-0">{{ __('main.outdoor') }}</label>
                                </div>
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="spa" value="0">
                                    <input type="checkbox" name="spa" id="spa" class="kt-checkbox"
                                        value="1">
                                    <label for="spa" class="kt-label mb-0">{{ __('main.spa') }}</label>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                Create Restaurant
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                Save and Add Another
                            </button>
                            <a href="{{ route('restaurants.index') }}" class="kt-btn kt-btn-outline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tips --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">Restaurant Tips</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Complete Information</div>
                                <div class="text-sm text-secondary-foreground">
                                    Provide detailed information to help guests make informed decisions
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">High Quality Photos</div>
                                <div class="text-sm text-secondary-foreground">
                                    Upload clear, high-resolution photos of your restaurant
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-star text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Accurate Rating</div>
                                <div class="text-sm text-secondary-foreground">
                                    Select the appropriate star rating based on your facilities and services
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
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
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

                if (allStates && allStates?.checked) {
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

                    if (allStates && allStates?.checked) {
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
