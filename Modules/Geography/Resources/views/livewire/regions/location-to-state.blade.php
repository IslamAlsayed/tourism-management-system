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
                {{ $item->name }}{{ $item->name_ar ? ' - ' . $item->name_ar : '' }}
            </option>
        @endforeach
    </select>
    @error('country_id')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
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
    </script>
@endpush
