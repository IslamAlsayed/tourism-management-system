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
                    @if ($column == 'uuid' && $settings->app_show_uuid_column == 0)
                        @continue
                    @endif
                    <th wire:click="sortBy('{{ $column }}')" title="{{ __('main.sort_by') }} {{ __('main.' . $column) }}"
                        class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-50 transition-colors">
                        {{ __('main.' . $column) }}
                        <i class="fas {{ $this->getSortIcon($column) }} ms-2" style="font-size: 14px; {{ $this->isSortedBy($column) ? 'color: #3b82f6;' : '' }}"></i>
                    </th>
                @endforeach
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody id="data_table_tbody">
            @forelse ($data as $item)
                <tr wire:key="row-{{ $item->id }}" class="hover:bg-gray-100 unique-record-{{ $item->id }}">
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
                        ])
                    @endforeach
                    <td class="px-4 py-2 text-end">
                        <div class="flex gap-2 justify-end">
                            @if (isset($models) && showRouteExists($models) && showFunctionExists($models) && getActiveUser()->can('view', $item))
                                @include('components.elements.show-button', [
                                    'models' => $models,
                                    'id' => $item->id,
                                ])
                            @endif

                            @if (isset($models) && $models != 'notifications' && getActiveUser()->can('update', $item))
                                @include('components.elements.edit-button', [
                                    'models' => $models,
                                    'id' => $item->id,
                                ])
                            @endif

                            @if (isset($models) && $models == 'notifications' && $item->data && isset($item->data['cta_url']))
                                <a href="{{ $item->data['cta_url'] }}" class="kt-btn kt-btn-sm kt-btn-primary" target="_blank">
                                    {{ $item->data['cta_text'] ?? __('main.view_action') }}
                                </a>
                            @endif

                            @if (isset($models) && getActiveUser()->can('delete', $item))
                                @include('components.elements.delete-button', ['id' => $item->id])
                            @endif

                            @if (isset($models) && getActiveUser()->can('forceDelete', $item))
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
