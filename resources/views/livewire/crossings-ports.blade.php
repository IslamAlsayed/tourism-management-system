<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.crossings-ports'),
        'entityName' => __('main.crossing-port'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
            ])
        @endif
    @endcomponent

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,filterType,filterStatus,filterOperational,resetFilter">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterType" id="type" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.type') }}">
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
                <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="">--</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="under_construction">{{ __('main.under_construction') }}</option>
                    <option value="maintenance">{{ __('main.maintenance') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="filterOperational" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.operational') }}">
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

        <div data-kt-datatable-state-save="false" id="crossings-ports_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'crossings-ports',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent
            </div>

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>
