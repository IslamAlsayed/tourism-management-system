<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.languages'),
        'entityName' => __('main.language'),
        'showSearch' => true,
    ])
        @include('components.columns', ['allColumns' => $allColumns ?? []])
    @endcomponent

    <div class="kt-card-content" id="pageContent">
        @if ($view == 'grid')
            <div class="kt-cards p-4" wire:key="{{ $view ? $view : '' }}-view">
                <div class="inline-flex text-nowrap items-center gap-2 text-center mb-2 cursor-pointer">
                    <input type="checkbox" id="selectAllItems" class="kt-checkbox kt-checkbox-sm">
                    <label for="selectAllItems"
                        class="cursor-pointer">{{ __('main.select_type', ['type' => __('main.all')]) }}</label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-4">
                    @foreach ($data as $language)
                        <div wire:key="{{ $language->id }}"
                            class="kt-card hover:bg-gray-100 text-center p-4 rounded-lg shadow-sm"
                            wire:key="{{ $language->id }}">
                            <span class="text-start">
                                <input type="checkbox" name="selectedItems[]" value="{{ $language->id }}"
                                    class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                            </span>
                            <div class="kt-card-title">{!! highlightSearch($language->code ?? '--', $search) !!}</div>
                            <div class="kt-card-body pb-2">
                                <p>{!! highlightSearch($language->name ?? '--', $search) !!}</p>
                                <p>{!! highlightSearch($language->name_ar ?? '--', $search) !!}</p>
                            </div>
                            <div class="kt-card-footer flex justify-center p-0 pt-2">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('languages.edit', $language->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                        {{ __('main.edit') }}
                                    </a>

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
                    <table class="kt-table table-auto text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-[60px] px-4 py-3 text-center">
                                    <input type="checkbox" id="selectAllItems" class="kt-checkbox kt-checkbox-sm">
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
                                <tr wire:key="{{ $language->id }}">
                                    <td class="text-center">
                                        <input type="checkbox" name="selectedItems[]" value="{{ $language->id }}"
                                            class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                                    </td>
                                    @foreach ($columns as $column)
                                        @include('components.static-columns', [
                                            'column' => $column,
                                            'model' => $language,
                                            'search' => $search,
                                        ])
                                    @endforeach
                                    <td class="px-4 py-2 text-end">
                                        <div>
                                            <a href="{{ route('languages.edit', $language->id) }}"
                                                class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                                {{ __('main.edit') }}
                                            </a>

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

        {{-- Enhanced Pagination Controls --}}
        @include('includes.pagination', ['data' => $data])
    </div>
</div>
