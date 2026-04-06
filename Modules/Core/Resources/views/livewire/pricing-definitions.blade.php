<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.pricing-definitions'),
        'entityName' => __('main.pricing-definition'),
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

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,resetFilters,filterCategory,filterStatus">

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md-grid-cols-3 gap-4 px-4 filterTable">
            <div>
                <select wire:model.live="filterCategory" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.category') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach ($categories ?? [] as $catKey => $catLabel)
                        <option value="{{ $catKey }}">{{ $catLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterStatus" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.status') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    <option value="active">{{ __('main.active') }}</option>
                    <option value="inactive">{{ __('main.inactive') }}</option>
                </select>
            </div>

            <div>
                <select wire:model.live="filterModule" class="kt-select h-[40px] w-48 max-w-full" data-kt-select="true"
                    data-kt-select-placeholder="{{ __('main.module') }}">
                    <option value="all">{{ __('main.all') }}</option>
                    @foreach (\Modules\Core\Entities\PricingDefinition::getAvailableModules() as $modKey => $modLabel)
                        <option value="{{ $modKey }}">{{ $modLabel }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Reset Button --}}
            @include('components.elements.reset-button')
        </div>

        <!-- Bulk Actions -->
        @if (!empty($selectedIds))
            <div class="mb-4 px-4" x-data="{
                confirmActivate() {
                    Swal.fire({
                        title: '{{ __('messages.are_you_sure') }}',
                        text: '{{ __('messages.confirm_bulk_activate') ?? 'Are you sure you want to activate the selected items?' }}',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#17c653',
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
                        text: '{{ __('messages.confirm_bulk_deactivate') ?? 'Are you sure you want to deactivate the selected items?' }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc700',
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
                        text: '{{ __('messages.you_wont_be_able_to_revert_this') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('messages.yes_delete_it') }}',
                        cancelButtonText: '{{ __('main.cancel') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $wire.call('deleteSelected');
                        }
                    })
                }
            }">
                <div class="bg-primary/5 border border-primary/20 rounded-lg p-3 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="kt-badge kt-badge-primary">{{ count($selectedIds) }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ __('main.records_selected') }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="button" x-on:click.prevent="confirmActivate" class="kt-btn kt-btn-success kt-btn-sm flex items-center gap-1.5 px-3">
                            <i class="fa-duotone fa-solid fa-check-circle fs-3"></i> {{ __('main.activate') ?? 'Activate' }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDeactivate" class="kt-btn kt-btn-warning kt-btn-sm flex items-center gap-1.5 px-3">
                            <i class="fa-duotone fa-solid fa-minus-circle fs-3"></i> {{ __('main.deactivate') ?? 'Deactivate' }}
                        </button>
                        <button type="button" x-on:click.prevent="confirmDelete" class="kt-btn kt-btn-destructive kt-btn-sm flex items-center gap-1.5 px-3">
                            <i class="fa-duotone fa-solid fa-trash fs-3"></i> {{ __('main.delete') }}
                        </button>
                        <div class="w-px h-6 bg-gray-300 mx-1"></div>
                        <button type="button" wire:click="clearSelected" class="kt-btn kt-btn-light kt-btn-sm flex items-center gap-1.5 px-3">
                            <i class="fa-duotone fa-solid fa-xmark fs-3"></i> {{ __('main.cancel_selection') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div data-kt-datatable-state-save="false" id="pricing_definitions_table">
            @component('components.data-table', [
                    'data' => $data,
                    'columns' => $columns,
                    'search' => $search,
                    'models' => 'dashboard.core.pricing-definitions',
                    'selectedIds' => $selectedIds ?? [],
                ])
                @endcomponent

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>

        <!-- Quick Edit Modal -->
        @if($isQuickEditModalOpen)
            <div class="fixed inset-0 z-[100] flex items-center justify-center overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeQuickEdit"></div>
                <div class="relative bg-white rounded-lg text-start overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full m-4">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start w-full">
                            <div class="mt-3 text-center sm:mt-0 sm:text-start w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    {{ __('main.quick_edit') }} - {{ __('main.module_assignments') }}
                                </h3>
                                <div class="mt-2 w-full">
                                    <label class="form-label font-medium text-gray-700 mb-1">{{ __('main.select_modules') }}</label>
                                    <select wire:model.defer="quickEditModules" class="form-select style-multi w-full" multiple style="min-height: 150px;">
                                        @foreach (\Modules\Core\Entities\PricingDefinition::getAvailableModules() as $modKey => $modLabel)
                                            <option value="{{ $modKey }}">{{ $modLabel }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-slate-500 mt-2"><i class="fa-duotone fa-solid fa-circle-info-2"></i> {{ __('messages.hold_ctrl_to_select_multiple') ?? 'Hold Ctrl (Windows) or Cmd (Mac) to select multiple items.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="saveQuickEdit" wire:loading.attr="disabled" class="kt-btn kt-btn-primary sm:ml-3 sm:w-auto w-full">
                            <span wire:loading.remove wire:target="saveQuickEdit">{{ __('main.save_changes') }}</span>
                            <span wire:loading wire:target="saveQuickEdit" class="flex items-center gap-2">
                                <span class="spinner-border spinner-border-sm align-middle"></span> {{ __('main.saving') }}...
                            </span>
                        </button>
                        <button type="button" wire:click="closeQuickEdit" class="kt-btn kt-btn-light mt-3 sm:mt-0 sm:w-auto w-full">
                            {{ __('main.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

