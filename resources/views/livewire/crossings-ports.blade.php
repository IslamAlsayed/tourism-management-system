<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.crossings-ports'),
        'entityName' => __('main.crossing-port'),
        'sortField' => $sortField,
        'searchValue' => $search,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content">
        {{-- @if (!empty($search) && isset($data) && !empty($data) && $data->count() > 0) --}}
        <!-- Filters -->
        <div class="mb-4 ps-4" id="filterCrossingPorts" wire:target="search" wire:loading.class="loading">
            <div>
                <label for="type" style="font-size: 14px;">{{ __('main.type') }}</label>
                <select wire:model.live="filterType" id="type" class="kt-input h-[40px] w-48 max-w-full">
                    <option value="">--</option>
                    <option value="land_crossing">{{ __('main.land_crossing') }}</option>
                    <option value="international_airport">{{ __('main.international_airport') }}</option>
                    <option value="domestic_airport">{{ __('main.domestic_airport') }}</option>
                    <option value="seaport">{{ __('main.seaport') }}</option>
                    <option value="river_port">{{ __('main.river_port') }}</option>
                    <option value="border_crossing">{{ __('main.border_crossing') }}</option>
                </select>
            </div>

            <div>
                <label for="status" style="font-size: 14px;">{{ __('main.status') }}</label>
                <select wire:model.live="filterStatus" id="status" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="under_construction">{{ __('main.under_construction') }}</option>
                    <option value="maintenance">{{ __('main.maintenance') }}</option>
                </select>
            </div>

            <div>
                <label for="operational" style="font-size: 14px;">{{ __('main.operational') }}</label>
                <select wire:model.live="filterOperational" id="operational" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="1">{{ __('main.yes') }}</option>
                    <option value="0">{{ __('main.no') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            @if ($filterType || $filterStatus || $filterOperational)
                <div>
                    <button type="button" wire:click="resetFilter" title="{{ __('main.reset_validate') }}"
                        toggle-button class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                        <span class="text-sm">{{ __('main.reset_sort') }}</span>
                    </button>
                </div>
            @endif
        </div>
        {{-- @endif --}}

        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="crossings-ports_table">
            <div class="kt-scrollable-x-auto" wire:target="search,filterType,filterStatus,filterOperational,resetFilter"
                wire:loading.class="loading">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'crossings-ports',
                ])
                @endcomponent
            </div>

            @if (isset($data) && !empty($data) && $data->count() > 0)
                {{-- Enhanced Pagination Controls --}}
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('reset-filters', () => {
            const filterCrossingPorts = document.getElementById('filterCrossingPorts');
            const selects = filterCrossingPorts.querySelectorAll('select');
            selects.forEach(select => select.value = '');
        });
    </script>
@endpush
