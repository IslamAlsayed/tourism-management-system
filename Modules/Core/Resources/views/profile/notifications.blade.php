@extends('layouts.master')

@section('title', __('main.notifications_settings'))

@section('content')
    <!-- Header -->
    <div class="container-fixed mb-10">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-bold text-foreground">
                <i class="fa-duotone fa-solid fa-bell-on text-primary fs-2 me-2"></i>
                {{ __('main.notifications_settings') }}
            </h1>
            <p class="text-secondary-foreground text-sm font-medium">
                Customize how and when you receive alerts for account activity and updates.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fixed">
        <div class="grid grid-cols-1 gap-8">

            <!-- Notifications Card -->
            <div class="kt-card">
                <div class="kt-card-header border-b-border/60 flex items-center justify-between">
                    <h3 class="kt-card-title text-lg font-bold">
                        {{ __('main.notification_preferences') }}
                    </h3>
                    <div class="flex items-center gap-2">
                        <button class="kt-btn kt-btn-xs kt-btn-light rounded-lg">Mark all as read</button>
                    </div>
                </div>

                <div class="kt-card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 px-8">
                            <thead>
                                <tr
                                    class="text-start text-secondary-foreground fw-bold fs-7 text-uppercase gs-0 border-b border-border/60">
                                    <th class="min-w-200px py-6">{{ __('main.event_type') }}</th>
                                    <th class="text-center py-6">{{ __('main.email') }}</th>
                                    <th class="text-center py-6">{{ __('main.sms') }}</th>
                                    <th class="text-center py-6">{{ __('main.push_notifications') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-foreground font-semibold divide-y divide-border/40">
                                <!-- Activity Group -->
                                <tr>
                                    <td class="py-8">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold">Account Activity</span>
                                            <span class="text-xs text-secondary-foreground font-medium">Notify me about
                                                login attempts and password changes.</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" checked name="notif[account][email]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" name="notif[account][sms]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" checked name="notif[account][push]">
                                        </label>
                                    </td>
                                </tr>

                                <!-- Security Group -->
                                <tr>
                                    <td class="py-8">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold">Security Alerts</span>
                                            <span class="text-xs text-secondary-foreground font-medium">Critical alerts
                                                regarding your account security and 2FA.</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" checked name="notif[security][email]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" checked name="notif[security][sms]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" checked name="notif[security][push]">
                                        </label>
                                    </td>
                                </tr>

                                <!-- Marketing Group -->
                                <tr>
                                    <td class="py-8">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold">Marketing & News</span>
                                            <span class="text-xs text-secondary-foreground font-medium">Updates about new
                                                features and travel business tips.</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" name="notif[marketing][email]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" disabled name="notif[marketing][sms]">
                                        </label>
                                    </td>
                                    <td class="text-center py-8">
                                        <label class="kt-switch kt-switch-sm justify-center">
                                            <input type="checkbox" name="notif[marketing][push]">
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="kt-card-footer border-t-border/60 p-8 flex justify-end gap-3">
                    <button class="kt-btn kt-btn-light rounded-xl">{{ __('main.discard') }}</button>
                    <button class="kt-btn kt-btn-primary rounded-xl px-10 shadow-lg shadow-primary/20">
                        {{ __('main.save_preferences') }}
                    </button>
                </div>
            </div>

            <!-- Global DND Setting -->
            <div class="kt-card bg-warning/5 border-warning/20">
                <div class="kt-card-body p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="size-12 bg-warning/20 rounded-2xl flex items-center justify-center shrink-0">
                            <i class="fa-duotone fa-solid fa-moon text-warning fs-2"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-warning-emphasis">Do Not Disturb Mode</h4>
                            <p class="text-sm text-secondary-foreground font-medium">Mute all push notifications during
                                specific hours.</p>
                        </div>
                    </div>
                    <button class="kt-btn kt-btn-warning rounded-xl px-8 shadow-md">
                        Configure Quiet Hours
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
