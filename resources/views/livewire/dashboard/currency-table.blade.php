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
                <table class="kt-table table-auto kt-table-border" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] text-center">
                                <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-check="true"
                                    type="checkbox" />
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.currency_name') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.currency_code') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.symbol') }}</span>
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
