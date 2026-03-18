<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.restaurants'),
        'entityName' => __('main.restaurant'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterActive,filterTypeId,filterRegionId">

        <!-- Unified Dropdown Filters -->
        <div class="mb-5 flex flex-wrap items-end gap-3 bg-amber-50 dark:bg-amber-900/10 border border-amber-200/60 dark:border-amber-700/30 p-3 rounded-xl relative z-[5] shadow-sm">
            {{-- Active Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]">
                <label for="filterActive" class="text-[11px] font-bold text-amber-800 dark:text-amber-400 uppercase tracking-wider mb-1 block">{{ __('main.status') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[36px] w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Type Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]">
                <label for="filterTypeId" class="text-[11px] font-bold text-amber-800 dark:text-amber-400 uppercase tracking-wider mb-1 block">{{ __('main.type') }}</label>
                <select wire:model.live="filterTypeId" class="kt-select h-[36px] w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterTypeId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($types as $typeId => $typeName)
                        <option value="{{ $typeId }}">{{ $typeName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Region Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]">
                <label for="filterRegionId" class="text-[11px] font-bold text-amber-800 dark:text-amber-400 uppercase tracking-wider mb-1 block">{{ __('main.regions') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[36px] w-full border-amber-200 focus:border-amber-500 focus:ring-amber-500/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterRegionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($regions as $regionId => $regionName)
                        <option value="{{ $regionId }}">{{ $regionName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="flex items-end h-[36px]">
                @include('components.elements.reset-button')
            </div>
        </div>

        {{-- Bulk Action Buttons --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" x-data="{
                confirmActivate() {
                        Swal.fire({
                            title: '{{ __('messages.are_you_sure') }}',
                            text: `{{ __('messages.confirm_bulk_activate') }}`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#059669',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('main.yes') }}',
                            cancelButtonText: '{{ __('main.no') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $wire.call('activateSelected');
                            }
                        })
                    },
                    confirmDeactivate() {
                        Swal.fire({
                            title: '{{ __('messages.are_you_sure') }}',
                            text: `{{ __('messages.confirm_bulk_deactivate') }}`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ca8a04',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('main.yes') }}',
                            cancelButtonText: '{{ __('main.no') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $wire.call('deactivateSelected');
                            }
                        })
                    },
                    confirmDelete() {
                        Swal.fire({
                            title: '{{ __('messages.are_you_sure') }}',
                            text: `{{ __('messages.confirm_bulk_delete') }}`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('main.yes') }}',
                            cancelButtonText: '{{ __('main.no') }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $wire.call('deleteSelected');
                            }
                        })
                    }
            }" class="mb-4 flex flex-wrap gap-2 px-1">
                <button type="button" x-on:click.prevent="confirmActivate"
                    class="kt-btn kt-btn-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ __('main.activate') }} ({{ count($selectedIds) }})
                </button>
                <button type="button" x-on:click.prevent="confirmDeactivate"
                    class="kt-btn kt-btn-sm text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-ban me-1"></i>
                    {{ __('main.deactivate') }} ({{ count($selectedIds) }})
                </button>
                <button type="button" x-on:click.prevent="confirmDelete"
                    class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash me-1"></i>
                    {{ __('main.delete') }} ({{ count($selectedIds) }})
                </button>
            </div>

        <div data-kt-datatable-state-save="false" id="restaurants_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.restaurants',
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

