<div class="kt-card kt-card-grid min-w-full">
    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto text-nowrap">
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
                                {{ __('main.name_ar') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.country') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.city') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.is_active') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $restaurant)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selectedItems[]" value="{{ $restaurant->id }}"
                                        class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                                </td>
                                <td>{!! highlightSearch($restaurant->id, $search) !!}</td>
                                <td>{!! highlightSearch($restaurant->name ?? '--', $search) !!}</td>
                                <td>{!! highlightSearch($restaurant->name_ar ?? '--', $search) !!}</td>
                                <td>{!! highlightSearch($restaurant->country?->name ?? 'unknown', $search) !!}</td>
                                <td>{!! highlightSearch($restaurant->city?->name ?? 'unknown', $search) !!}</td>
                                <td>
                                    <span
                                        class="text-{{ $restaurant->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                                        {!! highlightSearch($restaurant->is_active == 1 ? __('main.active') : __('main.inactive'), $search) !!}
                                    </span>
                                </td>
                                <td>{!! highlightSearch($restaurant->created_at?->format('Y-m-d') ?? '--', $search) !!}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('restaurants.edit', $restaurant->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('restaurants.destroy', $restaurant->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}"
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
