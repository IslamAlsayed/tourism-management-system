<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
    {{-- Region --}}
    <div class="align-self-end" wire:ignore>
        <label for="region_id" class="kt-label mb-2 flex items-center justify-between">
            {{ __('main.regions') }}
            <a href="{{ route('regions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="region_id" id="region_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($options['regions'] as $item)
                <option value="{{ $item->id }}"
                    {{ old('region_id', $record->region_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('region_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Subregion --}}
    <div class="align-self-end {{ !hasEmpty($filters['region']) ? 'disabled-option p-2 rounded-sm' : '' }}">
        <label for="subregion_id" class="kt-label mb-2 flex items-center justify-between">
            <div> {{ __('main.subregions') }}
                <strong class="dataLength text-primary">
                    ({{ count($options['subregions']) ?: 0 }})
                </strong>
                <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading
                    wire:target="filters.region,updatedFilters">
                </i>
                <span id="subregion_id-info"
                    class="text-red-600 text-sm span-info {{ !hasEmpty($filters['region']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.region')]) }})
                </span>
            </div>

            <a href="{{ route('subregions.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="subregion_id" id="subregion_id" class="kt-select basic-single"
            {{ !hasEmpty($filters['region']) ? 'disabled' : '' }}>
            <option value="" selected>--</option>
            @foreach ($options['subregions'] as $item)
                <option value="{{ $item->id }}"
                    {{ old('subregion_id', $record->subregion_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('subregion_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- country --}}
    <div class="align-self-end {{ !hasEmpty($filters['subregion']) ? 'disabled-option p-2 rounded-sm' : '' }}">
        <label for="country_id" class="kt-label mb-2 flex items-center justify-between">
            <div> {{ __('main.countries') }}
                <strong class="dataLength text-primary">
                    ({{ count($options['countries']) ?: 0 }})
                </strong>
                <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading
                    wire:target="filters.subregion,updatedFilters"></i>
                <span id="country_id-info"
                    class="text-red-600 text-sm span-info {{ !hasEmpty($filters['subregion']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.subregion')]) }})
                </span>
            </div>

            <a href="{{ route('countries.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="country_id" id="country_id" class="kt-select basic-single"
            {{ !hasEmpty($filters['subregion']) ? 'disabled' : '' }}>
            <option value="" selected>--</option>
            @foreach ($options['countries'] as $item)
                <option value="{{ $item->id }}"
                    {{ old('country_id', $record->country_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('country_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- State --}}
    <div class="align-self-end {{ !hasEmpty($filters['country']) ? 'disabled-option p-2 rounded-sm' : '' }}">
        <label for="state_id" class="kt-label mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && in_array('states', $multiple))
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
                    <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading
                        wire:target="filters.country,updatedFilters"></i>
                </div>
                <span id="state_id-info"
                    class="text-red-600 text-sm span-info {{ !hasEmpty($filters['country']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.country')]) }})
                </span>
            </div>
            <a href="{{ route('states.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="state_id{{ isset($multiple) && in_array('states', $multiple) ? '[]' : '' }}" id="state_id"
            class="kt-select {{ isset($multiple) && in_array('states', $multiple) ? 'basic-multiple' : 'basic-single' }}"
            {{ !hasEmpty($filters['country']) || ($record->all_states ?? 0) == 1 || ($record->all_states ?? 0) == true ? 'disabled' : '' }}
            {{ isset($multiple) && in_array('states', $multiple) ? 'multiple' : '' }}>
            @if (!isset($multiple) && !in_array('states', (array) $multiple))
                <option value="" selected>--</option>
            @endif
            @foreach ($options['states'] as $item)
                <option value="{{ $item->id }}"
                    {{ in_array($item->id, $selectedStates ?? []) ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
        @error('state_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            initSelect('region_id', 'filters.region');
            initSelect('subregion_id', 'filters.subregion');
            initSelect('country_id', 'filters.country');
            initSelect('state_id', 'filters.state');
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
                ['region_id', 'subregion_id', 'country_id', 'state_id'].forEach(id => {
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
    </script>
@endpush
