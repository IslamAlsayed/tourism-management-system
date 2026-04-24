<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.restaurant_types'),
        'entityName' => __('main.type'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,resetFilters,filterActive">
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 gap-4 px-4 filterTable">
                <div>
                    <label for="active" class="text-sm">{{ __('main.active') }}</label>
                    <select wire:model.live="filterActive" class="kt-select h-[40px] w-48 max-w-full" id="active">
                        <option value="all">{{ __('main.all') }}</option>
                        <option value="active">{{ __('main.active') }}</option>
                        <option value="inactive">{{ __('main.inactive') }}</option>
                    </select>
                </div>
                @include('components.elements.reset-button')
            </div>

            {{-- Bulk Action Buttons --}}
            <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                    class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 me-2 p-2 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">
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
                                            $wire.call('forceDeleteSelected');
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
                                class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash me-1"></i>
                                {{ __('main.delete') }}
                            </button>
                            <button type="button" x-on:click.prevent="confirmForceDelete"
                                class="kt-btn kt-btn-sm text-white bg-red-800 hover:bg-red-900 transition-colors">
                                <i class="fas fa-skull-crossbones me-1"></i>
                                {{ __('main.force_delete') }}
                            </button>
                        </div>

                        <button type="button" @click.prevent="$wire.selectedIds = []"
                            class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-times me-1"></i>
                            {{ __('main.cancel_selection') }}
                        </button>
                    </div>
                </div>

            <div data-kt-datatable-state-save="false" id="restaurant_types_table">
                @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'dashboard.restaurants.types',
                        'selectedIds' => $selectedIds ?? [],
                    ])
                    @endcomponent
            </div>
        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

