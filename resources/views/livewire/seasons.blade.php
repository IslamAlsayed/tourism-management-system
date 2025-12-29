<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.seasons'),
        'entityName' => __('main.season'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterStatus,filterAccommodationId,filterSeasons">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterAccommodationId" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($accommodationsForSeasons as $accommodation)
                        <option value="{{ $accommodation->id }}">{{ $accommodation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Reset Button --}}
            @include('components.elements.reset-button')
        </div>

        <div data-kt-datatable-state-save="false" id="seasons_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'seasons',
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
