@extends('layouts.master')

@section('title', __('main.system_settings'))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.system_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_system_logs_maintenance') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.settings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <form method="POST" action="{{ route('dashboard.core.settings.update', $settings->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- System Information -->
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.system_information') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                            <div class="kt-card px-4 py-6 hover:bg-gray-100 shadow-sm">
                                <div class="text-center">
                                    <div class="mx-auto mb-3 rounded-full bg-primary/30 p-3 w-[60px] h-[60px] text-center content-center">
                                        <i class="fas fa-list-alt text-2xl text-primary"></i>
                                    </div>
                                    <div class="text-sm text-secondary-foreground">
                                        <a href="{{ route('dashboard.core.activity-log.index') }}" class="text-primary font-semibold">
                                            {{ __('main.total_records') }}
                                        </a>
                                    </div>
                                    <div class="text-2xl font-bold activities-logs-count">
                                        {{ number_format(\DB::table('activity_log')->count()) }}
                                    </div>
                                    <div class="text-xs text-secondary-foreground">{{ __('main.activity_logs') }}</div>
                                </div>
                            </div>

                            <div class="kt-card px-4 py-6 hover:bg-gray-100 shadow-sm">
                                <div class="text-center">
                                    <div class="mx-auto mb-3 rounded-full bg-success/30 p-3 w-[60px] h-[60px] text-center content-center">
                                        <i class="fas fa-users text-2xl text-green-600"></i>
                                    </div>
                                    <div class="text-sm text-secondary-foreground">
                                        <a href="{{ route('dashboard.core.users.index') }}" class="text-primary font-semibold">
                                            {{ __('main.total_users') }}
                                        </a>
                                    </div>
                                    <div class="text-2xl font-bold users-count">
                                        {{ number_format(\Modules\Core\Entities\User::count()) }}
                                    </div>
                                    <div class="text-xs text-secondary-foreground">{{ __('main.registered_users') }}</div>
                                </div>
                            </div>

                            <div class="kt-card px-4 py-6 hover:bg-gray-100 shadow-sm">
                                <div class="text-center">
                                    <div class="mx-auto mb-3 rounded-full bg-yellow/30 p-3 w-[60px] h-[60px] text-center content-center">
                                        <i class="fas fa-bell text-2xl text-yellow-600"></i>
                                    </div>
                                    <div class="text-sm text-secondary-foreground">
                                        <a href="{{ route('notifications.index') }}" class="text-primary font-semibold">
                                            {{ __('main.notifications') }}
                                        </a>
                                    </div>
                                    <div class="text-2xl font-bold notifications-count">
                                        {{ number_format(\App\Models\Notification::count()) }}
                                    </div>
                                    <div class="text-xs text-secondary-foreground">{{ __('main.total_notifications') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-card p-6">
                    <div class="flex gap-6" id="system-settings-grid">
                        <!-- Activity Log Settings -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.activity_log_settings') }}</h3>
                            </div>
                            <div class="kt-card-body">
                                <div class="space-y-6 p-6">
                                    <div class="flex items-center gap-3 mb-6">
                                        <input type="hidden" name="app_activity_log_enabled" value="0" />
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'app_activity_log_enabled',
                                            'id' => 'app_activity_log_enabled',
                                            'checked' => $settings->app_activity_log_enabled == 1,
                                            'value' => 1,
                                        ])
                                        <label for="app_activity_log_enabled">
                                            <div class="font-semibold">{{ __('main.enable_activity_logging') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.track_all_user_actions') }}
                                            </div>
                                        </label>
                                    </div>

                                    {{-- <div class="disabled-option"> --}}
                                    <div class="p-2 rounded-sm {{ $settings->app_activity_log_retention_days == 1 ? '' : 'bg-yellow-100' }}">
                                        <label class="kt-label mb-2">
                                            {{ __('main.log_retention_period') }}
                                            <span class="inline-block font-medium px-2 py-0.5 rounded-full ms-2 bg-danger/10 text-red-600">
                                                {{ __('sidebar.soon') }}
                                            </span>
                                        </label>
                                        <input type="number" name="app_activity_log_retention_days" class="kt-input h-[45px]" disabled
                                            value="{{ $settings->app_activity_log_retention_days }}" minLength="1" />
                                        <div class="text-xs text-secondary-foreground mt-1">
                                            {{ __('main.days_to_keep_logs') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Maintenance Mode -->
                        <div class="disabled">
                            <div class="kt-card {{ $settings->app_activity_log_retention_days == 1 ? '' : 'bg-yellow-100' }}">
                                <div class="kt-card-header">
                                    <h3 class="kt-card-title">
                                        {{ __('main.maintenance_mode') }}
                                        <span class="inline-block font-medium px-2 py-0.5 rounded-full ms-2 bg-danger/10 text-red-600">
                                            {{ __('sidebar.soon') }}
                                        </span>
                                    </h3>
                                </div>
                                <div class="kt-card-body">
                                    <div class="space-y-6 p-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <input type="hidden" name="app_maintenance_mode" value="0" />
                                            @include('components.elements.checkbox-button', [
                                                'name' => 'app_maintenance_mode',
                                                'id' => 'app_maintenance_mode',
                                                'checked' => $settings->app_maintenance_mode == 1,
                                                'value' => 1,
                                            ])
                                            <label for="app_maintenance_mode">
                                                <div class="font-semibold">{{ __('main.enable_maintenance_mode') }}</div>
                                                <div class="text-sm text-secondary-foreground">
                                                    {{ __('main.make_site_unavailable') }}
                                                </div>
                                            </label>
                                        </div>

                                        <div>
                                            @include('components.elements.input-text-editor', [
                                                'column' => 'app_maintenance_message',
                                                'value' => $settings->app_maintenance_message,
                                            ])
                                        </div>

                                        @if ($settings->app_maintenance_mode == 1)
                                            <div class="p-4 rounded bg-warning-light">
                                                <div class="flex items-center gap-3">
                                                    <i class="fas fa-exclamation-triangle text-xl text-warning"></i>
                                                    <div>
                                                        <div class="font-semibold">
                                                            {{ __('main.maintenance_mode_active') }}
                                                        </div>
                                                        <div class="text-sm">
                                                            {{ __('main.site_unavailable_to_visitors') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary" id="submit-button" disabled>
                                <i class="fa-duotone fa-solid fa-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.settings')]) }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let app_activity_log_enabled = document.getElementById('app_activity_log_enabled');
            app_activity_log_enabled.addEventListener('change', function() {
                document.getElementById('submit-button').disabled = false;
            });
        });
    </script>
@endpush
