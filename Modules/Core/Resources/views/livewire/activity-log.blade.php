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
        {{-- Activity Navigation Links --}}
        <div class="flex flex-wrap gap-3 mb-6 bg-gray-100 dark:bg-gray-800/40 p-3 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <a href="{{ url('/dashboard/core/activity-log') }}" 
               class="kt-btn kt-btn-sm flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all duration-300 {{ Request::is('*activity-log') && !Request::is('*users') && !Request::is('*system') ? 'kt-btn-primary shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-gray-700 hover:bg-gray-50' }}">
                <i class="ki-outline ki-category text-md"></i>
                <span class="font-bold tracking-tight">{{ __('activity.all_activities') ?? 'All Activity' }}</span>
            </a>
            <a href="{{ url('/dashboard/core/activity-log/users') }}" 
               class="kt-btn kt-btn-sm flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all duration-300 {{ Request::is('*activity-log/users') ? 'bg-success text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-gray-700 hover:bg-gray-50' }}">
                <i class="ki-outline ki-user text-md"></i>
                <span class="font-bold tracking-tight">{{ __('activity.users_activity') ?? 'Users Activity' }}</span>
            </a>
            <a href="{{ url('/dashboard/core/activity-log/system') }}" 
               class="kt-btn kt-btn-sm flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all duration-300 {{ Request::is('*activity-log/system') ? 'bg-warning text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-gray-700 hover:bg-gray-50' }}">
                <i class="ki-outline ki-setting-2 text-md"></i>
                <span class="font-bold tracking-tight">{{ __('activity.system_activity') ?? 'System Activity' }}</span>
            </a>
        </div>

        @if (isset($data) && count($data) > 0)
            {{-- Cards totals --}}
            <div class="grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mb-4">
                <div class="rounded-xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-sm transition-transform hover:scale-[1.02]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                            <i class="ki-outline ki-chart-line text-primary text-xl"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">{{ __('activity.activity_total_events') }}</p>
                    </div>
                    <p class="text-3xl font-black text-gray-800 dark:text-white leading-none">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-sm transition-transform hover:scale-[1.02]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center">
                            <i class="ki-outline ki-cube-2 text-success text-xl"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">{{ __('activity.activity_model_events') }}</p>
                    </div>
                    <p class="text-3xl font-black text-gray-800 dark:text-white leading-none">{{ number_format($stats['models']) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-sm transition-transform hover:scale-[1.02]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-warning/10 flex items-center justify-center">
                            <i class="ki-outline ki-setting-4 text-warning text-xl"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">{{ __('activity.activity_system_events') }}</p>
                    </div>
                    <p class="text-3xl font-black text-gray-800 dark:text-white leading-none">{{ number_format($stats['system']) }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white dark:bg-gray-800 p-5 shadow-sm transition-transform hover:scale-[1.02]">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-lg bg-danger/10 flex items-center justify-center">
                            <i class="ki-outline ki-error-circle text-danger text-xl"></i>
                        </div>
                        <p class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">{{ __('activity.activity_error_events') }}</p>
                    </div>
                    <p class="text-3xl font-black text-gray-800 dark:text-white leading-none">{{ number_format($stats['errors']) }}</p>
                </div>
            </div>

            {{-- Activity Breakdown --}}
            <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-800 mb-6 p-5 shadow-sm"
                id="activity-breakdown-container">
                <div class="flex items-center gap-2 mb-4">
                    <i class="ki-outline ki-sort-amount-down text-primary text-lg"></i>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-tight">{{ __('activity.activity_breakdown_title') }}</h3>
                </div>
                <div class="flex flex-wrap gap-2 md:gap-3">
                    @forelse ($breakdown as $row)
                        @php
                            $eventName = $row->event ?? 'unknown';
                            $langKey = 'activity.event_' . $eventName;
                            $translated = __($langKey);
                            // Fallback if translation missing
                            $displayLabel = ($translated === $langKey) ? ucfirst($eventName) : $translated;
                            $rowBadgeClass = badgeClasses($eventName);
                        @endphp
                        <div wire:key="activity-breakdown-{{ $eventName }}"
                            class="flex items-center gap-2 rounded-lg {{ $rowBadgeClass }} px-4 py-2 shadow-sm border border-transparent transition-all hover:shadow-md cursor-default min-h-[40px]">
                            <span class="font-bold text-xs md:text-sm uppercase tracking-wide">{{ $displayLabel }}</span>
                            <span class="flex items-center justify-center bg-black/10 dark:bg-white/20 px-2 h-6 min-w-[24px] rounded-md text-xs font-black border border-black/5">{{ $row->total }}</span>
                        </div>
                    @empty
                        <span class="text-gray-400 text-sm italic">{{ __('main.no_data_available') }}</span>
                    @endforelse
                </div>
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
                                {{ $logName === 'models' ? __('activity.users_activity') : ($logName === 'system' ? __('activity.system_activity') : ucfirst($logName)) }}
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
                                {{ __('activity.event_' . $event) }}
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
                    <div class="relative group">
                        <input id="date-from" type="datetime-local" class="kt-input h-[45px] pe-10 font-bold text-blue-700 bg-blue-50/30 border-blue-100 hover:border-blue-400 focus:ring-blue-500/20" wire:model.live="dateFrom">
                        @if($dateFrom)
                            <button wire:click="$set('dateFrom', null)" class="absolute end-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger p-1">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        @endif
                        <div class="absolute end-3 top-1/2 -translate-y-1/2 text-blue-400">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="space-y-1">
                    <label for="date-to"
                        class="text-sm font-medium text-gray-600 mb-2 inline-block">{{ __('activity.activity_date_to') }}</label>
                    <div class="relative group">
                        <input id="date-to" type="datetime-local" class="kt-input h-[45px] pe-10 font-bold text-blue-700 bg-blue-50/30 border-blue-100 hover:border-blue-400 focus:ring-blue-500/20" wire:model.live="dateTo">
                        @if($dateTo)
                            <button wire:click="$set('dateTo', null)" class="absolute end-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger p-1">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        @endif
                        <div class="absolute end-3 top-1/2 -translate-y-1/2 text-blue-400">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <button type="button" wire:click="applyDateFilters" 
                        class="kt-btn bg-blue-600 text-white h-[45px] px-6 shadow-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2 font-bold ring-4 ring-blue-500/10">
                        <i class="fas fa-check-circle"></i>
                        {{ __('main.apply_filters') ?? 'تطبيق الفلتر' }}
                    </button>
                    @if (isset($dateFrom) || isset($dateTo) || $filterLog != '' || $filterEvent != '' || $filterUser != '')
                        <button type="button" wire:click="resetFilters" title="{{ __('main.reset_filters') }}"
                            toggle-button
                            class="kt-btn bg-primary/30 text-blue-600 px-3 h-[45px] hover:bg-gray-50 transition-colors">
                            <i class="fas fa-arrow-rotate-left text-blue-600 me-1"></i>
                            <span class="text-sm">{{ __('main.reset_filters') }}</span>
                        </button>
                    @endif
                    @if ($filterLog != '')
                        <div x-data="{
                            confirmClearLog() {
                                Swal.fire({
                                    title: '{{ __('messages.are_you_sure') }}',
                                    text: '{{ __('messages.confirm_clear_log_text') ?? __('activity.activity_clear_current_log') }}',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __('main.yes') }}',
                                    cancelButtonText: '{{ __('main.no') }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        @this.call('clearLog', '{{ $filterLog }}');
                                    }
                                })
                            }
                        }">
                            <button type="button" class="kt-btn bg-danger h-[45px]" x-on:click.prevent="confirmClearLog">
                                <i class="ki-filled ki-trash me-1"></i>
                                {{ __('activity.activity_clear_current_log') }}
                            </button>
                        </div>
                    @endif
                    <div x-data="{
                        confirmClearAll() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: '{{ __('messages.confirm_clear_all_logs_text') ?? __('activity.activity_clear_all_logs') }}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('clearAll');
                                }
                            })
                        }
                    }">
                        <button type="button" class="kt-btn bg-danger h-[45px]" x-on:click.prevent="confirmClearAll">
                            <i class="ki-filled ki-trash me-1"></i>
                            {{ __('activity.activity_clear_all_logs') }}
                        </button>
                    </div>
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
                                    class="px-3 py-2 text-right text-xs font-semibold uppercase tracking-wide text-gray-500 w-[120px]">
                                    {{ __('main.actions') }}
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
                                            class="rounded-md px-2.5 py-1 text-xs font-bold inline-block {{ badgeClasses($activity->event) }}">
                                            {!! highlightSearch(__('activity.event_' . ($activity->event ?? 'unknown')), $search) !!}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600">
                                        <span class="bg-gray-100 dark:bg-gray-700/50 px-2 py-1 rounded text-[11px] font-bold text-gray-700 dark:text-gray-300">
                                            {!! highlightSearch($activity->log_name === 'models' ? __('activity.users_activity') : ucfirst($activity->log_name), $search) !!}
                                        </span>
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
                                        <div class="flex flex-col gap-1">
                                            <span class="font-bold text-gray-800 dark:text-gray-200">
                                                {!! highlightSearch(class_basename($activity->subject_type), $search) !!}
                                            </span>
                                            <span class="text-[11px] font-mono bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded-sm self-start">
                                                #{!! highlightSearch($activity->subject_id, $search) !!}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-600"
                                        title="{{ activityMessageSummary($activity, 1000) }}">
                                        <div style="text-wrap: wrap; line-height: 1.5;">
                                            {!! highlightSearch(activityMessageSummary($activity, 200), $search) !!}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-right text-sm w-[130px] sticky right-0 rtl:left-0 rtl:right-auto bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm shadow-[-10px_0_15px_-3px_rgba(0,0,0,0.05)] rtl:shadow-[10px_0_15px_-3px_rgba(0,0,0,0.05)] border-l border-gray-100 dark:border-gray-700">
                                        <div class="flex justify-end gap-1.5">
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
                    <div x-data="{
                        confirmDelete() {
                            Swal.fire({
                                title: '{{ __('messages.are_you_sure') }}',
                                text: '{!! addslashes(str_replace(["\r\n", "\n", "\r"], " ", __("messages.confirm_bulk_delete"))) !!}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('main.yes') }}',
                                cancelButtonText: '{{ __('main.no') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    @this.call('deleteSelected');
                                }
                            })
                        }
                    }">
                        <button type="button" class="kt-btn kt-btn-sm kt-btn-danger"
                            x-on:click.prevent="confirmDelete">
                            <i class="ki-filled ki-trash me-1"></i>
                            {{ __('main.delete_selected') }}
                        </button>
                    </div>
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
