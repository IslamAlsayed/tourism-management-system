<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.air-transports'),
        'entityName' => __('main.air-transport'),
        'sortField' => $sortField,
        'searchValue' => $search,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content">
        <!-- Filters -->
        <div class="mb-4 ps-4 filterTable" wire:target="search" wire:loading.class="loading">
            <div>
                <label for="type" style="font-size: 14px;">{{ __('main.type') }}</label>
                <select wire:model.live="filterType" id="type" class="kt-input h-[40px] w-48 max-w-full">
                    <option value="">--</option>
                    <option value="airline">{{ __('main.airline') }}</option>
                    <option value="charter_company">{{ __('main.charter_company') }}</option>
                    <option value="cargo_airline">{{ __('main.cargo_airline') }}</option>
                    <option value="aircraft_operator">{{ __('main.aircraft_operator') }}</option>
                    <option value="aircraft_manufacturer">{{ __('main.aircraft_manufacturer') }}</option>
                </select>
            </div>

            <div>
                <label for="service_type" style="font-size: 14px;">{{ __('main.service_type') }}</label>
                <select wire:model.live="filterServiceType" id="service_type" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="scheduled">{{ __('main.scheduled') }}</option>
                    <option value="charter">{{ __('main.charter') }}</option>
                    <option value="cargo">{{ __('main.cargo') }}</option>
                    <option value="mixed">{{ __('main.mixed') }}</option>
                    <option value="private">{{ __('main.private') }}</option>
                </select>
            </div>

            <div>
                <label for="status" style="font-size: 14px;">{{ __('main.status') }}</label>
                <select wire:model.live="filterStatus" id="status" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="suspended">{{ __('main.suspended') }}</option>
                    <option value="bankruptcy">{{ __('main.bankruptcy') }}</option>
                </select>
            </div>

            <div>
                <label for="active" style="font-size: 14px;">{{ __('main.active') }}</label>
                <select wire:model.live="filterActive" id="active" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="1">{{ __('main.yes') }}</option>
                    <option value="0">{{ __('main.no') }}</option>
                </select>
            </div>

            <div>
                <label for="international" style="font-size: 14px;">{{ __('main.international') }}</label>
                <select wire:model.live="filterInternational" id="international" class="kt-input h-[40px] w-48">
                    <option value="">--</option>
                    <option value="1">{{ __('main.yes') }}</option>
                    <option value="0">{{ __('main.no') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            @if ($filterType || $filterServiceType || $filterStatus || $filterActive || $filterInternational)
                <div>
                    <button type="button" wire:click="resetFilter" title="{{ __('main.reset_validate') }}"
                        toggle-button class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                        <span class="text-sm">{{ __('main.reset_sort') }}</span>
                    </button>
                </div>
            @endif
        </div>

        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="air-transports_table">
            <div class="kt-scrollable-x-auto"
                wire:target="search,filterType,filterServiceType,filterStatus,filterActive,filterInternational,resetFilter"
                wire:loading.class="loading">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'air-transports',
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
            let filterTables = document.querySelectorAll('.filterTable');
            filterTables.forEach(table => {
                let selects = table.querySelectorAll('select');
                selects.forEach(select => select.value = '');
            });
        });
    </script>
@endpush
