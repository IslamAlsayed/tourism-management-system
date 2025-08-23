<div class="kt-card kt-card-grid min-w-full">
    @component('includes.search', [
        'data' => $data,
        'count' => $data->count(),
        'totalCount' => $totalCount,
    ])
    @endcomponent

    <div class="kt-card-content">
        <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
            <div class="kt-scrollable-x-auto">
                <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] text-center">
                                <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-check="true"
                                    type="checkbox" />
                            </th>
                            <th class="min-w-[300px]">
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">Currency Name</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">Currency Code</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">Symbol</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th class="w-[60px]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $currency)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>
                                    <a href="{{ route('countries.edit', $currency->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div
                class="kt-card-footer justify-center md:justify-between flex-col md:flex-row gap-5 text-secondary-foreground text-sm font-medium">
                <div class="flex items-center gap-2 order-2 md:order-1">
                    Show
                    <select class="kt-select w-16" data-kt-datatable-size="true" data-kt-select=""
                        name="perpage"></select>
                    per page
                </div>
                <div class="flex items-center gap-4 order-1 md:order-2">
                    <span data-kt-datatable-info="true"></span>
                    <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"></div>
                </div>
            </div>
        </div>
    </div>
</div>
