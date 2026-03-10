<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.countries'),
        'entityName' => __('main.country'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,forceDeleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterActive,filterRegionId,filterSubregionId">

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 filterTable">
            {{-- Active Filter --}}
            <div>
                <label for="filterActive" class="text-sm font-medium">{{ __('main.active') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[40px] w-full max-w-full" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Region Filter --}}
            <div>
                <label for="filterRegionId" class="text-sm font-medium">{{ __('main.regions') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[40px] w-full max-w-full"
                    id="filterRegionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($regions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subregion Filter --}}
            <div>
                <label for="filterSubregionId" class="text-sm font-medium">{{ __('main.subregions') }}</label>
                <select wire:model.live="filterSubregionId" class="kt-select h-[40px] w-full max-w-full"
                    id="filterSubregionId">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($subregions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="flex items-end">
                @include('components.elements.reset-button')
            </div>
        </div>

        {{-- Bulk Action Buttons --}}
        @if (!empty($selectedIds) && count($selectedIds) > 0)
            <div
                class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary">{{ count($selectedIds) }}</span>
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

                    <button type="button" wire:click.prevent="clearSelected"
                        class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-times me-1"></i>
                        {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        @endif

        <div data-kt-datatable-state-save="false" id="countries_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.geography.countries',
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
