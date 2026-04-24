@php
    $tableColumnsForLoop = isset($allColumns) && !empty($allColumns) ? $allColumns : $columns;
@endphp

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
    <div class="top-scroll w-full overflow-x-auto overflow-y-hidden custom-scrollbar" id="topScroll" x-ref="topScroll" @scroll="syncTop" wire:ignore style="scrollbar-color: #2563eb rgba(37,99,235,0.08);">
        <div class="top-scroll-inner" id="topScrollInner" x-ref="dummyContent" style="height: 1px;"></div>
    </div>

<div class="table-wrapper w-full overflow-x-auto custom-scrollbar" id="tableWrapper" x-ref="bottomScroll" @scroll="syncBottom">
    <table x-ref="actualTable" class="kt-table table-auto text-nowrap" id="data_table"
           x-data="{ 
               liveCols: JSON.parse('{{ addslashes(json_encode($columns)) }}'), 
               selectedIds: @entangle('selectedIds').live,
               pageIds: JSON.parse('{{ isset($data) && count($data) > 0 ? addslashes(json_encode(array_values(array_map('strval', $data->pluck('id')->toArray())))) : '[]' }}'),
               init() { 
                   document.addEventListener('live-cols-update', e => { this.liveCols = e.detail.cols; }); 
               }, 
               colVisible(col) { 
                   return this.liveCols.includes(col); 
               },
               get allSelected() {
                   return this.pageIds.length > 0 && this.pageIds.every(id => this.selectedIds.map(String).includes(String(id)));
               },
               toggleAll() {
                   let isAllSelected = this.allSelected;
                   if (isAllSelected) {
                       this.selectedIds = this.selectedIds.filter(id => !this.pageIds.includes(String(id)));
                   } else {
                       let newSet = new Set(this.selectedIds.map(String));
                       this.pageIds.forEach(id => newSet.add(String(id)));
                       this.selectedIds = Array.from(newSet);
                   }
               }
           }">
        <thead>
            <tr wire:key="header-row-{{ md5(implode(',', $columns)) }}">
                <th class="w-[60px] px-4 py-3 text-center" style="padding-inline-start: 21px">
                    @if (isset($data) && !empty($data) && $data->count() > 0)
                        <div class="custom-input cursor-pointer">
                            <input type="checkbox" name="selectPage" id="selectPage{{ md5(implode(',', $columns)) }}"
                                :checked="allSelected"
                                @click="toggleAll()">
                            <label for="selectPage{{ md5(implode(',', $columns)) }}"></label>
                        </div>
                    @endif
                </th>
                @foreach ($tableColumnsForLoop as $column)
                    @if ($column == 'uuid' && optional($settings)->app_show_uuid_column == 0)
                        @continue
                    @endif
                    <th wire:key="th-{{ $column }}" 
                        x-show="colVisible('{{ $column }}')" x-transition
                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider relative group">
                        <div class="flex items-center gap-2 min-w-[120px]">
                            
                            {{-- Clickable Sort Area & Title --}}
                            <div class="flex items-center gap-1 cursor-pointer hover:text-primary transition-colors">
                                <span class="uppercase" wire:click="sortBy('{{ $column }}')" title="{{ __('main.sort_by') }} {{ __('main.' . $column) }}">
                                    {{ __('main.' . $column) }}
                                </span>
                                
                                {{-- Sort Icon Logic --}}
                                <div wire:click="sortBy('{{ $column }}')" class="flex items-center">
                                    @if (isset($sortColumn) && $sortColumn == $column)
                                        @if (isset($sortDirection) && $sortDirection == 'asc')
                                            <i class="fa-duotone fa-solid fa-arrow-up text-primary ms-1 text-xs"></i>
                                        @else
                                            <i class="fa-duotone fa-solid fa-arrow-down text-primary ms-1 text-xs"></i>
                                        @endif
                                    @else
                                        <i class="fa-duotone fa-solid fa-arrow-up-down text-gray-400 ms-1 opacity-0 group-hover:opacity-100 transition-opacity text-xs"></i>
                                    @endif
                                </div>

                                {{-- Filter Funnel Icon (Integrated into Header) --}}
                                <div class="relative ms-1 flex items-center"
                                    x-show="!$store.filtersVisibility || $store.filtersVisibility.filters['search_filter_{{ $column }}'] !== false"
                                    x-data="{
                                        open: false,
                                        colId: 'search_filter_{{ $column }}',
                                        fixedTop: 0,
                                        fixedLeft: 0,
                                        toggle(btn) {
                                            $dispatch('close-all-search-popups');
                                            const rect = btn.getBoundingClientRect();
                                            this.fixedTop = rect.bottom + 4;
                                            this.fixedLeft = rect.left;
                                            this.open = true;
                                        },
                                        close() { this.open = false; }
                                    }"
                                    @close-all-search-popups.window="if (open) close()"
                                    @click.outside="close()"
                                    x-cloak>
                                    <button type="button"
                                        @click.prevent.stop="open ? close() : toggle($el)"
                                        class="text-gray-400 hover:text-primary {{ !empty($searchColumns[$column] ?? null) ? '!text-primary' : '' }} cursor-pointer"
                                        title="{{ __('main.filter_by') }} {{ __('main.' . $column) }}">
                                        <i class="fa-duotone fa-solid fa-filter text-sm"></i>
                                    </button>

                                <template x-teleport="body">
                                    {{-- Dropdown Panel: fixed via style, dispatches Livewire event --}}
                                    <div x-show="open"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        :style="`position:fixed; top:${fixedTop}px; left:${fixedLeft}px; z-index:99999; width:280px;`"
                                        class="bg-white dark:bg-gray-800 border border-indigo-200 dark:border-indigo-700/50 rounded-xl shadow-2xl p-4 text-start"
                                        @click.outside="close()">
                                    <label class="block text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase mb-2">
                                        {{ __('main.search_in') }} {{ __('main.' . $column) }}
                                    </label>
                                    <div class="relative flex items-center gap-2 bg-gray-50 dark:bg-gray-900 rounded-lg px-3 py-2 border border-indigo-200 dark:border-indigo-700/50 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 overflow-hidden">
                                        <i class="fa-duotone fa-solid fa-magnifying-glass text-gray-400 text-sm flex-shrink-0"></i>
                                        <input type="text"
                                            value="{{ $searchColumns[$column] ?? '' }}"
                                            @input.debounce.500ms="
                                                Livewire.dispatch('filterColumn', {
                                                    column: '{{ $column }}',
                                                    value: $event.target.value
                                                })
                                            "
                                            @keydown.enter.prevent=""
                                            @click.stop
                                            class="flex-1 bg-transparent text-sm text-gray-800 dark:text-gray-200 placeholder-gray-400 outline-none border-transparent focus:border-transparent focus:ring-0 focus:outline-none shadow-none p-0 pe-6"
                                            placeholder="{{ __('main.type_to_search') }}..."
                                            autocomplete="off" />
                                        
                                        @if(!empty($searchColumns[$column] ?? null))
                                            <div class="absolute end-2 flex items-center justify-center p-1 cursor-pointer group" 
                                                @click.prevent="
                                                    Livewire.dispatch('filterColumn', { column: '{{ $column }}', value: '' });
                                                    $el.closest('.relative').querySelector('input').value = '';
                                                    close()
                                                ">
                                                <i class="fa-duotone fa-solid fa-xmark text-gray-400 group-hover:text-red-500 text-sm transition-colors"></i>
                                            </div>
                                        @endif
                                    </div>
                                    </div>
                                </template>
                            </div>
                         </div>
                    </th>
                @endforeach
                <th class="px-4 py-3 text-end min-w-[120px]"
                    x-show="!$store.filtersVisibility || ['show','edit','delete','force_delete'].some(k => $store.filtersVisibility.filters[k] !== false)">
                    {{ __('main.actions') }}
                </th>
            </tr>
        </thead>
        <tbody id="data_table_tbody">
            @forelse ($data as $item)
                <tr wire:key="row-{{ $item->id }}-{{ md5(implode(',', $columns)) }}" class="hover:bg-primary/10 transition-colors cursor-pointer unique-record-{{ $item->id }}">
                    <td class="text-center">
                        <div class="custom-input">
                            <input type="checkbox" name="selectItem[]" id="selectItem{{ $item->id }}" 
                                x-model="selectedIds"
                                value="{{ $item->id }}">
                            <label for="selectItem{{ $item->id }}"></label>
                        </div>
                    </td>
                    @foreach ($tableColumnsForLoop as $column)
                        <template x-if="colVisible('{{ $column }}')">
                            @include('components.static-columns', [
                                'column' => $column,
                                'model' => $item,
                                'search' => $search,
                                'models' => $models,
                                'rowIndex' => method_exists($data, 'currentPage') ? ($data->currentPage() - 1) * $data->perPage() + $loop->parent->iteration : $loop->parent->iteration,
                            ])
                        </template>
                    @endforeach
                    {{-- Actions Column — KTUI 3-Dot Dropdown --}}
                    <td class="px-4 py-2 text-end"
                        x-show="!$store.filtersVisibility || ['show','edit','delete','force_delete'].some(k => $store.filtersVisibility.filters[k] !== false)">
                        @if (Auth::check() && isset($models))
                            @include('components.elements.action-dropdown', [
                                'id' => $item->id,
                                'models' => $models,
                                'item' => $item,
                            ])
                        @elseif (Auth::check())
                            @include('components.elements.action-dropdown', [
                                'id' => $item->id,
                                'item' => $item,
                            ])
                        @endif
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

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('refresh-page', () => setTimeout(() => location.reload(), 0));
    });

    // Event Delegation: Handle delete & forceDelete from action dropdown menus
    (function() {
        const tableBody = document.getElementById('data_table_tbody');
        if (!tableBody) return;

        tableBody.addEventListener('click', function(e) {
            const trigger = e.target.closest('.action-delete-trigger');
            if (!trigger) return;

            e.preventDefault();
            e.stopPropagation();

            const action = trigger.getAttribute('data-action');
            const recordId = trigger.getAttribute('data-record-id');
            if (!recordId) return;

            const isForce = (action === 'forceDelete');

            Swal.fire({
                title: isForce
                    ? '⚠️ {{ addslashes(__("messages.are_you_sure")) }}'
                    : '{{ addslashes(__("messages.are_you_sure")) }}',
                html: isForce
                    ? '<p style="color:#dc2626;font-weight:600;">{{ addslashes(__("messages.are_you_sure_force_delete")) }}</p><p style="color:#6b7280;font-size:0.85rem;margin-top:6px;">{{ addslashes(__("messages.force_delete_warning")) }}</p>'
                    : '{{ addslashes(__("messages.are_you_sure_delete")) }}',
                icon: isForce ? 'error' : 'warning',
                showCancelButton: true,
                confirmButtonColor: isForce ? '#7f1d1d' : '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: isForce
                    ? '<i class="fa-duotone fa-solid fa-trash-square me-1"></i> {{ addslashes(__("main.force_delete")) }}'
                    : '<i class="fa-duotone fa-solid fa-trash me-1"></i> {{ addslashes(__("main.delete")) }}',
                cancelButtonText: '{{ addslashes(__("main.cancel")) }}',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const comp = trigger.closest('[wire\\:id]');
                    if (comp) {
                        const lwMethod = isForce ? 'forceDelete' : 'destroy';
                        window.Livewire.find(comp.getAttribute('wire:id')).call(lwMethod, recordId);
                    }
                }
            });
        });
    })();
</script>
