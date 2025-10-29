<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.transportation-companies'),
        'entityName' => __('main.transportation-company'),
        'showSearch' => true,
    ])
        @include('components.columns', ['allColumns' => $allColumns ?? []])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
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
                                    {{ str_replace('_', ' ', __('main.' . $column)) }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $transportationCompany)
                            <tr wire:key="{{ $transportationCompany->id }}" class="hover:bg-gray-100">
                                <td class="text-center">
                                    <input type="checkbox" name="selectedItems[]"
                                        value="{{ $transportationCompany->id }}" class="kt-checkbox kt-checkbox-sm"
                                        data-kt-datatable-row-check="true" />
                                </td>
                                @foreach ($columns as $column)
                                    @include('components.static-columns', [
                                        'column' => $column,
                                        'model' => $transportationCompany,
                                        'search' => $search,
                                    ])
                                @endforeach
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('transportation-companies.edit', $transportationCompany->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        @include('components.elements.delete-button', [
                                            'id' => $transportationCompany->id,
                                        ])
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Enhanced Pagination Controls --}}
            @include('includes.pagination', ['data' => $data])
        </div>
    </div>
</div>
