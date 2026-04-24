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

        <!-- Unified Dropdown Filters -->
        <div class="mb-5 flex flex-wrap items-end gap-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700/50 p-3 rounded-xl relative z-[5] shadow-sm">
            {{-- Active Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]">
                <label for="filterActive" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.status') }}</label>
                <select wire:model.live="filterActive" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterActive">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            {{-- Region Filter --}}
            <div class="min-w-[140px] flex-1 max-w-[200px]">
                <label for="filterRegionId" class="text-[11px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1 block">{{ __('main.regions') }}</label>
                <select wire:model.live="filterRegionId" class="kt-select h-[36px] w-full border-gray-300 focus:border-primary focus:ring-primary/20 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 transition-colors shadow-sm" id="filterRegionId">
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

        {{-- Bulk Action Toolbar --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0" class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm" x-data="{
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
                        if (result.isConfirmed) {
                            @this.call(action);
                        }
                    })
                }
            }">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 me-2 p-2 bg-white dark:bg-gray-700 rounded border border-gray-300 dark:border-gray-600">
                    {{ __('main.selected') }}: <span class="kt-badge kt-badge-primary" x-text="$wire.selectedIds.length"></span>
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

                <button type="button" @click.prevent="$wire.selectedIds = []"
                    class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    <i class="fas fa-times me-1"></i>
                    {{ __('main.cancel_selection') }}
                </button>
            </div>

        <div data-kt-datatable-state-save="false" id="subregions_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.geography.subregions',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

