<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => __('main.countries'),
        'entityName' => __('main.country'),
        'showSearch' => true,
    ])
    @endcomponent

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
                                {{ __('main.country_name') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.currency') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $country)
                            <tr wire:key="{{ $country->id }}" class="hover:bg-gray-100">
                                <td>
                                    <input type="checkbox" class="kt-checkbox kt-checkbox-sm country-checkbox"
                                        value="{{ $country->id }}">
                                </td>
                                <td>{!! highlightSearch($country->id, $search) !!}</td>
                                <td>
                                    <img src="{{ asset('metronic/media/flags/' . strtolower($country->flag_emoji) . '.svg') }}"
                                        alt="{{ $country->name }}" class="inline-block w-6 h-4 mr-2 align-middle">
                                    <span class="font-medium text-mono">
                                        {{ $country->name }}
                                        {!! highlightSearch($country->name ?? '--', $search) !!}
                                    </span>
                                </td>
                                <td>{!! highlightSearch($country->currency?->code ?? '--', $search) !!}</td>
                                <td>
                                    <span
                                        class="text-{{ $country->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                                        {!! highlightSearch($country->is_active == 1 ? __('main.active') : __('main.inactive'), $search) !!}
                                    </span>
                                </td>
                                <td>{!! highlightSearch($country->created_at?->format('Y-m-d') ?? '--', $search) !!}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('countries.edit', $country->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        @include('components.elements.delete-button', [
                                            'id' => $country->id,
                                        ])
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
