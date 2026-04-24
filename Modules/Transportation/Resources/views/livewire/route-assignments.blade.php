<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.transportations-route-assignments'),
        'entityName' => __('main.transportations-route-assignment'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,filterDay">
        <!-- Filters -->
        <div class="mb-4 px-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterDay" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.day') }}">
                    @foreach (config('helpers.daysMap') as $dayKey => $dayValue)
                        <option value="{{ $dayKey }}">{{ $dayValue }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            @include('components.elements.reset-button')
        </div>

        <div data-kt-datatable-state-save="false" id="transportation_route_assignments_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.transportation.route-assignments',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent
        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>
