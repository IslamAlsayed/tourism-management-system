@extends('layouts.master')

@section('title', __('main.system_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.system_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.manage_configure_system_settings') }}
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Settings Menu -->
            <div class="grid lg:grid-cols-2 xl:grid-cols-4 gap-5">
                <!-- General Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-primary-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-setting-2 text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.general_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_basic_app_settings') }}
                        </p>
                        <a href="{{ route('settings.general') }}" class="kt-btn kt-btn-primary kt-btn-sm">
                            {{ __('main.manage_users') }}
                        </a>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-success-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-shield-tick text-3xl text-success"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.security_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_security_password_settings') }}
                        </p>
                        <a href="{{ route('settings.security') }}" class="kt-btn kt-btn-success kt-btn-sm">
                            {{ __('main.security') }}
                        </a>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-warning-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-notification-bing text-3xl text-warning"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.notification_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_notifications_alerts') }}
                        </p>
                        <a href="{{ route('settings.notifications') }}" class="kt-btn kt-btn-warning kt-btn-sm">
                            {{ __('main.notifications') }}
                        </a>
                    </div>
                </div>

                <!-- Backup Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-info-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-cloud-download text-3xl text-info"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.backup_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.manage_backup_restore_data') }}
                        </p>
                        <a href="{{ route('settings.backup') }}" class="kt-btn kt-btn-info kt-btn-sm">
                            {{ __('main.backup_now') }}
                        </a>
                    </div>
                </div>

                <!-- Booking Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-primary-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-calendar text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.booking_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_booking_payment_settings') }}
                        </p>
                        <a href="{{ route('settings.booking') }}" class="kt-btn kt-btn-primary kt-btn-sm">
                            {{ __('main.manage') }}
                        </a>
                    </div>
                </div>

                <!-- Integration Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-success-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-share text-3xl text-success"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.integration_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_third_party_services') }}
                        </p>
                        <a href="{{ route('settings.integration') }}" class="kt-btn kt-btn-success kt-btn-sm">
                            {{ __('main.manage') }}
                        </a>
                    </div>
                </div>

                <!-- System Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center p-4">
                        <div class="bg-warning-light rounded-full mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-gear text-3xl text-warning"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ __('main.system_settings') }}</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.configure_system_logs_maintenance') }}
                        </p>
                        <a href="{{ route('settings.system') }}" class="kt-btn kt-btn-warning kt-btn-sm">
                            {{ __('main.manage') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.quick_actions') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-3 gap-4 p-4">
                        <button class="kt-btn kt-btn-outline kt-btn-outline-primary">
                            <i class="ki-filled ki-arrows-circle text-sm me-2"></i>
                            {{ __('main.clear_cache') }}
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-success">
                            <i class="ki-filled ki-check-circle text-sm me-2"></i>
                            {{ __('main.system_check') }}
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-warning">
                            <i class="ki-filled ki-file-up text-sm me-2"></i>
                            {{ __('main.update_system') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
