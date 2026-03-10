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

    <div class="kt-card-content">
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
            @if (!empty($selectedIds) && count($selectedIds) > 0)
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
                        }
                }" class="mb-4 flex flex-wrap gap-2 px-4 transition-all">
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
            @endif

            <div data-kt-datatable-state-save="false" id="restaurant_types_table">
                <div class="kt-scrollable-x-auto">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'dashboard.restaurants.types',
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
