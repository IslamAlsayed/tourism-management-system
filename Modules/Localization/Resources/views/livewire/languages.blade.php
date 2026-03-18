<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.languages'),
        'entityName' => __('main.language'),
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

    <div class="kt-card-content" id="pageContent" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,toggleGridLength">

        {{-- Bulk Action Buttons --}}
        <div x-cloak x-show="$wire.selectedIds && $wire.selectedIds.length > 0"
                class="mb-4 flex flex-shrink flex-wrap items-center gap-2 px-1 bg-gray-50 p-3 rounded-lg border border-gray-200 shadow-sm">
                <span class="text-sm font-medium text-gray-700 me-2 p-2 bg-white rounded border border-gray-300">
                    {{ __('main.selected') }}: <span class="badge badge-primary" x-text="$wire.selectedIds.length"></span>
                </span>

                <div x-data="{
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
                    <button type="button" x-on:click.prevent="confirmDelete"
                        class="kt-btn kt-btn-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash me-1"></i>
                        {{ __('main.delete') }}
                    </button>
                    <button type="button" @click.prevent="$wire.selectedIds = []"
                        class="kt-btn kt-btn-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-times me-1"></i>
                        {{ __('main.cancel_selection') }}
                    </button>
                </div>
            </div>
        </div>

        @if ($view == 'grid')
            <div class="kt-cards p-4" wire:key="{{ $view ? $view : '' }}-view">
                <div class="inline-flex text-nowrap items-center gap-2 text-center mb-2 cursor-pointer">
                    @include('components.elements.all-checkbox-button', [
                        'name' => 'selectAllItems',
                        'id' => 'selectAllItems',
                        'label' => __('main.select_type', ['type' => __('main.all')]),
                    ])

                    {{-- Grid length --}}
                    <div>
                        <select wire:change="toggleGridLength($event.target.value,'languages')"
                            wire:model.live="gridLength" class="kt-select">
                            @for ($length = 1; $length <= 10; $length++)
                                <option value="{{ $length }}" @if ($gridLength == $length) selected @endif>
                                    {{ $length }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mb-4">
                    @foreach ($data as $language)
                        <div wire:key="{{ $language->id }}"
                            style="width: calc((100% / {{ $gridLength }}) - {{ (($gridLength - 1) * 16) / $gridLength }}px)"
                            class="kt-card hover:bg-gray-100 text-center p-4 rounded-lg shadow-sm">
                            <span class="text-start">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'selectedItems[]',
                                    'id' => 'selectedItems' . $language->id,
                                    'value' => $language->id,
                                ])
                            </span>
                            <div class="kt-card-title">{!! highlightSearch($language->code ?? '--', $search) !!}</div>
                            <div class="kt-card-body pb-2">
                                <p>{!! highlightSearch($language->name ?? '--', $search) !!}</p>
                                <p>{!! highlightSearch($language->name_ar ?? '--', $search) !!}</p>
                            </div>
                            <div class="kt-card-footer flex justify-center p-0 pt-2">
                                <div class="flex justify-center gap-2">
                                    @include('components.elements.edit-button', [
                                        'models' => 'dashboard.localization.languages',
                                        'id' => $language->id,
                                    ])

                                    @include('components.elements.delete-button', [
                                        'id' => $language->id,
                                    ])
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            
        @else
            <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true" data-kt-datatable-state-save="false"
                id="team_crew_table">
                <div class="kt-scrollable-x-auto">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'dashboard.localization.languages',
                        'selectedIds' => $selectedIds ?? [],
                    ])
                    @endcomponent
                </div>
            </div>
        @endif

        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>

