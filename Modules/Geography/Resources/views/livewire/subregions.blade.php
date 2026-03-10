<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.subregions'),
        'entityName' => __('main.subregion'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterActive,filterRegionId">

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 filterTable">
            {{-- Active Filter --}}
            <div>
                <label for="filterActive" class="text-sm">{{ __('main.active') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[40px] w-full max-w-full" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
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

        {{-- Bulk Action Toolbar --}}
        @if (!empty($selectedIds) && count($selectedIds) > 0)
            <div class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200" x-data="{
                confirmAction(action, opts) {
                    Swal.fire({
                        title: opts.title || '{{ __('messages.are_you_sure') }}',
                        text: opts.text,
                        icon: opts.icon || 'warning',
                        showCancelButton: true,
                        confirmButtonColor: opts.color || '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('main.yes') }}',
                        cancelButtonText: '{{ __('main.no') }}'
                    }).then((result) => {
                        if (result.isConfirmed) @this.call(action);
                    })
                }
            }">
                <span class="text-sm font-medium text-gray-700 me-2">
                    {{ __('main.selected') }}: <span class="badge badge-primary">{{ count($selectedIds) }}</span>
                </span>

                <div class="flex flex-wrap gap-2 items-center">
                    <button type="button"
                        x-on:click.prevent="confirmAction('activateSelected', {text: '{{ __('messages.confirm_bulk_activate') }}', icon: 'question', color: '#059669'})"
                        class="kt-btn kt-btn-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                        <i class="fas fa-check-circle me-1"></i>
                        {{ __('main.activate') }}
                    </button>
                    <button type="button"
                        x-on:click.prevent="confirmAction('deactivateSelected', {text: '{{ __('messages.confirm_bulk_deactivate') }}', icon: 'warning', color: '#ca8a04'})"
                        class="kt-btn kt-btn-sm text-white bg-yellow-600 hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-ban me-1"></i>
                        {{ __('main.deactivate') }}
                    </button>
                    <button type="button"
                        x-on:click.prevent="confirmAction('deleteSelected', {text: '{{ addslashes(str_replace(["\r\n", "\n", "\r"], " ", __('messages.confirm_bulk_delete'))) }}', icon: 'warning', color: '#d33'})"
                        class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash me-1"></i>
                        {{ __('main.delete') }}
                    </button>
                    <button type="button"
                        x-on:click.prevent="confirmAction('forceDeleteSelected', {text: '{{ addslashes(str_replace(["\r\n", "\n", "\r"], " ", __('messages.confirm_bulk_force_delete'))) }}', icon: 'error', color: '#991b1b'})"
                        class="kt-btn kt-btn-sm text-white bg-red-800 hover:bg-red-900 transition-colors">
                        <i class="fas fa-skull-crossbones me-1"></i>
                        {{ __('main.force_delete') }}
                    </button>
                </div>

                <button type="button" wire:click.prevent="clearSelected"
                    class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-times me-1"></i>
                    {{ __('main.cancel_selection') }}
                </button>
            </div>
        @endif

        <div data-kt-datatable-state-save="false" id="subregions_table">
            <div class="kt-scrollable-x-auto">
                @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.geography.subregions',
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
