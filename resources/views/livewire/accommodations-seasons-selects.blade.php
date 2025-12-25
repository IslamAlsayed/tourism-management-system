<div class="col-span-2">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 items-end gap-6">
        {{-- Accommodation --}}
        <div class="align-self-end">
            <label for="accommodation_id" class="kt-label mb-2">
                {{ __('main.accommodation') }}
                <span class="text-red-600 text-2xl">*</span>
            </label>
            <select name="accommodation_id" id="accommodation_id" class="kt-select basic-single"
                wire:model="filterAccommodationId">
                <option value="" selected disabled>--</option>
                @foreach ($accommodations as $accommodation)
                    <option value="{{ $accommodation->id }}"
                        {{ old('accommodation_id', $record?->accommodation_id) == $accommodation->id ? 'selected' : '' }}>
                        {{ $accommodation->name }}
                    </option>
                @endforeach
            </select>
            @error('accommodation_id')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Season --}}
        <div class="align-self-end">
            <label for="season_id" class="kt-label mb-2 flex items-center justify-between">
                <div> {{ __('main.seasons') }}
                    <strong class="dataLength text-primary">
                        ({{ isset($seasons) && count($seasons) ? count($seasons) : 0 }})
                    </strong>
                    <i id="season_id-loader"
                        class="i-loader fas fa-refresh fa-spin text-primary {{ $isLoading ? 'show' : '' }}"></i>
                    <span id="season_id-info"
                        class="text-red-600 text-sm span-info {{ !$isAccommodation && !$isLoading ? 'show' : '' }}">
                        ({{ __('main.select_type_first', ['type' => __('main.accommodation')]) }})
                    </span>
                </div>
            </label>
            <select name="season_id" id="season_id" class="kt-select basic-single"
                wire:key="season-select-{{ $filterAccommodationId }}" @disabled(!$isAccommodation)>
                @if ($isAccommodation)
                    <option value="0">{{ __('main.all') }}</option>
                @else
                    <option value="" selected disabled>--</option>
                @endif
                @foreach ($seasons as $season)
                    <option value="{{ $season->id }}"
                        {{ old('season_id', $record?->season_id) == $season->id ? 'selected' : '' }}>
                        {{ $season->name }}
                    </option>
                @endforeach
            </select>
            @error('season_id')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            $('#accommodation_id').on('change', function(e) {
                @this.set('filterAccommodationId', $(this).val());
            });
        });
    </script>
@endpush
