<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'allColumns' => $allColumns ?? [],
        'pendingColumns' => $pendingColumns ?? [],
        'modelClass' => $modelClass ?? '',
        'relations' => $relations ?? [],
        'hasCustomColumns' => $hasCustomColumns ?? false,
        'settings' => $settings ?? null,
        'title' => __('main.tours.guides'),
        'entityName' => __('main.tours.guide'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
        'manageableFilters' => [
            'active' => __('main.status'),
            'region' => __('main.regions'),
            'subregion' => __('main.subregions'),
            'country' => __('main.countries'),
            'state' => __('main.states'),
            'city' => __('main.cities'),
            'type' => __('main.type'),
        ]
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'pendingColumns' => $pendingColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
                'modelClass' => $modelClass ?? '',
                'hasCustomColumns' => $hasCustomColumns ?? false,
            ])
        @endif
    @endcomponent

    <div class="kt-card-content px-2 pb-4" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,forceDeleteSelected,exportSelectedPDF,exportSelectedExcel,filterActive,filterRegionId,filterSubregionId,filterCountryId,filterStateId,filterCityId,filterTypeId">

        <!-- Unified Dropdown Filters -->
        <div class="flex flex-wrap items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/50 rounded-xl mb-5"
         x-data="{ 
             showAny: true,
             filterKeys: {{ json_encode(array_keys($manageableFilters ?? [])) }}
         }"
         x-effect="
             if ($store.filtersVisibility && $store.filtersVisibility.filters) {
                 showAny = filterKeys.some(f => $store.filtersVisibility.filters['filter_' + f] !== false);
             } else {
                 showAny = true;
             }
         "
         x-show="showAny"
         x-cloak>
        <div class="flex items-center gap-2 pe-3 border-e border-gray-300 dark:border-gray-600">
            <i class="fa-duotone fa-solid fa-filter text-primary text-xl"></i>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                {{ __('main.filters') }}
            </span>
        </div>
            
            {{-- Active Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['active'] !== false" x-transition.opacity x-cloak>
                <label for="filterActive" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.status') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Region Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['region'] !== false" x-transition.opacity x-cloak>
                <label for="filterRegionId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.regions') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterRegionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($regions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subregion Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['subregion'] !== false" x-transition.opacity x-cloak>
                <label for="filterSubregionId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.subregions') }}</label>
                <select wire:model.live="filterSubregionId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterSubregionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($subregions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Country Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['country'] !== false" x-transition.opacity x-cloak>
                <label for="filterCountryId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.countries') }}</label>
                <select wire:model.live="filterCountryId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterCountryId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($countries as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- State Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['state'] !== false" x-transition.opacity x-cloak>
                <label for="filterStateId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.states') }}</label>
                <select wire:model.live="filterStateId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterStateId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($states as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- City Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['city'] !== false" x-transition.opacity x-cloak>
                <label for="filterCityId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.cities') }}</label>
                <select wire:model.live="filterCityId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterCityId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($cities as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]" x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['type'] !== false" x-transition.opacity x-cloak>
                <label for="filterTypeId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.type') }}</label>
                <select wire:model.live="filterTypeId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterTypeId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($types as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="flex items-end h-[36px]">
                @include('components.elements.reset-button', ['resetTarget' => 'filterActive,filterRegionId,filterSubregionId,filterCountryId,filterStateId,filterCityId,filterTypeId'])
            </div>
        </div>

        {{-- Bulk Action Buttons --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>
                </span>

                <div class="flex flex-wrap gap-2">
                    <div x-data="{
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
                                        @this.call('activateSelected');
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
                                        @this.call('deactivateSelected');
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
                                        @this.call('deleteSelected');
                                    }
                                })
                            },
                            confirmForceDelete() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: `{{ __('messages.confirm_bulk_force_delete') }}`,
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonColor: '#991b1b',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('forceDeleteSelected');
                                    }
                                })
                            }
                    }" class="flex flex-wrap gap-2 items-center">
                        <button type="button" x-on:click.prevent="confirmActivate"
                            class="kt-btn kt-btn-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ __('main.activate') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDeactivate"
                            class="kt-btn kt-btn-sm text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-ban me-1"></i>
                            {{ __('main.deactivate') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDelete"
                            class="kt-btn kt-btn-sm text-white bg-red-500 hover:bg-red-600 transition-colors">
                            <i class="fas fa-trash me-1"></i>
                            {{ __('main.delete') }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmForceDelete"
                            class="kt-btn kt-btn-sm text-white bg-red-800 hover:bg-red-900 transition-colors">
                            <i class="fas fa-radiation me-1"></i>
                            {{ __('main.force_delete') }}
                        </button>
                        <button type="button" @click.prevent="$wire.selectedIds = []"
                            class="kt-btn kt-btn-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            <i class="fas fa-times me-1"></i>
                            {{ __('main.cancel_selection') ?? 'Cancel Selection' }}
                        </button>
                    </div>
                </div>
            </div>
        


        <div data-kt-datatable-state-save="false" id="tour_guides_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'allColumns' => $allColumns ?? [],
                    'search' => $search,
                    'models' => 'dashboard.tourguides.guides',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

