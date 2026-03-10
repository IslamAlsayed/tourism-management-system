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

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-2 lg:grid-cols-4 gap-4 filterTable">
            {{-- Active Filter --}}
            <div>
                <label for="filterActive" class="text-sm">{{ __('main.active') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[40px] w-full max-w-full" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label for="filterTypeId" class="text-sm">{{ __('main.type') }}</label>
                <select wire:model.live="filterTypeId" class="kt-select h-[40px] w-full max-w-full" id="filterTypeId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($types as $typeId => $typeName)
                        <option value="{{ $typeId }}">{{ $typeName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Region Filter --}}
            <div>
                <label for="filterRegionId" class="text-sm">{{ __('main.region') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[40px] w-full max-w-full"
                    id="filterRegionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($regions as $regionId => $regionName)
                        <option value="{{ $regionId }}">{{ $regionName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
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
        @endif

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
