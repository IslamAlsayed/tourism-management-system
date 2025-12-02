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
        wire:target="search,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel,toggleGridLength">
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
                                        'models' => 'languages',
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
            </div>
        @else
            <div wire:key="{{ $view ? $view : '' }}-view" data-kt-datatable="true" data-kt-datatable-state-save="false"
                id="team_crew_table">
                <div class="kt-scrollable-x-auto">
                    @component('components.data-table', [
                        'data' => $data,
                        'columns' => $columns,
                        'search' => $search,
                        'models' => 'languages',
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
