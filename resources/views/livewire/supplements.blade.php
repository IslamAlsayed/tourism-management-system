<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.supplements'),
        'entityName' => __('main.supplement'),
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
            wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterPriceType,filterMandatory,filterActive">
            <!-- Filters -->
            <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 px-4 filterTable">
                <div>
                    <label for="price_type" class="text-sm">{{ __('main.price_type') }}</label>
                    <select wire:model.live="filterPriceType" class="kt-select h-[40px] w-48 max-w-full" id="price_type"
                        data-kt-select="true" data-kt-select-placeholder="{{ __('main.price_type') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="per_person">{{ __('main.per_person') }}</option>
                        <option value="per_room">{{ __('main.per_room') }}</option>
                        <option value="per_night">{{ __('main.per_night') }}</option>
                        <option value="one_time">{{ __('main.one_time') }}</option>
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
                    <label for="active" class="text-sm">{{ __('main.active') }}</label>
                    <select wire:model.live="filterActive" class="kt-select h-[40px] w-48 max-w-full" id="active"
                        data-kt-select="true" data-kt-select-placeholder="{{ __('main.active') }}">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="active">{{ __('main.active') }}</option>
                        <option value="inactive">{{ __('main.inactive') }}</option>
                    </select>
                </div>

                {{-- Reset Filters Button --}}
                <div>
                    <button type="button" wire:click="resetFilters" title="{{ __('main.reset_filters') }}"
                        toggle-button class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                    </button>
                </div>
            </div>

            <div data-kt-datatable-state-save="false" id="supplements_table">
                <div class="kt-scrollable-x-auto">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'supplements',
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
