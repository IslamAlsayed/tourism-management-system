<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.timezones'),
        'entityName' => __('main.timezone'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,activateSelected,deactivateSelected,exportSelectedPDF,exportSelectedExcel">

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

            {{-- Country Code Filter --}}
            <div>
                <label for="filterCountryCode" class="text-sm font-medium">{{ __('main.country_code') }}</label>
                <input type="text" wire:model.live.debounce.300ms="filterCountryCode" class="kt-input h-[40px] w-full max-w-full" id="filterCountryCode" placeholder="ex: EG, US...">
            </div>

            {{-- Supports DST Filter --}}
            <div>
                <label for="filterSupportsDst" class="text-sm font-medium">{{ __('main.supports_dst') }}</label>
                <select wire:model.live="filterSupportsDst" class="kt-select h-[40px] w-full max-w-full" id="filterSupportsDst">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="yes">{{ __('main.yes') }}</option>
                    <option value="no">{{ __('main.no') }}</option>
                </select>
            </div>

            
            {{-- Sync Button --}}
            <div class="flex items-end">
                <button type="button" wire:click="syncTimezones" wire:loading.attr="disabled" class="kt-btn kt-btn-primary h-[40px] w-full">
                    <span wire:loading.remove wire:target="syncTimezones"><i class="fas fa-sync-alt me-2"></i> {{ __('main.sync_timezones') ?? 'Sync Timezones' }}</span>
                    <span wire:loading wire:target="syncTimezones"><i class="fas fa-spinner fa-spin me-2"></i> {{ __('main.syncing') ?? 'Syncing...' }}</span>
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
                }" class="flex flex-wrap gap-2 items-center">
                    <button type="button" x-on:click.prevent="confirmActivate" class="kt-btn kt-btn-success kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-check-circle fs-3"></i> {{ __('main.activate') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDeactivate" class="kt-btn kt-btn-warning kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-xmark-circle fs-3"></i> {{ __('main.deactivate') }}
                    </button>
                    <button type="button" x-on:click.prevent="confirmDelete" class="kt-btn kt-btn-destructive kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-trash fs-3"></i> {{ __('main.delete') }}
                    </button>
                    <button type="button" @click.prevent="$wire.selectedIds = []" class="kt-btn kt-btn-secondary kt-btn-sm flex items-center gap-1.5 px-3">
                        <i class="fa-duotone fa-solid fa-xmark fs-3"></i> {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        

        <div data-kt-datatable-state-save="false" id="timezones_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.localization.timezones',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>

