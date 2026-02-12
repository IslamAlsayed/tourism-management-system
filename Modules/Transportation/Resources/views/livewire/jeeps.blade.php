<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.jeeps'),
        'entityName' => __('main.jeep'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        <div class="d-flex gap-2">
            @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
                @include('components.columns', [
                    'allColumns' => $allColumns ?? [],
                    'selectedIds' => $selectedIds ?? [],
                ])
            @endif
        </div>
    @endcomponent

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,refreshData">
        <div data-kt-datatable-state-save="false" id="jeeps_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.transportation.jeeps',
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
