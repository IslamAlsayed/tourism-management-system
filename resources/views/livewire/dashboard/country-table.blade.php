<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => 'إدارة البلدان',
        'entityName' => 'بلد',
        'showSearch' => true,
    ])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] text-center">
                                <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-check="true"
                                    type="checkbox" />
                            </th>
                            <th class="min-w-[300px]">
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">Country Name</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">Country Code</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th class="w-[60px]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $country)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->code }}</td>
                                <td>
                                    <a href="{{ route('countries.edit', $country->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Enhanced Pagination Controls --}}
            <div class="kt-card-footer border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4">
                    {{-- Records per page selector --}}
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>عرض</span>
                        <select wire:model.live="perPage" class="kt-select w-20 px-2 py-1 border rounded">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>عنصر في كل صفحة</span>
                    </div>

                    {{-- Pagination info and links --}}
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-gray-600">
                            {{ $data->firstItem() }} - {{ $data->lastItem() }} من {{ $data->total() }}
                        </div>

                        {{-- Pagination Links --}}
                        @if($data->hasPages())
                        <div class="flex items-center gap-1">
                            {{-- Previous Page Link --}}
                            @if ($data->onFirstPage())
                                <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">السابق</span>
                            @else
                                <button wire:click="previousPage" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                                    السابق
                                </button>
                            @endif

                            {{-- Page Numbers --}}
                            @for ($i = max(1, $data->currentPage() - 2); $i <= min($data->lastPage(), $data->currentPage() + 2); $i++)
                                @if ($i == $data->currentPage())
                                    <span class="px-3 py-1 text-white bg-blue-600 rounded">{{ $i }}</span>
                                @else
                                    <button wire:click="gotoPage({{ $i }})" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                                        {{ $i }}
                                    </button>
                                @endif
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($data->hasMorePages())
                                <button wire:click="nextPage" class="px-3 py-1 text-blue-600 bg-white border border-gray-300 rounded hover:bg-blue-50">
                                    التالي
                                </button>
                            @else
                                <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded cursor-not-allowed">التالي</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
