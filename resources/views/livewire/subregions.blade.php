<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns,
        'title' => __('main.subregions'),
        'entityName' => __('main.subregion'),
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
                                    {{ __('main.' . $column) }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $subregion)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selectedItems[]" value="{{ $subregion->id }}"
                                        class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                                </td>
                                @foreach ($columns as $column)
                                    @include('components.static-columns', [
                                        'column' => $column,
                                        'model' => $subregion,
                                        'search' => $search,
                                    ])
                                @endforeach
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('subregions.edit', $subregion->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('subregions.destroy', $subregion->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('subregions.destroy', $subregion->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">{{ __('main.delete') }}</button>
                                            </form>
                                        </a>
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
