<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6 items-end">
    <!-- Route -->
    <div>
        <label for="route_id" class="kt-label required">
            {{ __('main.route') }}
            @if (!$record)
                <span class="text-red-600 text-2xl">*</span>
            @endif
        </label>
        <select name="route_id" id="route_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($routes as $route)
                <option value="{{ $route->id }}" {{ old('route_id', $record->route_id ?? null) == $route->id ? 'selected' : '' }}>
                    {{ $route->name }} ({{ $route->originCity->name }} → {{ $route->destinationCity->name }})
                </option>
            @endforeach
        </select>
        @error('route_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Currency -->
    @include('components.selects.currency')

    {{-- Transportation Company --}}
    <div wire:ignore>
        <label for="company_id" class="kt-label mb-2 flex items-center justify-between">
            <span>
                {{ __('main.companies') }}
                @if (!$record)
                    <span class="text-red-600 text-2xl">*</span>
                @endif
            </span>
            <a href="{{ route('dashboard.transportation.companies.create') }}" class="text-blue-600 text-2sm">
                {{ __('main.add') }}
            </a>
        </label>
        <select name="company_id" id="company_id" class="kt-select basic-single">
            <option value="" selected>--</option>
            @foreach ($options['companies'] as $item)
                <option value="{{ $item->id }}" {{ old('company_id', $record->company_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('company_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Transportation Vehicle Type --}}
    <div class="{{ !hasEmpty($filters['company']) ? 'disabled-option rounded-sm' : '' }}">
        <label for="vehicle_type_id" class="kt-label mb-2 flex items-center justify-between">
            <div>
                {{ __('main.vehicle-types') }}
                @if (!$record)
                    <span class="text-red-600 text-2xl">*</span>
                @endif
                <strong class="dataLength text-primary">
                    ({{ count($options['vehicle_types']) ?: 0 }})
                </strong>
                <i class="i-loader fas fa-refresh fa-spin text-primary" wire:loading wire:target="filters.company,updatedFilters">
                </i>
                <span id="vehicle_type_id-info" class="text-red-600 text-sm span-info {{ !hasEmpty($filters['company']) ? 'show' : '' }}">
                    ({{ __('main.select_type_first', ['type' => __('main.company')]) }})
                </span>
            </div>

            <a href="{{ route('dashboard.transportation.vehicle-types.create') }}" class="text-blue-600 text-2sm">{{ __('main.add') }}</a>
        </label>
        <select name="vehicle_type_id" id="vehicle_type_id" class="kt-select basic-single" {{ !hasEmpty($filters['company']) ? 'disabled' : '' }}>
            <option value="" selected>--</option>
            @foreach ($options['vehicle_types'] as $item)
                <option value="{{ $item->id }}" {{ old('vehicle_type_id', $record->vehicle_type_id ?? null) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        @error('vehicle_type_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            initSelect('company_id', 'filters.company');
            Livewire.on('select-options-updated', (e) => refreshAll());
        });

        function initSelect(id, model) {
            const $el = $('#' + id);
            if (!$el.hasClass('select2-hidden-accessible')) {
                $el.select2();
            }
            $el.on('change', () => @this.set(model, $el.val()));
        }

        function refreshAll() {
            $(document).ready(() => {
                ['company_id', 'vehicle_type_id'].forEach(id => {
                    const $el = $('#' + id);
                    if ($el.length) {
                        $el.select2();
                    }
                });
            });
        }
    </script>
@endpush
