<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.rooms'),
        'entityName' => __('main.room'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterCurrencyId,filterStatus">
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4 filterTable">
            <div>
                <select wire:model.live="filterCurrencyId" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.currency') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency['id'] }}" title="{{ $currency['name'] }}">
                            {{ $currency['name'] }} - {{ $currency['code'] }}
                        </option>
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

        <div data-kt-datatable-state-save="false" id="rooms_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.accommodations.rooms',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>
