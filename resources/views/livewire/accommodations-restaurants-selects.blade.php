<div class="col-span-2">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 items-end gap-6">
        {{-- Type --}}
        <div class="align-self-end">
            <label for="model_type" class="kt-label mb-2">
                {{ __('main.type') }}
                <span class="text-red-600 text-2xl">*</span>
            </label>
            <select name="model_type" id="model_type" class="kt-select basic-single" wire:model="filterType">
                <option value="accommodation" {{ old('type') == 'accommodation' ? 'selected' : '' }}>
                    {{ __('main.accommodation') }}
                </option>
                <option value="restaurant" {{ old('type') == 'restaurant' ? 'selected' : '' }}>
                    {{ __('main.restaurant') }}
                </option>
            </select>
            @error('type')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Accommodation --}}
        <div class="align-self-end {{ $filterType == 'accommodation' ? '' : 'hidden' }}">
            <label for="model_id" class="kt-label mb-2">
                {{ __('main.accommodation') }}
                <span class="text-red-600 text-2xl">*</span>
                <strong class="dataLength text-primary">
                    ({{ isset($accommodations) && count($accommodations) ? count($accommodations) : 0 }})
                </strong>
            </label>
            <select name="model_id" id="model_id" class="kt-select basic-single">
                @if (!isset($record) && !$record)
                    <option value="" selected disabled></option>
                @endif
                @foreach ($accommodations as $accommodation)
                    <option value="{{ $accommodation->id }}"
                        {{ old('model_id', $record && $record->model_id ? $record->model_id : '') == $accommodation->id ? 'selected' : '' }}>
                        {{ $accommodation->name }}
                    </option>
                @endforeach
            </select>
            @error('model_id')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Restaurant --}}
        <div class="align-self-end {{ $filterType == 'restaurant' ? '' : 'hidden' }}">
            <label for="model_id" class="kt-label mb-2">
                {{ __('main.restaurant') }}
                <span class="text-red-600 text-2xl">*</span>
                <strong class="dataLength text-primary">
                    ({{ isset($restaurants) && count($restaurants) ? count($restaurants) : 0 }})
                </strong>
            </label>
            <select name="model_id" id="model_id" class="kt-select basic-single">
                @if (!isset($record) && !$record)
                    <option value="" selected disabled></option>
                @endif
                @foreach ($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}"
                        {{ old('model_id', $record && $record->model_id ? $record->model_id : '') == $restaurant->id ? 'selected' : '' }}>
                        {{ $restaurant->name }}
                    </option>
                @endforeach
            </select>
            @error('model_id')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            $('#type').on('change', function(e) {
                @this.set('filterType', $(this).val());
            });
        });
    </script>
@endpush
