<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.meals'),
        'entityName' => __('main.meal'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterStatus,filterIsIncluded">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-3 gap-4 filterTable" wire:ignore>
            <div>
                <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="filterIsIncluded" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.is_included') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="yes">{{ __('main.included') }}</option>
                    <option value="no">{{ __('main.not_included') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            <div>
                <button type="button" wire:click="resetFilters" title="{{ __('main.reset_validate') }}" toggle-button
                    class="kt-btn kt-btn-outline bg-white px-3 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                </button>
            </div>
        </div>

        <div data-kt-datatable-state-save="false" id="meals_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'meals',
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
