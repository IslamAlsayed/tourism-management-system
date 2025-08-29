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
                <table class="kt-table table-auto" data-kt-datatable-table="true">
                    <thead>
                        <tr>
                            <th class="w-[60px] px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCountries" class="kt-checkbox kt-checkbox-sm">
                            </th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.id') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.user') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.phone') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.position') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('main.created_at') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <td class="text-center">
                                    <input class="kt-checkbox kt-checkbox-sm" data-kt-datatable-row-check="true"
                                        type="checkbox" value="1" />
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $user->id }}</td>
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
                                <td>{{ $user->phone ?? ($user->mobile ?? '--') }}</td>
                                <td>{{ $user->position ?? '--' }}</td>
                                <td>
                                    <span class="text-{{ $user->is_active == 1 ? 'green' : 'red' }}-600 font-semibold">
                                        {{ $user->is_active == 1 ? __('main.active') : __('main.inactive') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $user->created_at ? $user->created_at->format('Y-m-d') : '' }}</td>
                                <td class="px-4 py-2 text-end">
                                    <div>
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-primary text-white">
                                            {{ __('main.edit') }}
                                        </a>

                                        <a href="{{ route('users.destroy', $user->id) }}"
                                            class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
