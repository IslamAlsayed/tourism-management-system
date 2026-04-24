<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.currencies'),
        'entityName' => __('main.currency'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,forceDeleteSelected,exportSelectedPDF,exportSelectedExcel">

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

            {{-- Base Currency Filter --}}
            <div>
                <label for="filterBaseCurrency" class="text-sm font-medium">{{ __('main.is_base_currency') }}</label>
                <select wire:model.live="filterBaseCurrency" class="kt-select h-[40px] w-full max-w-full" id="filterBaseCurrency">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="yes">{{ __('main.yes') }}</option>
                    <option value="no">{{ __('main.no') }}</option>
                </select>
            </div>

            {{-- Major Currency Filter --}}
            <div>
                <label for="filterMajorCurrency" class="text-sm font-medium">{{ __('main.is_major_currency') }}</label>
                <select wire:model.live="filterMajorCurrency" class="kt-select h-[40px] w-full max-w-full" id="filterMajorCurrency">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="yes">{{ __('main.yes') }}</option>
                    <option value="no">{{ __('main.no') }}</option>
                </select>
            </div>

            {{-- Auto Update Filter --}}
            <div>
                <label for="filterAutoUpdate" class="text-sm font-medium">{{ __('main.auto_update_rate') }}</label>
                <select wire:model.live="filterAutoUpdate" class="kt-select h-[40px] w-full max-w-full" id="filterAutoUpdate">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="yes">{{ __('main.yes') }}</option>
                    <option value="no">{{ __('main.no') }}</option>
                </select>
            </div>
            
            {{-- Sync Button --}}
            <div class="flex items-end">
                <button type="button" wire:click="syncRates" wire:loading.attr="disabled" class="kt-btn kt-btn-primary h-[40px] w-full">
                    <span wire:loading.remove wire:target="syncRates"><i class="fas fa-sync-alt me-2"></i> {{ __('main.sync_rates') ?? 'Sync Rates' }}</span>
                    <span wire:loading wire:target="syncRates"><i class="fas fa-spinner fa-spin me-2"></i> {{ __('main.syncing') ?? 'Syncing...' }}</span>
                </button>
            </div>
        </div>

        {{-- Bulk Action Buttons --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                class="mb-4 flex flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>
                </span>

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
                        confirmEnableAutoUpdate() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: `{{ __('messages.confirm_bulk_enable_auto_update') ?? 'Are you sure you want to enable auto-update for selected currencies?' }}`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#2563eb',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $wire.call('enableAutoUpdateSelected');
                                }
                            })
                        },
                        confirmDisableAutoUpdate() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: `{{ __('messages.confirm_bulk_disable_auto_update') ?? 'Are you sure you want to disable auto-update (fix exchange rate) for selected currencies?' }}`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#4b5563',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $wire.call('disableAutoUpdateSelected');
                                }
                            })
                        },
                        confirmMarkMajor() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: `{{ __('messages.confirm_bulk_mark_major') ?? 'Are you sure you want to mark selected currencies as major?' }}`,
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#7239ea',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $wire.call('markMajorSelected');
                                }
                            })
                        },
                        confirmUnmarkMajor() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: `{{ __('messages.confirm_bulk_unmark_major') ?? 'Are you sure you want to unmark selected currencies as major?' }}`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#f8285a',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $wire.call('unmarkMajorSelected');
                                }
                            })
                        },
                        confirmMarkBase() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: `{{ __('messages.confirm_bulk_mark_base') ?? 'Are you sure you want to set selected currencies as Base Currency?' }}`,
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#17c653',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $wire.call('markBaseSelected');
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
                    <button type="button" x-on:click.prevent="confirmActivate" class="kt-btn kt-btn-success kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-check-circle fs-3"></i> {{ __('main.activate') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDeactivate" class="kt-btn kt-btn-warning kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-xmark-circle fs-3"></i> {{ __('main.deactivate') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmEnableAutoUpdate" class="kt-btn kt-btn-primary kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-arrows-rotate fs-3"></i> {{ __('main.enable_auto_update') ?? 'Enable Auto Update' }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDisableAutoUpdate" class="kt-btn kt-btn-dark kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-lock-2 fs-3"></i> {{ __('main.disable_auto_update') ?? 'Fix Exchange Rate' }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmMarkMajor" class="kt-btn kt-btn-info kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-star fs-3"></i> {{ __('main.mark_major') ?? 'Mark as Major' }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmUnmarkMajor" class="kt-btn kt-btn-secondary kt-btn-sm flex items-center gap-1.5 px-3 border border-border">
                        <i class="fa-duotone fa-solid fa-xmark-circle fs-3"></i> {{ __('main.unmark_major') ?? 'Unmark Major' }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmMarkBase" class="kt-btn kt-btn-success kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-building-columns fs-3"></i> {{ __('main.mark_base') ?? 'Set as Base' }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDelete" class="kt-btn kt-btn-destructive kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-trash fs-3"></i> {{ __('main.delete') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmForceDelete" class="kt-btn kt-btn-destructive kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-trash-square fs-3"></i> {{ __('main.force_delete') }}
                    </button>
                    <button type="button" @click.prevent="$wire.selectedIds = []" class="kt-btn kt-btn-secondary kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-xmark fs-3"></i> {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        

        <div data-kt-datatable-state-save="false" id="currencies_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.localization.currencies',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

