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
            <a href="{{ route('dashboard.geography.regions.create') }}"
                class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="region_id" id="region_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($options['regions'] as $item)
                <option value="{{ $item->id }}"
                    {{ old('region_id', $record->region_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}{{ $item->name_ar ? ' - ' . $item->name_ar : '' }}
                </option>
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
                <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading
                    wire:target="filters.region,updatedFilters">
                </i>
                <span id="subregion_id-info"
                    class="text-red-600 text-sm span-info {{ !hasEmpty($filters['region']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.region')]) }})
                </span>
            </div>

            <a href="{{ route('dashboard.geography.subregions.create') }}"
                class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="subregion_id" id="subregion_id" class="kt-select basic-single" {!! !hasEmpty($filters['region']) ? 'style="pointer-events:none;opacity:0.6;" tabindex="-1"' : '' !!}>
            <option value="" selected>--</option>
            @foreach ($options['subregions'] as $item)
                <option value="{{ $item->id }}"
                    {{ old('subregion_id', $record->subregion_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}{{ $item->name_ar ? ' - ' . $item->name_ar : '' }}
                </option>
            @endforeach
        </select>
        @error('subregion_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            initSelect('region_id', 'filters.region');
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
                ['region_id', 'subregion_id'].forEach(id => {
                    const $el = $('#' + id);
                    if ($el.length) {
                        $el.select2();
                    }
                });
            });
        }
    </script>
@endpush
