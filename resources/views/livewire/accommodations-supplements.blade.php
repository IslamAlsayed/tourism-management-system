<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.accommodations-supplements'),
        'entityName' => __('main.accommodation-supplement'),
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

    <div class="kt-card-content">
        <div class="kt-card-content" wire:loading.class="loading"
            wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterPerPerson,filterMandatory,filterStatus">
            <!-- Filters -->
            <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 px-4 filterTable" wire:ignore>
                <div>
                    <label for="is_per_person" class="text-sm">{{ __('main.is_per_person') }}</label>
                    <select wire:model.live="filterPerPerson" class="kt-select h-[40px] w-48 max-w-full"
                        id="is_per_person" data-kt-select="true"
                        data-kt-select-placeholder="{{ __('main.is_per_person') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="yes">{{ __('main.yes') }}</option>
                        <option value="no">{{ __('main.no') }}</option>
                    </select>
                </div>
                <div>
                    <label for="is_mandatory" class="text-sm">{{ __('main.is_mandatory') }}</label>
                    <select wire:model.live="filterMandatory" class="kt-select h-[40px] w-48 max-w-full"
                        id="is_mandatory" data-kt-select="true"
                        data-kt-select-placeholder="{{ __('main.is_mandatory') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="yes">{{ __('main.yes') }}</option>
                        <option value="no">{{ __('main.no') }}</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="text-sm">{{ __('main.status') }}</label>
                    <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full" id="status"
                        data-kt-select="true" data-kt-select-placeholder="{{ __('main.status') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="active">{{ __('main.active') }}</option>
                        <option value="inactive">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                {{-- Reset Filters Button --}}
                @if ($filterPerPerson || $filterMandatory || $filterStatus)
                    <div>
                        <button type="button" wire:click="resetFilters" title="{{ __('main.reset_validate') }}"
                            toggle-button
                            class="kt-btn kt-btn-outline bg-white px-3 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                            <span class="text-sm">{{ __('main.reset_sort') }}</span>
                        </button>
                    </div>
                @endif
            </div>

            <div data-kt-datatable-state-save="false" id="accommodations_table">
                <div class="kt-scrollable-x-auto" wire:loading.class="loading"
                    wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'accommodations-supplements',
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
