<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'title' => __('main.user_management'),
        'entityName' => __('main.user'),
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
                            <th class="min-w-[300px]">
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.user') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.phone') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.department') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.position') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.status') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th>
                                <span class="kt-table-col">
                                    <span class="kt-table-col-label">{{ __('main.created_at') }}</span>
                                    <span class="kt-table-col-sort"></span>
                                </span>
                            </th>
                            <th class="w-[60px]"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : asset('metronic/media/avatars/blank.png') }}"
                                            alt="{{ $user->name }}" class="rounded-full size-9 shrink-0">
                                        <div class="flex flex-col">
                                            <a class="text-sm font-medium text-mono hover:text-primary mb-px"
                                                href="#">
                                                {{ $user->name }}
                                            </a>
                                            <a class="text-sm text-secondary-foreground font-normal hover:text-primary"
                                                href="#">
                                                {{ $user->email }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->phone ?? $user->mobile }}</td>
                                <td>{{ $user->department }}</td>
                                <td>{{ $user->position }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="text-green-600 font-semibold">{{ __('main.active') }}</span>
                                    @else
                                        <span class="text-red-600 font-semibold">{{ __('main.inactive') }}</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '' }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="kt-btn kt-btn-sm kt-btn-primary">{{ __('main.edit') }}</a>
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
