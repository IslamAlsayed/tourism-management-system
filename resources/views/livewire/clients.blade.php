<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.clients'),
        'entityName' => __('main.client'),
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
        wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterClientGender,filterClientStatus">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterClientGender" class="kt-select h-[40px] w-48 max-w-full"
                    data-kt-select="true" data-kt-select-placeholder="{{ __('main.gender') }}">
                    <option value="">--</option>
                    <option value="male">{{ __('main.male') }}</option>
                    <option value="female">{{ __('main.female') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="filterClientStatus" id="client_status"
                    class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="">--</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                    <option value="blacklisted">{{ __('main.blacklisted') }}</option>
                </select>
            </div>

            {{-- Reset Sort Button --}}
            @if ($filterClientStatus || $filterClientGender)
                <div>
                    <button type="button" wire:click="resetFilters" title="{{ __('main.reset_validate') }}"
                        toggle-button class="kt-btn kt-btn-outline bg-white px-3hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                        <span class="text-sm">{{ __('main.reset_sort') }}</span>
                    </button>
                </div>
            @endif
        </div>

        <div data-kt-datatable-state-save="false" id="clients_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'clients',
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
