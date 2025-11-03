<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.system_languages'),
        'entityName' => __('main.language'),
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
                        <div class="kt-card text-center p-4 rounded-lg shadow-sm {{ getCurrentLocale() == $language->code ? 'bg-gray-100 border-2 border-green-500' : 'hover:bg-gray-100' }}"
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
                                @if ($language->name_ar)
                                    <p>{!! highlightSearch($language->name_ar ?? '--', $search) !!}</p>
                                @endif
                            </div>
                            <div class="kt-card-footer flex justify-center p-0 pt-2">
                                <div class="flex justify-center gap-2">
                                    @if (getCurrentLocale() != $language->code)
                                        <a href="{{ route('system-languages.change', $language->code) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white">
                                            {{ __('main.active') }}
                                        </a>
                                    @endif
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
                    <table class="kt-table table-auto text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-[60px] px-4 py-3 text-center">
                                    @include('components.elements.all-checkbox-button', [
                                        'name' => 'selectAllItems',
                                        'id' => 'selectAllItems',
                                    ])
                                </th>
                                @foreach ($columns as $column)
                                    <th
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('main.' . $column) }}
                                    </th>
                                @endforeach
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $language)
                                <tr wire:key="{{ $language->id }}"
                                    class="{{ getCurrentLocale() == $language->code ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                                    <td class="text-center">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'selectedItems[]',
                                            'id' => 'selectedItems' . $language->id,
                                            'value' => $language->id,
                                        ])
                                    </td>
                                    @foreach ($columns as $column)
                                        @include('components.static-columns', [
                                            'column' => $column,
                                            'model' => $language,
                                            'search' => $search,
                                        ])
                                    @endforeach
                                    <td class="px-4 py-2 text-end">
                                        <div class="flex items-center justify-end gap-2">
                                            @if (getCurrentLocale() != $language->code)
                                                <a href="{{ route('system-languages.change', $language->code) }}"
                                                    class="kt-btn kt-btn-sm kt-btn-outline bg-success text-white">
                                                    {{ __('main.active') }}
                                                </a>
                                            @else
                                                <span style="padding-inline: 17px">
                                                    <i class="fas fa-circle-check text-green-600"></i>
                                                </span>
                                            @endif
                                            @include('components.elements.edit-button', [
                                                'models' => 'system-languages',
                                                'id' => $language->id,
                                            ])
                                            @include('components.elements.delete-button', [
                                                'id' => $language->id,
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if (isset($data) && !empty($data) && $data->count() > 0)
            {{-- Enhanced Pagination Controls --}}
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>
