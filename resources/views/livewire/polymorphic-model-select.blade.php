<div class="col-span-1">
    <div class="grid grid-cols-1 gap-6">
        {{-- Type --}}
        <div wire:ignore class="hidden {{ $record ? 'cursor-not-allowed' : '' }}">
            <label class="kt-label mb-2">
                {{ __('main.type') }}
                @if (!$record)
                    <span class="text-red-600">*</span>
                @else
                    <i class="fas fa-lock"></i>
                @endif
            </label>

            <select wire:model="filterType" name="model_type" id="model_type" class="kt-select basic-single" {{ $record ? 'disabled' : '' }}>
                @foreach ($types as $key => $type)
                    <option value="{{ $key }}" {{ Str::ucfirst($type['label']) == Str::ucfirst($filterType) ? 'selected' : '' }}>
                        {{ __('main.' . $type['label']) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Dynamic Select --}}
        <div>
            @if (isset($types[$filterType]))
                <label class="kt-label mb-2">
                    {{ __('main.' . $types[$filterType]['label']) }}
                    <strong class="text-primary">({{ count($models) }})</strong>
                    @if (!$record)
                        <span class="text-red-600">*</span>
                    @endif
                </label>
            @endif

            <select name="model_id" id="model_id" class="kt-select basic-single">
                <option value="" disabled selected></option>
                @foreach ($models as $model)
                    <option value="{{ $model['id'] }}" {{ old('model_id', optional($record)->model_id) == $model['id'] ? 'selected' : '' }}>
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
