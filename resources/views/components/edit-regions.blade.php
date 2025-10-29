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
            <option value="{{ $region->id }}" {{ $record->region_id == $region->id ? 'selected' : '' }}>
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
            <i id="subregion_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
            <span class="text-red-600 text-sm span-info show" id="subregion_id-info">
                ({{ __('main.select_type_first', ['type' => __('main.region')]) }})
            </span>
        </div>
        <a href="{{ route('subregions.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="subregion_id" id="subregion_id" class="kt-select h-[45px]" special-search
        data-current-value="{{ $record->subregion_id }}" value="{{ $record->subregion_id }}">
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
                ({{ __('main.select_type_first', ['type' => __('main.subregion')]) }})
            </span>
        </div>
        <a href="{{ route('countries.create') }}" class="text-blue-600 text-2sm">
            {{ __('main.add') }}
        </a>
    </label>
    <select name="country_id" id="country_id" class="kt-select h-[45px]" special-search
        data-current-value="{{ $record->country_id }}" value="{{ $record->country_id }}">
        <option value="">--</option>
        {{-- Countries will be loaded dynamically based on selected subregion --}}
    </select>
    @error('country_id')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

{{-- State --}}
<div class="loading">
    @if (isset($options) && $options['allStates'])
        <label for="all_states" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    <input type="hidden" name="all_states" value="0">
                    <input type="checkbox" name="all_states" id="all_states" class="kt-checkbox"
                        style="width: 17px; height: 17px;" value="1"
                        {{ $record->all_states == 1 ? 'checked' : '' }}>
                    {{ __('main.all_types', ['types' => __('main.states')]) }}
                    <strong class="dataLength text-primary"></strong>
                    <i id="state_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                </div>
                <span class="text-red-600 text-sm span-info show" id="state_id-info">
                    ({{ __('main.select_type_first', ['type' => __('main.country')]) }})
                </span>
            </div>
            <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">
                {{ __('main.add') }}
            </a>
        </label>
    @else
        <label for="state_id" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
                {{ __('main.state') }}
                <strong class="dataLength text-primary"></strong>
                <i id="state_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
            </div>
            <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">
                {{ __('main.add') }}
            </a>
        </label>
    @endif
    <select name="{{ isset($options) && $options['allStates'] ? 'state_id[]' : 'state_id' }}" id="state_id"
        class="kt-select h-[45px]"
        {{ isset($options) && $options['allStates'] ? 'special-multiple' : 'special-search' }}
        data-current-value="{{ $record->state_id }}" value="{{ $record->state_id }}">
        <option value="">--</option>
        {{-- States will be loaded dynamically based on selected country --}}
    </select>
    @if (isset($options) && $options['allStates'])
        @if (!empty($record->state_list))
            @foreach ($record->state_list as $item)
                <input type="hidden" name="{{ isset($options) && $options['allStates'] ? 'state_id[]' : 'state_id' }}"
                    data-name="{{ $item['name'] }}" value="{{ $item['id'] }}">
            @endforeach
        @endif
    @endif
    @error('state_id')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

{{-- City --}}
<div class="loading">
    @if (isset($options) && $options['allCities'])
        <label for="all_cities" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    <input type="hidden" name="all_cities" value="0">
                    <input type="checkbox" name="all_cities" id="all_cities" class="kt-checkbox"
                        style="width: 17px; height: 17px;" value="1"
                        {{ $record->all_cities == 1 ? 'checked' : '' }}>
                    {{ __('main.all_types', ['types' => __('main.cities')]) }}
                    <strong class="dataLength text-primary"></strong>
                    <i id="city_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
                </div>
                <span class="text-red-600 text-sm span-info show" id="city_id-info">
                    ({{ __('main.select_type_first', ['type' => __('main.state')]) }})
                </span>
            </div>
            <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">
                {{ __('main.add') }}
            </a>
        </label>
    @else
        <label for="city_id" class="kt-label required mb-2 flex items-center justify-between">
            <div class="flex items-center gap-2">
                {{ __('main.city') }}
                <strong class="dataLength text-primary"></strong>
                <i id="city_id-loader" class="i-loader fas fa-refresh fa-spin text-primary"></i>
            </div>
            <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">
                {{ __('main.add') }}
            </a>
        </label>
    @endif
    <select name="{{ isset($options) && $options['allCities'] ? 'city_id[]' : 'city_id' }}" id="city_id"
        class="kt-select h-[45px]"
        {{ isset($options) && $options['allCities'] ? 'special-multiple' : 'special-search' }}
        data-current-value="{{ $record->city_id }}" value="{{ $record->city_id }}">
        <option value="">--</option>
        {{-- Cities will be loaded dynamically based on selected country --}}
    </select>
    @if (isset($options) && $options['allCities'])
        @if (!empty($record->city_list))
            @foreach ($record->city_list as $item)
                <input type="hidden" name="{{ isset($options) && $options['allCities'] ? 'city_id[]' : 'city_id' }}"
                    data-name="{{ $item['name'] }}" value="{{ $item['id'] }}">
            @endforeach
        @endif
    @endif
    @error('city_id')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

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

            const loadData = async (fromId, model, toId, value) => {
                const ref = filterByForeignId(fromId, model, toId);
                if (ref && typeof ref.loadReferenceData === "function") {
                    await ref.loadReferenceData(value);
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

            // ========================================
            // STATE MANAGEMENT
            // ========================================
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
                if (isLoading) return;
                isLoading = true;
                await handleStateChange("updatedSelect");
                isLoading = false;
            });

            stateSelect?.addEventListener("multiSelectUpdated", async () => {
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
                    const stateIds = getSelectedIds("state_id[]");
                    if (stateId) await loadData("state_id", "city", "city_id", stateIds);
                }
            });
        });
    </script>
@endpush
