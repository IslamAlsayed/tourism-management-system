<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('main.roles'),
        'entityName' => __('main.role'),
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
        wire:target="search,paginate,toggleAll,resetColumns,applyColumns,destroy,deleteSelected,exportSelectedPDF,exportSelectedExcel">
        <div data-kt-datatable-state-save="false" id="roles_table">
            <div x-data="{
                    init() {
                        setTimeout(() => this.updateWidth(), 200);
                        window.addEventListener('resize', () => { setTimeout(() => this.updateWidth(), 100); });
                        const observer = new MutationObserver(() => this.updateWidth());
                        if (this.$refs.actualTable) observer.observe(this.$refs.actualTable, { childList: true, subtree: true });
                    },
                    syncTop(e) { this.$refs.bottomScroll.scrollLeft = e.target.scrollLeft; },
                    syncBottom(e) { this.$refs.topScroll.scrollLeft = e.target.scrollLeft; },
                    updateWidth() {
                        if(this.$refs.actualTable && this.$refs.dummyContent) {
                            this.$refs.dummyContent.style.width = this.$refs.actualTable.scrollWidth + 'px';
                        }
                    }
                }">
                <!-- CSS for top scrollbar styling now managed in main.css -->
                <div class="top-scroll w-full overflow-x-auto overflow-y-hidden custom-scrollbar" id="topScrollRoles" x-ref="topScroll" @scroll="syncTop" wire:ignore style="scrollbar-color: #2563eb rgba(37,99,235,0.08);">
                    <div class="top-scroll-inner" id="topScrollInner" x-ref="dummyContent" style="height: 1px;"></div>
                </div>

                <div class="table-wrapper w-full overflow-x-auto custom-scrollbar" id="tableWrapper" x-ref="bottomScroll" @scroll="syncBottom">
                    <table x-ref="actualTable" class="kt-table table-auto text-nowrap" id="data_table">
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
                                    $columns = ['name', 'permissions_count', 'created_at'];
                                @endphp
                                @foreach ($columns as $column)
                                    @if ($column == 'uuid' && $settings->app_show_uuid_column == 0)
                                        @continue
                                    @endif
                                    <th wire:click="sortBy('{{ $column }}')"
                                        title="{{ __('main.sort_by') }} {{ __('main.' . $column) }}"
                                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                                        {{ __('main.' . $column) }}
                                        <i class="fas {{ $this->getSortIcon($column) }} ms-2"
                                            style="font-size: 14px; {{ $this->isSortedBy($column) ? 'color: #3b82f6;' : '' }}"></i>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-center">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="data_table_tbody">
                            @forelse ($data as $role)
                                <tr wire:key="row-{{ $role->id }}"
                                    class="hover:bg-gray-100 unique-record-{{ $role->id }}">
                                    <td class="text-center">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'selectItem[]',
                                            'id' => 'selectItem' . $role->id,
                                            'value' => $role->id,
                                            'checked' => in_array($role->id, $selectedIds),
                                        ])
                                    </td>
                                    <td class="font-medium">
                                        {!! highlightSearch(limitedText($role->name ?? '--', 30), $search) !!}
                                    </td>
                                    <td>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700">
                                            {!! highlightSearch(limitedText($role->permissions->count() ?? '--', 30), $search) !!}
                                        </span>
                                    </td>
                                    <td>{!! highlightSearch(limitedText($role->created_at->format('Y-m-d H:i') ?? '--', 30), $search) !!}</td>
                                    <td class="px-4 py-2 text-end">
                                        <div class="flex gap-2 justify-end">
                                            @if (showRouteExists('dashboard.core.roles'))
                                                @include('components.elements.show-button', [
                                                    'models' => 'dashboard.core.roles',
                                                    'id' => $role->id,
                                                ])
                                            @endif

                                            @if (getActiveUser()->can('update', $role))
                                                @include('components.elements.edit-button', [
                                                    'models' => 'dashboard.core.roles',
                                                    'id' => $role->id,
                                                ])
                                            @endif

                                            @if (getActiveUser()->can('delete', $role))
                                                @include('components.elements.delete-button', [
                                                    'id' => $role->id,
                                                    'models' => 'dashboard.core.roles',
                                                ])
                                            @endif

                                            @if (getActiveUser()->can('delete', $role))
                                                @include('components.elements.forceDelete-button', [
                                                    'id' => $role->id,
                                                ])
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

        </div>
    </div>

    @if (isset($data) && !empty($data) && $data->count() > 0)
        @include('includes.pagination', ['data' => $data])
    @endif
</div>
