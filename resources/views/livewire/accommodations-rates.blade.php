<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => $filter == 'roomRate' ? __('main.room_rates') : __('main.meal_rates'),
        'entityName' => $filter == 'roomRate' ? __('main.room_rate') : __('main.meal_rate'),
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

    <div class="kt-card-content px-2" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,setFilter">
        <!-- Filters -->
        <div class="flex flex-wrap gap-2 mb-6 px-2 filterTable">
            <button wire:click="setFilter('roomRate')"
                class="kt-btn btn-sm {{ $filter == 'roomRate' ? 'bg-gray-300 text-black user-select-none' : 'bg-primary' }}"
                toggle-button style="user-select: none">
                {{ __('main.room_rates') }} ({{ $roomRatesCount }})
            </button>
            <button wire:click="setFilter('mealRate')"
                class="kt-btn btn-sm {{ $filter == 'mealRate' ? 'bg-gray-300 text-black user-select-none' : 'bg-primary' }}"
                toggle-button style="user-select: none">
                {{ __('main.meal_rates') }} ({{ $mealRatesCount }})
            </button>
        </div>

        <div data-kt-datatable-state-save="false" id="rates_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => $filter == 'roomRate' ? 'accommodations-rates.room' : 'accommodations-rates.meal',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent
            </div>

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>
