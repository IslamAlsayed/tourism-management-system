<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.permissions'),
        'entityName' => __('main.permission'),
        'sortField' => $sortField ?? null,
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
    @endcomponent

    <div class="kt-card-content" wire:loading.class="loading"
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
        <div data-kt-datatable-state-save="false" id="permissions_table">
            <div class="kt-scrollable-x-auto">
                <div class="top-scroll" id="topScroll" wire:ignore>
                    <div class="top-scroll-inner" id="topScrollInner"></div>
                </div>

                <div class="table-wrapper" id="tableWrapper">
                    <table class="kt-table table-auto text-nowrap" id="data_table">
                        <thead>
                            <tr>
                                <th class="w-[60px] px-4 py-3 text-center" style="padding-inline-start: 21px">
                                    @if (isset($data) && !empty($data) && $data->count() > 0)
                                        @include('components.elements.all-checkbox-button', [
                                            'name' => 'selectPage',
                                            'id' => 'selectPage',
                                        ])
                                    @endif
                                </th>
                                @php
                                    $columns = ['name', 'guard_name', 'created_at'];
                                @endphp
                                @foreach ($columns as $column)
                                    @if ($column == 'uuid' && $settings->app_show_uuid_column == 0)
                                        @continue
                                    @endif
                                    <th wire:click="sortBy('{{ $column }}')" title="{{ __('main.sort_by') }} {{ __('main.' . $column) }}"
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                                        {{ __('main.' . $column) }}
                                        <i class="fas {{ $this->getSortIcon($column) }} ms-2"
                                            style="font-size: 14px; {{ $this->isSortedBy($column) ? 'color: #3b82f6;' : '' }}"></i>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody id="data_table_tbody">
                            @forelse ($data as $permission)
                                <tr wire:key="row-{{ $permission->id }}" class="hover:bg-gray-100 unique-record-{{ $permission->id }}">
                                    <td class="text-center">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'selectItem[]',
                                            'id' => 'selectItem' . $permission->id,
                                            'value' => $permission->id,
                                            'checked' => in_array($permission->id, $selectedIds),
                                        ])
                                    </td>
                                    <td class="font-medium">
                                        {!! highlightSearch(limitedText($permission->name ?? '--', 30), $search) !!}
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-gray-600">
                                            {!! highlightSearch(limitedText($permission->guard_name ?? '--', 30), $search) !!}
                                        </span>
                                    </td>
                                    <td>{!! highlightSearch(limitedText($permission->created_at->format('Y-m-d H:i') ?? '--', 30), $search) !!}</td>
                                    <td class="px-4 py-2 text-end">
                                        <div class="flex gap-2 justify-end">
                                            @if (getActiveUser()->can('view', $permission))
                                                @include('components.elements.show-button', [
                                                    'models' => 'dashboard.core.permissions',
                                                    'id' => $permission->id,
                                                ])
                                            @endif

                                            @if (getActiveUser()->can('update', $permission))
                                                @include('components.elements.edit-button', [
                                                    'models' => 'dashboard.core.permissions',
                                                    'id' => $permission->id,
                                                ])
                                            @endif

                                            @if (getActiveUser()->can('delete', $permission))
                                                @include('components.elements.delete-button', ['id' => $permission->id])
                                            @endif

                                            @if (getActiveUser()->can('forceDelete', $permission))
                                                @include('components.elements.forceDelete-button', ['id' => $permission->id])
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($columns) + 2 }}" class="px-4 py-3 text-center text-gray-500">
                                        <div class="w-[90px] h-[90px] mx-auto my-4">
                                            <img src="{{ asset('assets/images/other/no-data.svg') }}" alt="no data">
                                        </div>
                                        <p class="text-red-600 font-semibold">{{ __('messages.no_records_found') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if (isset($data) && !empty($data) && $data->count() > 0)
                @include('includes.pagination', ['data' => $data])
            @endif
        </div>
    </div>
</div>
