<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => __('main.accommodations'),
        'entityName' => __('main.accommodation'),
        'showSearch' => true,
    ])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllItems" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.name') }}
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.name_ar') }}
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}
                            </th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $accommodation)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selectedItems[]" value="{{ $accommodation->id }}"
                                        class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true" />
                                </td>
                                <td>{!! highlightSearch($accommodation->id, $search) !!}</td>
                                <td>{!! highlightSearch($accommodation->name ?? '--', $search) !!}</td>
                                <td>{!! highlightSearch($accommodation->name_ar ?? '--', $search) !!}</td>
                                <td>{!! highlightSearch($accommodation->created_at?->format('Y-m-d') ?? '--', $search) !!}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('accommodations.edit', $accommodation->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('accommodations.destroy', $accommodation->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('accommodations.destroy', $accommodation->id) }}"
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
