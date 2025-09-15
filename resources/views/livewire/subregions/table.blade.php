<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => __('main.subregions'),
        'entityName' => __('main.subregion'),
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
                                <input type="checkbox" id="selectAllSubRegions" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.name_ar') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $subregion)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td>{{ $subregion->id }}</td>
                                <td>{{ $subregion->name }}</td>
                                <td>{{ $subregion->name_ar }}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('subregions.edit', $subregion->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('subregions.destroy', $subregion->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('subregions.destroy', $subregion->id) }}"
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
