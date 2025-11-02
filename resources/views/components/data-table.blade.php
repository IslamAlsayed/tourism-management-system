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
                <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('main.' . $column) }}
                </th>
            @endforeach
            <th class="px-4 py-3"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
            <tr wire:key="{{ $item->id }}" class="hover:bg-gray-100">
                <td class="text-center">
                    @include('components.elements.all-checkbox-button', [
                        'name' => 'selectedItems[]',
                        'id' => 'selectedItems' . $item->id,
                    ])
                </td>
                @foreach ($columns as $column)
                    @include('components.static-columns', [
                        'column' => $column,
                        'model' => $item,
                        'search' => $search,
                    ])
                @endforeach
                <td class="px-4 py-2 text-end">
                    <div>
                        @if (isset($models))
                            @include('components.elements.edit-button', [
                                'models' => $models,
                                'id' => $item->id,
                            ])
                        @endif

                        @include('components.elements.delete-button', [
                            'id' => $item->id,
                        ])
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) + 2 }}" class="px-4 py-3 text-center text-gray-500">
                    <div class="w-[90px] h-[90px] mx-auto my-4">
                        <img src="{{ asset('assets/images/other/no-data.svg') }}" alt="no data">
                    </div>
                    <p>{{ __('main.messages.no_records_found') }}</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
