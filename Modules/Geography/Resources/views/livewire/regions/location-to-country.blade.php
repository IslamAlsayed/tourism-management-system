<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
    {{-- Region --}}
    <div class="align-self-end" wire:ignore>
        <label for="region_id" class="kt-label mb-2 flex items-center justify-between">
            <div>
                {{ __('main.regions') }}
                <strong class="dataLength text-primary">
                    ({{ count($options['regions']) ?: 0 }})
                </strong>
            </div>
            <a href="{{ route('dashboard.geography.regions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="region_id" id="region_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($options['regions'] as $item)
                <option value="{{ $item->id }}" {{ old('region_id', $record->region_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('region_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Subregion --}}
    <div class="align-self-end {{ !hasEmpty($filters['region']) ? 'disabled-option rounded-sm' : '' }}">
        <label for="subregion_id" class="kt-label mb-2 flex items-center justify-between">
            <div> {{ __('main.subregions') }}
                <strong class="dataLength text-primary">
                    ({{ count($options['subregions']) ?: 0 }})
                </strong>
                <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading wire:target="filters.region,updatedFilters">
                </i>
                <span id="subregion_id-info" class="text-red-600 text-sm span-info {{ !hasEmpty($filters['region']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.region')]) }})
                </span>
            </div>

            <a href="{{ route('dashboard.geography.subregions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="subregion_id" id="subregion_id" class="kt-select basic-single" {{ !hasEmpty($filters['region']) ? 'disabled' : '' }}>
            <option value="" selected>--</option>
            @foreach ($options['subregions'] as $item)
                <option value="{{ $item->id }}" {{ old('subregion_id', $record->subregion_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('subregion_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- State --}}
    <div class="align-self-end {{ !hasEmpty($filters['subregion']) ? 'disabled-option rounded-sm' : '' }}">
        <label for="state_id" class="kt-label mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && in_array('states', $multiple) && false)
                        <input type="hidden" name="all_states" value="0">
                        <div class="custom-input" wire:ignore>
                            <input type="checkbox" name="all_states" id="all_states" value="1"
                                {{ ($record->all_states ?? 0) == 1 || ($record->all_states ?? 0) == true ? 'checked' : '' }}
                                data-kt-datatable-row-check="true">
                            <label for="all_states">{{ __('main.states') }}</label>
                        </div>
                    @else
                        {{ __('main.states') }}
                    @endif

                    <strong class="dataLength text-primary">
                        ({{ count($options['states']) ?: 0 }})
                    </strong>
                    <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading wire:target="filters.subregion,updatedFilters"></i>
                </div>
                <span id="state_id-info" class="text-red-600 text-sm span-info {{ !hasEmpty($filters['subregion']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.subregion')]) }})
                </span>
            </div>
            <a href="{{ route('dashboard.geography.states.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="state_id{{ isset($multiple) && in_array('states', $multiple) ? '[]' : '' }}" id="state_id"
            class="kt-select {{ isset($multiple) && in_array('states', $multiple) ? 'basic-multiple' : 'basic-single' }}"
            {{ !hasEmpty($filters['subregion']) || ($record->all_states ?? 0) == 1 || ($record->all_states ?? 0) == true ? 'disabled' : '' }}
            {{ isset($multiple) && in_array('states', $multiple) ? 'multiple' : '' }}>
            @if (!isset($multiple) && !in_array('states', (array) $multiple))
                <option value="" selected>--</option>
            @endif
            @foreach ($options['states'] as $item)
                <option value="{{ $item->id }}" {{ in_array($item->id, $selectedStates ?? []) ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
        @error('state_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- City --}}
    <div class="align-self-end {{ !hasEmpty($filters['state']) ? 'disabled-option rounded-sm' : '' }}">
        <label for="city_id" class="kt-label mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && in_array('cities', $multiple) && false)
                        <input type="hidden" name="all_cities" value="0">
                        <div class="custom-input" wire:ignore>
                            <input type="checkbox" name="all_cities" id="all_cities" value="1"
                                {{ ($record->all_cities ?? 0) == 1 || ($record->all_cities ?? 0) == true ? 'checked' : '' }}
                                data-kt-datatable-row-check="true">
                            <label for="all_cities">{{ __('main.cities') }}</label>
                        </div>
                    @else
                        {{ __('main.cities') }}
                    @endif

                    <strong class="dataLength text-primary">
                        ({{ count($options['cities']) ?: 0 }})
                    </strong>
                    <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading wire:target="filters.state,updatedFilters"></i>
                </div>
                <span id="city_id-info" class="text-red-600 text-sm span-info {{ !hasEmpty($filters['state']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.state')]) }})
                </span>
            </div>
            <a href="{{ route('dashboard.geography.cities.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="city_id{{ isset($multiple) && in_array('cities', $multiple) ? '[]' : '' }}" id="city_id"
            class="kt-select {{ isset($multiple) && in_array('cities', $multiple) ? 'basic-multiple' : 'basic-single' }}"
            {{ !hasEmpty($filters['state']) || ($record->all_cities ?? 0) == 1 || ($record->all_cities ?? 0) == true ? 'disabled' : '' }}
            {{ isset($multiple) && in_array('cities', $multiple) ? 'multiple' : '' }}>
            @if (!isset($multiple) && !in_array('cities', (array) $multiple))
                <option value="" selected>--</option>
            @endif
            @foreach ($options['cities'] as $item)
                <option value="{{ $item->id }}" {{ in_array($item->id, $selectedCities ?? []) ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
        @error('city_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            initSelect('region_id', 'filters.region');
            initSelect('subregion_id', 'filters.subregion');
            initSelect('state_id', 'filters.state');
            initSelect('city_id', 'filters.city');
            Livewire.on('select-options-updated', (e) => {
                refreshAll();
            });
        });

        function initSelect(id, model) {
            const $el = $('#' + id);
            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2();
            }
            $el.on('change', () => @this.set(model, $el.val()));
        }

        function refreshAll() {
            $(document).ready(function() {
                ['region_id', 'subregion_id', 'state_id', 'city_id'].forEach(id => {
                    const $el = $('#' + id);
                    if ($el.length) {
                        $el.select2();
                    }
                });
            });
        }

        let all_states = document.getElementById('all_states');
        if (all_states) {
            all_states.addEventListener('change', function() {
                let stateSelect = document.getElementById('state_id');
                if (this.checked) {
                    stateSelect.setAttribute('disabled', 'disabled');
                    stateSelect.style.display = 'none';
                } else {
                    stateSelect.removeAttribute('disabled');
                    stateSelect.style.display = 'block';
                }
            });
        }

        let all_cities = document.getElementById('all_cities');
        if (all_cities) {
            all_cities.addEventListener('change', function() {
                let citySelect = document.getElementById('city_id');
                if (this.checked) {
                    citySelect.setAttribute('disabled', 'disabled');
                    citySelect.style.display = 'none';
                } else {
                    citySelect.removeAttribute('disabled');
                    citySelect.style.display = 'block';
                }
            });
        }
    </script>
@endpush
