<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.languages'),
        'entityName' => __('main.language'),
        'sortField' => $sortField,
        'searchValue' => $search,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('components.columns', ['allColumns' => $allColumns ?? []])
        @endif
    @endcomponent

    <div class="kt-card-content" id="pageContent">
        @if ($view == 'grid')
            <div class="kt-cards p-4" wire:key="{{ $view ? $view : '' }}-view">
                <div class="inline-flex text-nowrap items-center gap-2 text-center mb-2 cursor-pointer">
                    @include('components.elements.all-checkbox-button', [
                        'name' => 'selectAllItems',
                        'id' => 'selectAllItems',
                        'label' => __('main.select_type', ['type' => __('main.all')]),
                    ])
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-4">
                    @foreach ($data as $language)
                        <div wire:key="{{ $language->id }}"
                            class="kt-card hover:bg-gray-100 text-center p-4 rounded-lg shadow-sm"
                            wire:key="{{ $language->id }}">
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
                <div class="kt-scrollable-x-auto" wire:target="search" wire:loading.class="loading">
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
            {{-- Enhanced Pagination Controls --}}
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>
