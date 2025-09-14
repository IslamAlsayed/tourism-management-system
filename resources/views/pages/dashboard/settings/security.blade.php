@extends('layouts.master')

@section('title', __('main.security_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.security_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_security_password_settings') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_settings') }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Password Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.security_settings') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="grid lg:grid-cols-2 gap-6 p-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.min_password_length') }}</label>
                                <input type="number" class="kt-input h-[45px]"
                                    value="{{ $securitySettings['password_min_length'] }}" min="6" max="20" />
                                <div class="text-xs text-secondary-foreground mt-1">{{ __('main.password_hint') }}</div>
                            </div>
                            <div>
                                <label class="kt-label mb-2">{{ __('main.session_timeout') }}</label>
                                <input type="number" class="kt-input h-[45px]"
                                    value="{{ $securitySettings['session_lifetime'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">{{ __('main.password_hint') }}</div>
                            </div>
                        </div>

                        <div class="space-y-4 p-4">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="kt-checkbox"
                                    {{ $securitySettings['require_password_confirmation'] ? 'checked' : '' }} />
                                <label class="text-sm">{{ __('main.require_password_confirmation') }}</label>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="kt-checkbox"
                                    {{ $securitySettings['enable_two_factor'] ? 'checked' : '' }} />
                                <label class="text-sm">{{ __('main.enable_two_factor') }}</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Status -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.security_status') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-success-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-shield-tick text-success text-xl"></i>
                                <div>
                                    <div class="font-semibold">{{ __('main.data_encryption') }}</div>
                                    <div class="text-sm text-secondary-foreground">
                                        {{ __('main.important_security_notifications') }}</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-success">{{ __('main.active') }}</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-success-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-key text-success text-xl"></i>
                                <div>
                                    <div class="font-semibold">{{ __('main.csrf_protection') }}</div>
                                    <div class="text-sm text-secondary-foreground">
                                        {{ __('main.important_security_notifications') }}</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-success">{{ __('main.active') }}</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-warning-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-security-user text-warning text-xl"></i>
                                <div>
                                    <div class="font-semibold">{{ __('main.two_factor_auth') }}</div>
                                    <div class="text-sm text-secondary-foreground">
                                        {{ __('main.important_security_notifications') }}</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-warning">{{ __('main.not_enabled') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Logs -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.security_logs') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-2 gap-6 p-4">
                        <div class="flex items-center justify-between py-2 border-b p-4">
                            <div>
                                <div class="text-sm font-semibold">{{ __('main.successful_login') }}</div>
                                <div class="text-xs text-secondary-foreground">{{ __('main.from_ip_address') }}:
                                    192.168.1.1</div>
                            </div>
                            <div class="text-xs text-secondary-foreground">{{ __('main.minutes_ago', ['minutes' => 5]) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b">
                            <div>
                                <div class="text-sm font-semibold">{{ __('main.password_change') }}</div>
                                <div class="text-xs text-secondary-foreground">
                                    {{ __('main.password_updated_successfully') }}</div>
                            </div>
                            <div class="text-xs text-secondary-foreground">{{ __('main.hour_ago') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
