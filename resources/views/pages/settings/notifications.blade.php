@extends('layouts.master')

@section('title', __('main.notification_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.notification_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_notifications_alerts') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.settings')]) }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <form method="POST" action="{{ route('settings.update', $settings->id) }}">
                @csrf
                @method('PUT')

                <!-- Notification Channels -->
                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.notification_channels') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4 p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                                <div class="kt-card p-4">
                                    <div class="flex flex-nowrap items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i class="ki-filled ki-sms text-xl text-primary"></i>
                                            <div>
                                                <div class="font-semibold">{{ __('main.email_notifications') }}</div>
                                                <div class="text-sm text-secondary-foreground">
                                                    {{ __('main.receive_notifications_via_email') }}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_email_notifications" value="0">
                                        <input type="checkbox" name="app_email_notifications"
                                            class="kt-checkbox kt-checkbox-lg" value="1"
                                            {{ $settings->app_email_notifications == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex flex-nowrap items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i class="ki-filled ki-phone text-xl text-success"></i>
                                            <div>
                                                <div class="font-semibold">{{ __('main.sms_notifications') }}</div>
                                                <div class="text-sm text-secondary-foreground">
                                                    {{ __('main.receive_notifications_via_sms') }}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_sms_notifications" value="0">
                                        <input type="checkbox" name="app_sms_notifications"
                                            class="kt-checkbox kt-checkbox-lg" value="1"
                                            {{ $settings->app_sms_notifications == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex flex-nowrap items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i class="ki-filled ki-notification-bing text-xl text-warning"></i>
                                            <div>
                                                <div class="font-semibold">{{ __('main.push_notifications') }}</div>
                                                <div class="text-sm text-secondary-foreground">
                                                    {{ __('main.instant_browser_notifications') }}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="app_push_notifications" value="0">
                                        <input type="checkbox" name="app_push_notifications"
                                            class="kt-checkbox kt-checkbox-lg" value="1"
                                            {{ $settings->app_push_notifications == 1 ? 'checked' : '' }} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Types -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.notification_types') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4 p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.new_user') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.when_new_user_registers') }}
                                            </div>
                                        </div>
                                        <input type="checkbox" class="kt-checkbox" checked />
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.data_updates') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.when_important_data_updates') }}
                                            </div>
                                        </div>
                                        <input type="checkbox" class="kt-checkbox" checked />
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.system_reports') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.periodic_reports_on_system_status') }}</div>
                                        </div>
                                        <input type="checkbox" class="kt-checkbox" />
                                    </div>
                                </div>

                                <div class="kt-card p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-semibold">{{ __('main.security_updates') }}</div>
                                            <div class="text-sm text-secondary-foreground">
                                                {{ __('main.important_security_notifications') }}</div>
                                        </div>
                                        <input type="checkbox" class="kt-checkbox" checked />
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex items-center justify-start gap-4">
                                <button type="submit" class="kt-btn kt-btn-primary">
                                    <i class="ki-filled ki-check text-sm me-2"></i>
                                    {{ __('main.save_type', ['type' => __('main.settings')]) }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Test Notification -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.test_notifications') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <p class="text-sm text-secondary-foreground mb-4">
                        {{ __('main.send_test_notification') }}
                    </p>
                    <div class="flex gap-3">
                        <button class="kt-btn kt-btn-outline kt-btn-outline-primary">
                            <i class="ki-filled ki-sms text-sm me-2"></i>
                            {{ __('main.test_email') }}
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-success">
                            <i class="ki-filled ki-phone text-sm me-2"></i>
                            {{ __('main.test_sms') }}
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-warning">
                            <i class="ki-filled ki-notification-bing text-sm me-2"></i>
                            {{ __('main.test_push_notification') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
