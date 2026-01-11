<div class="kt-card kt-card-grid min-w-full">
    @component('includes.pagination-info', [
        'data' => $data,
        'columns' => $columns ?? [],
        'title' => __('activity.activity_logs'),
        'entityName' => __('activity.activity_log'),
        'searchValue' => $search ?? null,
        'showSearch' => true,
    ])
        @if (isset($data) && !empty($data) && $data->count() > 0 && isset($allColumns))
            @include('components.columns', [
                'allColumns' => $allColumns ?? [],
                'selectedIds' => $selectedIds ?? [],
            ])
        @endif
    @endcomponent

    <div class="kt-card-body space-y-6 px-3">
        @if (isset($data) && count($data) > 0)
            {{-- Cards totals --}}
            <div class="grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-4">
                <div class="rounded-lg border border-gray-200 background p-4 shadow-sm">
                    <p class="text-sm text-gray-600">{{ __('activity.activity_total_events') }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-600">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 background p-4 shadow-sm">
                    <p class="text-sm text-gray-600">{{ __('activity.activity_model_events') }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-600">{{ number_format($stats['models']) }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 background p-4 shadow-sm">
                    <p class="text-sm text-gray-600">{{ __('activity.activity_system_events') }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-600">{{ number_format($stats['system']) }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 background p-4 shadow-sm">
                    <p class="text-sm text-gray-600">{{ __('activity.activity_error_events') }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-600">{{ number_format($stats['errors']) }}</p>
                </div>
            </div>

            {{-- Activity Breakdown --}}
            <div class="rounded-lg border border-dashed border-gray-200 background mb-4 p-4"
                id="activity-breakdown-container">
                <h3 class="text-sm font-semibold text-gray-600">{{ __('activity.activity_breakdown_title') }}</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    <div>
                        @forelse ($breakdown as $row)
                            @php
                                $rowBadgeClass = badgeClasses($row->event ?? 'unknown');
                            @endphp
                            <li wire:key="activity-breakdown-{{ $row->event }}"
                                class="flex items-center font-semibold justify-center gap-2 {{ $rowBadgeClass }} rounded-full ps-3 px-1 py-1">
                                <span>{{ __('main.' . $row->event ?? 'unknown') }}</span>
                                <span
                                    class="rounded-full px-2 py-0.5 text-xs font-medium bg-gray-50">{{ $row->total }}</span>
                            </li>
                        @empty
                            <li class="text-gray-400">{{ __('main.no_data_available') }}</li>
                        @endforelse
                    </div>
                </ul>
            </div>

            {{-- Filters --}}
            <div class="gap-2 md:gap-4 mb-4 px-1" id="activity-filters-container">
                <div class="space-y-1">
                    <label for="filter-log"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_log_type') }}</label>
                    <select id="filter-log" class="kt-select h-[45px]" wire:model.live="filterLog">
                        <option value="">--</option>
                        @foreach ($logNames as $logName)
                            <option wire:key="logName-{{ $logName }}" value="{{ $logName }}">
                                {{ __('main.' . $logName) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="filter-event"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_event_type') }}</label>
                    <select id="filter-event" class="kt-select h-[45px]" wire:model.live="filterEvent">
                        <option value="">--</option>
                        @foreach ($events as $event)
                            <option wire:key="event-{{ $event }}" value="{{ $event }}">
                                {{ __('main.' . $event) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="filter-user"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_user_filter') }}</label>
                    <select id="filter-user" class="kt-select h-[45px]" wire:model.live="filterUser">
                        <option value="">--</option>
                        @foreach ($users as $user)
                            <option wire:key="user-{{ $user->id }}" value="{{ $user->id }}">
                                {{ $user->name ?? $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-1">
                    <label for="date-from"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_date_from') }}</label>
                    <input id="date-from" type="datetime-local" class="kt-input h-[45px]" wire:model.live="dateFrom">
                </div>
                <div class="space-y-1">
                    <label for="date-to"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_date_to') }}</label>
                    <input id="date-to" type="datetime-local" class="kt-input h-[45px]" wire:model.live="dateTo">
                </div>
                <div class="flex items-end gap-2">
                    @if (isset($dateFrom) || isset($dateTo) || $filterLog != '' || $filterEvent != '' || $filterUser != '')
                        <button type="button" wire:click="resetFilters" title="{{ __('main.reset_filters') }}"
                            toggle-button
                            class="kt-btn bg-primary/30 text-blue-600 px-3 h-[45px] hover:bg-gray-50 transition-colors">
                            <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                            <span class="text-sm">{{ __('main.reset_filters') }}</span>
                        </button>
                    @endif
                    @if ($filterLog != '')
                        <button type="button" class="kt-btn bg-danger h-[45px]"
                            wire:click="clearLog('{{ $filterLog }}')" wire:confirm="{{ __('main.are_you_sure') }}">
                            <i class="ki-filled ki-trash me-1"></i>
                            {{ __('activity.activity_clear_current_log') }}
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- Selected Activity --}}
        @if (!empty($selectedActivity))
            <div class="rounded-lg border border-blue-200 bg-blue-50 mb-4 p-4"
                wire:target="selectedActivity,closeDetails" wire:loading.class="loading">
                <div class="flex items-center justify-between gap-2 activity-details-header">
                    <h3 class="text-sm font-semibold text-blue-900">{{ __('activity.activity_selected_title') }}
                    </h3>
                    <button type="button" wire:click="closeDetails" toggle-button
                        class="kt-btn bg-danger text-xs text-white font-medium text-blue-700 cursor-pointer hover:underline h-[26px]">

                        @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                            {!! $text ?? __('main.close') !!}
                        @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                            <i class="fas fa-times text-white"></i>
                        @else
                            <i class="fas fa-times text-white"></i>
                            {!! $text ?? __('main.close') !!}
                        @endif
                    </button>
                </div>
                <dl class="mt-3 space-y-1 text-xs text-blue-900">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center justify-between">
                            <dt>{{ __('activity.activity_id') }}</dt>
                            <dd>#{{ $selectedActivity['id'] }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>{{ __('activity.activity_timestamp') }}</dt>
                            <dd>{{ $selectedActivity['created_at'] }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>{{ __('activity.activity_log_type') }}</dt>
                            <dd>{{ ucfirst($selectedActivity['log_name']) }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt>{{ __('activity.activity_event_type') }}</dt>
                            <dd
                                class="rounded-full px-2 py-0.5 text-xs font-medium {{ badgeClasses($selectedActivity['event']) }}">
                                {{ ucfirst($selectedActivity['event']) }}</dd>
                        </div>
                        @if ($selectedActivity['causer'])
                            <div class="flex items-center justify-between">
                                <dt>{{ __('activity.activity_causer') }}</dt>
                                <dd>
                                    {{ $selectedActivity['causer']['name'] ?? $selectedActivity['causer']['email'] }}
                                </dd>
                            </div>
                        @endif
                        @if ($selectedActivity['subject'])
                            <div class="flex items-center justify-between">
                                <dt>{{ __('activity.activity_subject') }}</dt>
                                <dd>{{ $selectedActivity['subject']['label'] }}</dd>
                            </div>
                        @endif
                    </div>
                </dl>
                <div class="mt-3 rounded bg-blue-100 p-3 text-xs text-blue-900">
                    <p class="font-semibold">{{ __('activity.activity_description') }}</p>
                    <p class="mt-1 whitespace-pre-wrap">{{ $selectedActivity['description'] }}</p>
                </div>
                <div class="mt-3">
                    <p class="text-xs font-semibold text-blue-900">{{ __('activity.activity_properties') }}</p>
                    <pre class="mt-2 max-h-48 overflow-auto rounded bg-white/70 p-3 text-[11px] text-blue-900">
                            {{ json_encode($selectedActivity['properties'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}
                        </pre>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="kt-card-content" wire:target="search,selectedActivity,closeDetails,viewDetails,delete"
            wire:loading.class="loading">
            <div data-kt-datatable="true" data-kt-datatable-state-save="false" id="team_crew_table">
                <div class="kt-scrollable-x-auto">
                    <table class="kt-table table-auto text-nowrap">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- <th scope="col" class="px-3 py-2">
                                    <input type="checkbox" class="kt-checkbox" wire:model.live="selectPage">
                                </th> --}}
                                <th wire:click="sortBy('id')" scope="col"
                                    title="{{ __('main.sort_by') }} {{ __('main.id') }}"
                                    class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 cursor-pointer hover:bg-gray-100">
                                    {{ __('main.id') }}
                                    <i class="fas {{ $this->getSortIcon('id') }} ms-2"
                                        style="font-size: 14px; {{ $this->isSortedBy('id') ? 'color: #3b82f6;' : '' }}"></i>
                                </th>
                                @if (isset($filterColumns) && $filterColumns)
                                    @foreach ($filterColumns as $column)
                                        <th wire:key="filterColumns-{{ $column['key'] }}"
                                            wire:click="sortBy('{{ $column['key'] }}')" scope="col"
                                            title="{{ __('main.sort_by') }} {{ __($column['label']) }}"
                                            class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-gray-500 cursor-pointer hover:bg-gray-100">
                                            {{ __($column['label']) }}
                                            <i class="fas {{ $this->getSortIcon($column['key']) }} ms-2"
                                                style="font-size: 14px; {{ $this->isSortedBy($column['key']) ? 'color: #3b82f6;' : '' }}"></i>
                                        </th>
                                    @endforeach
                                @endif
                                <th scope="col"
                                    class="px-3 py-2 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 background">
                            @forelse ($data as $activity)
                                @php $badgeClass = badgeClasses($activity->event); @endphp
                                <tr wire:key="activity-{{ $activity->id }}" class="hover:bg-gray-50">
                                    <td class="px-3 py-2">{!! highlightSearch($activity->id, $search) !!}</td>
                                    {{-- <td class="px-3 py-2">
                                        <input type="checkbox" class="kt-checkbox" wire:model.live="selectedIds"
                                            value="{{ $activity->id }}">
                                    </td> --}}
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        <div>
                                            {{ $activity->created_at?->format('Y-m-d H:i:s') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $activity->created_at?->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-sm">
                                        <span
                                            class="rounded-full px-2 py-0.5 text-xs font-medium w-full text-center inline-block {{ $badgeClass }}">
                                            {!! highlightSearch(__('main.' . $activity->event ?? 'unknown'), $search) !!}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        {!! highlightSearch(__('main.' . '_' . $activity->log_name ?? 'unknown'), $search) !!}
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        @if ($activity->causer)
                                            <div>{!! highlightSearch($activity->causer->name ?? $activity->causer->email, $search) !!}</div>
                                            @if ($activity->causer->email)
                                                <div class="text-xs text-gray-500">
                                                    {!! highlightSearch($activity->causer->email, $search) !!}
                                                </div>
                                            @endif
                                        @else
                                            <span
                                                class="text-xs text-gray-400">{{ __('activity.system_generated') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        @if ($activity->subject)
                                            <div>
                                                {!! highlightSearch(class_basename($activity->subject_type), $search) !!}
                                                #{!! highlightSearch($activity->subject_id, $search) !!}
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600"
                                        title="{{ activityMessageSummary($activity, 1000) }}">
                                        <div style="text-wrap: wrap;">
                                            {!! highlightSearch(activityMessageSummary($activity), $search) !!}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" class="kt-btn kt-btn-sm bg-primary"
                                                wire:click="viewDetails({{ $activity->id }})">

                                                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                                                    {!! $text ?? __('main.show') !!}
                                                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                                                    <i class="fas fa-eye text-white"></i>
                                                @else
                                                    <i class="fas fa-eye text-white"></i>
                                                    {!! $text ?? __('main.show') !!}
                                                @endif
                                            </button>
                                            <button type="button" class="kt-btn kt-btn-sm bg-danger"
                                                wire:click="delete({{ $activity->id }})"
                                                wire:confirm="{{ __('main.are_you_sure') }}">

                                                @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
                                                    {!! $text ?? __('main.delete') !!}
                                                @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
                                                    <i class="fas fa-trash-can text-white"></i>
                                                @else
                                                    <i class="fas fa-trash-can text-white"></i>
                                                    {!! $text ?? __('main.delete') !!}
                                                @endif
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr>
                                    <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-500">
                                        {{ __('main.no_data_available') }}
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td colspan="{{ count($filterColumns) + 2 }}"
                                        class="px-4 py-3 text-center text-gray-500">
                                        <div class="w-[90px] h-[90px] mx-auto my-4">
                                            <img src="{{ asset('assets/images/other/no-data.svg') }}" alt="no data">
                                        </div>
                                        <p class="text-red-600 font-semibold">
                                            {{ __('messages.no_records_found') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (!empty($selectedIds))
            <div
                class="flex items-center justify-between rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                <span>{{ __('main.selected_items', ['count' => count($selectedIds)]) }}</span>
                <div class="flex items-center gap-2">
                    <button type="button" class="kt-btn kt-btn-sm kt-btn-light"
                        wire:click="$set('selectedIds', [])">{{ __('activity.clear_selection') }}</button>
                    <button type="button" class="kt-btn kt-btn-sm kt-btn-danger" wire:click="deleteSelected"
                        wire:confirm="{{ __('main.are_you_sure') }}">
                        <i class="ki-filled ki-trash me-1"></i>
                        {{ __('main.delete_selected') }}
                    </button>
                </div>
            </div>
        @endif

        @if (isset($data) && !empty($data) && $data->count() > 0)
            @include('includes.pagination', ['data' => $data])
        @endif
    </div>
</div>

@push('scripts')
    <script>
        const ably_activity = new Ably.Realtime({
            key: '{{ config('app.ably_key') }}',
            logLevel: 1
        });
        const activityCreated = ably_activity.channels.get('activity-created');
        activityCreated.subscribe('activity.created', (message) => {
            @this.dispatch('activityCreated');
        });

        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                ably.close();
            } else {
                ably.connect();
            }
        });
    </script>
@endpush
