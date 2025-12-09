<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => $rateType === 'room' ? __('main.room_rates') : __('main.meal_rates'),
        'entityName' => $rateType === 'room' ? __('main.room_rate') : __('main.meal_rate'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,rateType">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="rateType" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.rates') }}">
                    <option value="room">{{ __('main.room_rates') }}</option>
                    <option value="meal">{{ __('main.meal_rates') }}</option>
                </select>
            </div>
        </div>

        <div data-kt-datatable-state-save="false" id="rates_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => $rateType === 'room' ? 'accommodations.rates.room' : 'accommodations.rates.meal',
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
