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
                @foreach ($columns as $column)
                    @if ($column == 'uuid' && optional($settings)->app_show_uuid_column == 0)
                        @continue
                    @endif
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider relative group">
                        <div class="flex items-center justify-between min-w-[120px]">
                            {{-- Clickable Sort Area --}}
                            <div wire:click="sortBy('{{ $column }}')"
                                title="{{ __('main.sort_by') }} {{ __('main.' . $column) }}"
                                class="flex items-center cursor-pointer hover:text-primary transition-colors flex-grow">
                                {{ __('main.' . $column) }}
                                <i class="fas {{ $this->getSortIcon($column) }} ms-2 text-[10px]"
                                    style="{{ $this->isSortedBy($column) ? 'color: #3b82f6;' : '' }}"></i>
                            </div>

                            {{-- Filter Dropdown (Livewire.dispatch approach for fixed-position dropdown) --}}
                            <div class="relative"
                                x-data="{
                                    open: false,
                                    fixedTop: 0,
                                    fixedLeft: 0,
                                    toggle(btn) {
                                        const rect = btn.getBoundingClientRect();
                                        this.fixedTop = rect.bottom + 4;
                                        this.fixedLeft = rect.left;
                                        this.open = !this.open;
                                    },
                                    close() { this.open = false; }
                                }"
                                @click.outside="close()"
                                x-cloak>
                                <button type="button"
                                    @click="toggle($el)"
                                    class="btn btn-sm btn-icon btn-clear btn-light text-gray-400 hover:text-primary {{ isset($searchColumns[$column]) && !empty($searchColumns[$column]) ? '!text-primary' : '' }}"
                                    title="{{ __('main.filter_by') }} {{ __('main.' . $column) }}">
                                    <i class="ki-outline ki-filter text-lg"></i>
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
                                        class="bg-white dark:bg-[#1e1e2d] border border-gray-200 dark:border-gray-600 rounded-xl shadow-2xl p-4 text-start"
                                        @click.outside="close()">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                                        {{ __('main.search_in') }} {{ __('main.' . $column) }}
                                    </label>
                                    <div class="relative flex items-center gap-2 bg-gray-50 dark:bg-gray-800 rounded-lg px-3 py-2 border border-gray-200 focus-within:border-primary focus-within:ring-1 focus-within:ring-primary overflow-hidden">
                                        <i class="ki-outline ki-magnifier text-gray-400 text-sm flex-shrink-0"></i>
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
                                        
                                        @if(isset($searchColumns[$column]) && !empty($searchColumns[$column]))
                                            <div class="absolute end-2 flex items-center justify-center p-1 cursor-pointer group" 
                                                @click.prevent="
                                                    Livewire.dispatch('filterColumn', { column: '{{ $column }}', value: '' });
                                                    $el.closest('.relative').querySelector('input').value = '';
                                                    close()
                                                ">
                                                <i class="ki-outline ki-cross text-gray-400 group-hover:text-red-500 text-sm transition-colors"></i>
                                            </div>
                                        @endif
                                    </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </th>
                @endforeach
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody id="data_table_tbody">
            @forelse ($data as $item)
                <tr wire:key="row-{{ $item->id }}" class="hover:bg-primary/10 transition-colors cursor-pointer unique-record-{{ $item->id }}">
                    <td class="text-center">
                        @include('components.elements.checkbox-button', [
                            'name' => 'selectItem[]',
                            'id' => 'selectItem' . $item->id,
                            'value' => $item->id,
                            'checked' => in_array($item->id, $selectedIds),
                        ])
                    </td>
                    @foreach ($columns as $column)
                        @include('components.static-columns', [
                            'column' => $column,
                            'model' => $item,
                            'search' => $search,
                            'models' => $models,
                            'rowIndex' => method_exists($data, 'currentPage') ? ($data->currentPage() - 1) * $data->perPage() + $loop->parent->iteration : $loop->parent->iteration,
                        ])
                    @endforeach
                    <td class="px-4 py-2 text-end">
                        <div class="flex gap-2 justify-end">
                            @if (isset($models) && (getActiveUser()->hasRole('superadmin') || getActiveUser()->can('view', $item)))
                                @include('components.elements.show-button', [
                                    'models' => $models,
                                    'id' => $item->id,
                                ])
                            @endif

                            @if (isset($models) && $models != 'notifications' && (getActiveUser()->hasRole('superadmin') || getActiveUser()->can('update', $item)))
                                @include('components.elements.edit-button', [
                                    'models' => $models,
                                    'id' => $item->id,
                                ])
                            @endif

                            @if (isset($models) && $models == 'notifications' && $item->data && isset($item->data['cta_url']))
                                <a href="{{ $item->data['cta_url'] }}" class="kt-btn kt-btn-sm kt-btn-primary"
                                    target="_blank">
                                    {{ $item->data['cta_text'] ?? __('main.view_action') }}
                                </a>
                            @endif

                            @if (isset($models) && (getActiveUser()->hasRole('superadmin') || getActiveUser()->can('delete', $item)))
                                @include('components.elements.delete-button', ['id' => $item->id])
                            @endif

                            @if (isset($models) && (getActiveUser()->hasRole('superadmin') || getActiveUser()->can('forceDelete', $item)))
                                @include('components.elements.forceDelete-button', ['id' => $item->id])
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

{{-- <script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('refresh-page', () => setTimeout(() => location.reload(), 0));
    });
</script> --}}
