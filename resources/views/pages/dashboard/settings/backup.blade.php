@extends('layouts.master')

@section('title', __('main.backup_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.backup_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.manage_backup_restore_data') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_settings') }}
                </a>
                <form method="POST" action="{{ route('settings.backup.create') }}" class="inline">
                    @csrf
                    <button type="submit" class="kt-btn kt-btn-primary">
                        <i class="text-sm ki-filled ki-cloud-download me-2"></i>
                        {{ __('main.backup_now') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Backup Status -->
            <div class="grid gap-5 lg:grid-cols-3">
                <div class="p-4 kt-card">
                    <div class="text-center kt-card-body">
                        <div class="mx-auto mb-3 rounded-full bg-primary-light w-fit">
                            <i class="text-2xl ki-filled ki-calendar text-primary"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">{{ __('main.last_backup') }}</div>
                        <div class="font-semibold">{{ $backupInfo['last_backup'] }}</div>
                    </div>
                </div>

                <div class="p-4 kt-card">
                    <div class="text-center kt-card-body">
                        <div class="mx-auto mb-3 rounded-full bg-success-light w-fit">
                            <i class="text-2xl ki-filled ki-size text-success"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">{{ __('main.backup_status') }}</div>
                        <div class="font-semibold">{{ $backupInfo['backup_size'] }}</div>
                    </div>
                </div>

                <div class="p-4 kt-card">
                    <div class="text-center kt-card-body">
                        <div class="mx-auto mb-3 rounded-full bg-info-light w-fit">
                            <i class="text-2xl ki-filled ki-setting-2 text-info"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">{{ __('main.automatic_backup') }}</div>
                        <div class="font-semibold">
                            {{ $backupInfo['auto_backup_enabled'] ? __('main.enabled') : __('main.not_enabled') }}</div>
                    </div>
                </div>
            </div>

            <!-- Backup Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.backup_settings_options') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form class="p-4 space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="mb-4">
                                <div class="font-semibold">{{ __('main.automatic_backup') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.manage_backup_restore_data') }}
                                </div>
                            </div>
                            <input type="checkbox" class="kt-checkbox kt-checkbox-lg"
                                {{ $backupInfo['auto_backup_enabled'] ? 'checked' : '' }} />
                        </div>

                        <div>
                            <label class="mb-2 kt-label">{{ __('main.backup_frequency') }}</label>
                            <select class="kt-select">
                                <option value="daily" {{ $backupInfo['backup_frequency'] == 'daily' ? 'selected' : '' }}>
                                    {{ __('main.daily') }}</option>
                                <option value="weekly" {{ $backupInfo['backup_frequency'] == 'weekly' ? 'selected' : '' }}>
                                    {{ __('main.weekly') }}</option>
                                <option value="monthly"
                                    {{ $backupInfo['backup_frequency'] == 'monthly' ? 'selected' : '' }}>
                                    {{ __('main.monthly') }}</option>
                            </select>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                {{ __('main.save_changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Backup History -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.backup_history') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-success-light">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ __('main.backup_now') }}</div>
                                    <div class="text-sm text-secondary-foreground">25 {{ __('main.maps.august') }} 2025 -
                                        10:12 {{ __('main.time') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">206 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    {{ __('main.download') }}
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pb-2 border-b">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-success-light">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ __('main.automatic_backup') }}</div>
                                    <div class="text-sm text-secondary-foreground">24 {{ __('main.maps.august') }} 2025 -
                                        03:00 {{ __('main.time') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">198 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    {{ __('main.download') }}
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pb-2 border-b">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-full bg-success-light">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ __('main.backup_now') }}</div>
                                    <div class="text-sm text-secondary-foreground">23 {{ __('main.maps.august') }} 2025 -
                                        14:30 {{ __('main.time') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">195 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    {{ __('main.download') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restore Options -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.restore_from_backup') }}</h3>
                </div>
                <div class="p-4 kt-card-body">
                    <div class="mb-4 rounded bg-warning-light">
                        <div class="flex items-center gap-3">
                            <i class="text-xl ki-filled ki-information text-warning"></i>
                            <div>
                                <div class="font-semibold">{{ __('main.restore_warning') }}</div>
                                <div class="text-sm">{{ __('main.proceed_with_caution') }}</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 kt-label">{{ __('main.select_backup_file') }}</label>
                        <input type="file" class="kt-input w-[350px]" accept=".zip,.sql" />
                        <div class="mt-1 text-xs text-secondary-foreground">{{ __('main.select_backup_file') }}</div>
                    </div>

                    <div class="pt-4">
                        <button class="kt-btn kt-btn-danger">
                            <i class="text-sm ki-filled ki-arrows-circle me-2"></i>
                            {{ __('main.restore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
