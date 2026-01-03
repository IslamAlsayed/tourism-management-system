<div class="col-span-2">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {{-- Type --}}
        <div wire:ignore>
            <label class="kt-label mb-2">
                {{ __('main.type') }}
                @if (!$record)
                    <span class="text-red-600">*</span>
                @endif
            </label>

            <select wire:model="filterType" name="model_type" id="model_type" class="kt-select basic-single">
                @foreach ($types as $key => $type)
                    <option value="{{ $key }}">{{ __($type['label']) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Dynamic Select --}}
        <div>
            @if (isset($types[$filterType]))
                <label class="kt-label mb-2">
                    {{ __($types[$filterType]['label']) }}
                    @if (!$record)
                        <span class="text-red-600">*</span>
                    @endif
                    <strong class="text-primary">({{ count($models) }})</strong>
                </label>
            @endif

            <select name="model_id" id="model_id" class="kt-select basic-single">
                <option value="" disabled selected></option>
                @foreach ($models as $model)
                    <option value="{{ $model['id'] }}"
                        {{ old('model_id', optional($record)->model_id) == $model['id'] ? 'selected' : '' }}>
                        {{ $model['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            const $el = $('#model_type');
            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2();
            }
            $el.on('change', () => @this.set('filterType', $el.val()));

            Livewire.on('select-options-updated', (e) => {
                $(document).ready(function() {
                    ['model_id', 'model_type'].forEach(id => {
                        const $el = $('#' + id);
                        if ($el.length) {
                            $el.select2();
                        }
                    });
                });
            });
        });
    </script>
@endpush
