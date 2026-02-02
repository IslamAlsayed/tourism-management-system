<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
    {{-- Country --}}
    <div class="align-self-end" wire:ignore>
        <label for="country_id" class="kt-label mb-2">
            {{ __('main.countries') }}
            <strong class="dataLength text-primary">
                ({{ count($options['countries']) ?: 0 }})
            </strong>
        </label>
        <select name="country_id" id="country_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($options['countries'] as $item)
                <option value="{{ $item->id }}" {{ old('country_id', $record->country_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('country_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- City --}}
    <div class="align-self-end {{ !hasEmpty($filters['country']) ? 'disabled-option rounded-sm' : '' }}">
        <label for="city_id" class="kt-label mb-2 flex items-center justify-between">
            <div class="flex items-center justify-between gap-1">
                <div class="flex items-center justify-between gap-1">
                    @if (isset($multiple) && in_array('cities', $multiple) && false)
                        <input type="hidden" name="all_cities" value="0">
                        <div class="custom-input" wire:ignore>
                            <input type="checkbox" name="all_cities" id="all_cities" value="1"
                                {{ ($record->all_cities ?? 0) == 1 || ($record->all_cities ?? 0) == true ? 'checked' : '' }} data-kt-datatable-row-check="true">
                            <label for="all_cities">{{ __('main.cities') }}</label>
                        </div>
                    @else
                        {{ __('main.cities') }}
                    @endif

                    <strong class="dataLength text-primary">
                        ({{ count($options['cities']) ?: 0 }})
                    </strong>
                    <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading wire:target="filters.country,updatedFilters"></i>
                </div>
                <span id="city_id-info" class="text-red-600 text-sm span-info {{ !hasEmpty($filters['country']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.country')]) }})
                </span>
            </div>
            <a href="{{ route('cities.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="city_id{{ isset($multiple) && in_array('cities', $multiple) ? '[]' : '' }}" id="city_id"
            class="kt-select {{ isset($multiple) && in_array('cities', $multiple) ? 'basic-multiple' : 'basic-single' }}"
            {{ !hasEmpty($filters['country']) || ($record->all_cities ?? 0) == 1 || ($record->all_cities ?? 0) == true ? 'disabled' : '' }}
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
            initSelect('country_id', 'filters.country');
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
                ['country_id', 'city_id'].forEach(id => {
                    const $el = $('#' + id);
                    if ($el.length) {
                        $el.select2();
                    }
                });
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
