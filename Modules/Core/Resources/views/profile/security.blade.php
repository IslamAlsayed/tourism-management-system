@extends('layouts.master')

@section('title', __('main.security_settings'))

@section('content')
    <!-- Security Center Header -->
    <div class="kt-container-fixed mb-10">
        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-bold text-foreground">
                <i class="ki-filled ki-shield-tick text-primary fs-2me-2"></i>
                {{ __('main.security_settings') }}
            </h1>
            <p class="text-secondary-foreground text-sm font-medium">
                Manage your account's security preferences, password, and two-factor authentication.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

            <!-- Left: Sign-in Method & Password -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Change Password Card -->
                <div class="kt-card">
                    <div class="kt-card-header border-b-border/60">
                        <h3 class="kt-card-title text-lg font-bold">
                            {{ __('main.sign_in_method') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-8">
                        <!-- Email (Read Only in this view) -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between p-6 bg-muted/20 rounded-2xl border border-dashed border-border mb-8">
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-xs font-bold text-secondary-foreground uppercase tracking-widest">{{ __('main.email_address') }}</span>
                                <span class="text-sm font-bold text-foreground">{{ $user->email }}</span>
                            </div>
                            <div class="mt-4 sm:mt-0 text-success text-xs font-bold flex items-center gap-1.5">
                                <i class="ki-solid ki-check-circle fs-6"></i>
                                Verified Account
                            </div>
                        </div>

                        <!-- Password Form -->
                        <form action="{{ route('dashboard.core.profile.update_password') }}" method="POST"
                            class="space-y-6">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="email" value="{{ $user->email }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-sm font-bold text-foreground">{{ __('main.new_password') }}</label>
                                    <div
                                        class="kt-input rounded-xl h-12 shadow-sm border-border focus-within:border-primary transition-all">
                                        <input type="password" name="password" placeholder="••••••••" required>
                                    </div>
                                    @error('password')
                                        <span class="text-xs text-danger font-medium">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label
                                        class="text-sm font-bold text-foreground">{{ __('main.confirm_password') }}</label>
                                    <div
                                        class="kt-input rounded-xl h-12 shadow-sm border-border focus-within:border-primary transition-all">
                                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-secondary-foreground">
                                Use at least 8 characters with a mix of letters, numbers & symbols for a strong password.
                            </p>

                            <div class="pt-4 flex justify-end">
                                <button type="submit"
                                    class="kt-btn kt-btn-primary rounded-xl px-10 shadow-lg shadow-primary/20">
                                    {{ __('main.update_password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Session Management Placeholder -->
                <div class="kt-card">
                    <div class="kt-card-header border-b-border/60">
                        <h3 class="kt-card-title text-lg font-bold">
                            {{ __('main.active_sessions') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-8 text-center bg-muted/5">
                        <div class="size-16 bg-muted/40 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <i class="ki-filled ki-monitor text-secondary-foreground fs-1"></i>
                        </div>
                        <h4 class="text-lg font-bold mb-2">Device Management</h4>
                        <p class="text-sm text-secondary-foreground max-w-sm mx-auto mb-6">
                            This feature is coming soon to help you track and manage your active devices and browsers.
                        </p>
                        <button class="kt-btn kt-btn-outline rounded-xl" disabled>Sign out all other sessions</button>
                    </div>
                </div>
            </div>

            <!-- Right: 2FA & Preferences -->
            <div class="space-y-8">
                <!-- Two-Factor Authentication -->
                <div class="kt-card bg-primary/5 border-primary/20">
                    <div class="kt-card-header border-b-primary/10">
                        <h3 class="kt-card-title text-lg font-bold text-primary">
                            <i class="ki-filled ki-shield-search fs-3 me-2"></i>
                            Two-Factor Auth
                        </h3>
                    </div>
                    <div class="kt-card-body p-6">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="size-10 bg-primary/20 rounded-xl flex items-center justify-center shrink-0">
                                <i class="ki-filled ki-key text-primary fs-4"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-bold text-foreground mb-1">Status:
                                    <span class="{{ $user->two_factor_confirmed_at ? 'text-success' : 'text-danger' }}">
                                        {{ $user->two_factor_confirmed_at ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                                <p class="text-xs text-secondary-foreground leading-relaxed">
                                    Extra security for your account by requiring both a password and an authentication code.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if (!$user->two_factor_confirmed_at)
                                <button class="kt-btn kt-btn-primary w-full rounded-xl shadow-md">
                                    Setup Authenticator
                                </button>
                            @else
                                <button class="kt-btn kt-btn-danger kt-btn-outline w-full rounded-xl">
                                    Disable 2FA
                                </button>
                                <button class="kt-btn kt-btn-light w-full rounded-xl mt-2">
                                    View Recovery Codes
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Security Alerts Preference -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title text-lg font-bold">{{ __('main.security_alerts') }}</h3>
                    </div>
                    <div class="kt-card-body p-6 space-y-6">
                        <!-- Alert Item -->
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-bold">Email Alerts</span>
                                <span class="text-[11px] text-secondary-foreground italic">Sign-in from new devices</span>
                            </div>
                            <label class="kt-switch kt-switch-sm">
                                <input type="checkbox" checked name="email_alerts">
                            </label>
                        </div>
                        <!-- Alert Item -->
                        <div class="flex items-center justify-between border-t border-border/40 pt-6">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-bold">SMS Alerts</span>
                                <span class="text-[11px] text-secondary-foreground italic">Sensitive changes</span>
                            </div>
                            <label class="kt-switch kt-switch-sm">
                                <input type="checkbox" name="sms_alerts">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
