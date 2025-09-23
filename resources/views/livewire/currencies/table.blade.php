<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => __('main.currencies'),
        'entityName' => __('main.currency'),
        'showSearch' => true,
    ])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto" class="kt-table table-auto text-nowrap" data>
                    <thead>
                        <tr>
                            <th class="w-[60px] px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllItems" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.code') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.symbol') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $currency)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selectedItems[]" value="{{ $currency->id }}"
                                        class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                                </td>
                                <td>{!! highlightSearch($currency->id, $search) !!}</td>
                                <td>{!! highlightSearch($currency->name ?? '--', $search) !!}</td>
                                <td>{!! highlightSearch($currency->code, $search) !!}</td>
                                <td>{!! highlightSearch($currency->symbol, $search) !!}</td>
                                <td>
                                    <span
                                        class="text-{{ $currency->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                                        {!! $currency->is_active == 1
                                            ? highlightSearch(__('main.active'), $search)
                                            : highlightSearch(__('main.inactive'), $search) !!}
                                    </span>
                                </td>
                                <td>{!! highlightSearch($currency->created_at?->format('Y-m-d') ?? '--', $search) !!}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('currencies.edit', $currency->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('currencies.destroy', $currency->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('currencies.destroy', $currency->id) }}"
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
