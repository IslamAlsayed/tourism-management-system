<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

    {{-- Entity --}}
    <div>
        <label class="kt-label mb-2">
            {{ $label }}
            <span class="text-red-600">*</span>
        </label>

        <select id="entity_id" wire:model="filterEntityId" class="kt-select basic-single">
            <option value="" disabled selected>--</option>

            @foreach ($entities as $entity)
                <option value="{{ $entity->id }}">
                    {{ $entity->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Season --}}
    <div>
        <label class="kt-label mb-2 flex justify-between">
            <span>
                {{ __('main.seasons') }}
                ({{ count($seasons) }})
            </span>

            @if ($isLoading)
                <i class="fas fa-refresh fa-spin text-primary"></i>
            @endif
        </label>

        <select name="season_id" id="season_id" class="kt-select basic-single">

            @if ($isEntitySelected)
                <option value="0">{{ __('main.all') }}</option>
            @else
                <option disabled selected>--</option>
            @endif

            @foreach ($seasons as $season)
                <option value="{{ $season->id }}">
                    {{ $season->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            const $el = $('#entity_id');
            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2();
            }
            $el.on('change', () => @this.set('filterEntityId', $el.val()));

            Livewire.on('select-options-updated', (e) => {
                $(document).ready(function() {
                    ['entity_id', 'season_id'].forEach(id => {
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
