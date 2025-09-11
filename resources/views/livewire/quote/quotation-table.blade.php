<div class="kt-card kt-card-grid min-w-full">
    {{-- @component('includes.pagination-info', [
    'data' => $data,
    'title' => __('main.user_management'),
    'entityName' => __('main.user'),
    'showSearch' => true,
])
    @endcomponent --}}

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCountries" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.adults') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.arrival_date') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.departure_date') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.nights') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.grand_total') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $book)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $book->id }}</td>
                                <td>
                                    <span
                                        class="text-{{ $book->status == 'submitted' ? 'green' : ($book->status == 'cancelled' ? 'red' : 'gray') }}-600 font-semibold">
                                        {{ $book->status }}
                                    </span>
                                </td>
                                <td>{{ $book->adults }}</td>
                                <td>{{ $book->arrival_date }}</td>
                                <td>{{ $book->departure_date }}</td>
                                <td>{{ $book->nights }}</td>
                                <td>{{ $book->grand_total }}</td>
                                <td>
                                    {{ $book->created_at ? $book->created_at->format('Y-m-d') : '' }}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="/" class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="/" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="/" method="POST">
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
            {{-- @include('includes.pagination', ['data' => $data]) --}}
        </div>
    </div>
</div>
