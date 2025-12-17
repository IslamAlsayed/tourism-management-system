@extends('layouts.master')

@section('title', __('main.security_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
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
                    {{ __('main.back_to_types', ['types' => __('main.settings')]) }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Password Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.security_settings') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('settings.update', $settings->id) }}" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.session_timeout') }}
                                    <span class="text-red-500 text-sm">
                                        ({{ __('main.minimum_minutes', ['minutes' => 5]) }})
                                    </span>
                                </label>
                                <input type="number" name="app_session_lifetime" class="kt-input h-[45px]"
                                    value="{{ $settings->app_session_lifetime }}" minLength="0" />
                                <div class="text-xs text-info mt-1">
                                    <i class="ki-filled ki-information-2"></i>
                                    {{ __('main.zero_for_unlimited_session') }}
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-2">{{ __('main.max_login_attempts') }}</label>
                                <input type="number" name="app_max_login_attempts" class="kt-input h-[45px]"
                                    value="{{ $settings->app_max_login_attempts }}" minLength="1" />
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.failed_attempts_before_lock') }}
                                </div>
                            </div>
                            <div>
                                <label class="kt-label mb-2">{{ __('main.minimum_password_length') }}</label>
                                <input type="number" name="app_minimum_password_length" class="kt-input h-[45px]"
                                    value="{{ $settings->app_minimum_password_length }}" />
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.minimum_password_length_description') }}
                                </div>
                            </div>
                            <div class="disabled p-2 rounded-sm"
                                style="background: var(--color-{{ $settings->app_ip_ban_duration_minutes == 1 ? 'green' : 'yellow' }}-100);">
                                <label class="kt-label mb-2">
                                    {{ __('main.ip_ban_duration') }} ({{ __('main.minutes') }})
                                    <span
                                        class="inline-block font-medium px-2 py-0.5 rounded-full ms-2 bg-danger/10 text-red-600">
                                        {{ __('sidebar.soon') }}
                                    </span>
                                </label>

                                <input type="number" name="app_ip_ban_duration_minutes" class="kt-input h-[45px]"
                                    value="{{ $settings->app_ip_ban_duration_minutes }}" minLength="1" />
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.minutes_to_ban_ip') }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="app_password_confirmation" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'app_password_confirmation',
                                        'id' => 'app_password_confirmation',
                                        'value' => '1',
                                        'checked' => $settings->app_password_confirmation == 1,
                                        'label' => __('main.require_password_confirmation'),
                                    ])
                                </div>
                            </div>

                            <div class="flex items-center gap-3 disabled p-2 rounded-sm"
                                style="background: var(--color-{{ $settings->app_two_factor_authentication == 1 ? 'green' : 'yellow' }}-100);">
                                <input type="hidden" name="app_two_factor_authentication" value="0">
                                <input type="checkbox" name="app_two_factor_authentication" class="kt-checkbox"
                                    id="app_two_factor_authentication" value="1"
                                    {{ $settings->app_two_factor_authentication == 1 ? 'checked' : '' }}>
                                <label for="app_two_factor_authentication" class="kt-label mb-0">
                                    {{ __('main.enable_two_factor') }}
                                    <span
                                        class="inline-block font-medium px-2 py-0.5 rounded-full ms-2 bg-danger/10 text-red-600">
                                        {{ __('sidebar.soon') }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-start gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.settings')]) }}
                            </button>
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
                    <div class="space-y-4 p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div class="kt-card flex items-center justify-between p-4 bg-success-light rounded">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold">
                                            <i class="ki-filled ki-shield-tick text-success text-xl"></i>
                                            {{ __('main.data_encryption') }}
                                        </div>
                                        <div class="text-sm text-secondary-foreground my-2">
                                            {{ __('main.important_security_notifications') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-badge kt-badge-success">{{ __('main.active') }}</div>
                            </div>
                            <div class="kt-card flex items-center justify-between p-4 bg-success-light rounded">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold">
                                            <i class="ki-filled ki-shield-tick text-success text-xl"></i>
                                            {{ __('main.csrf_protection') }}
                                        </div>
                                        <div class="text-sm text-secondary-foreground my-2">
                                            {{ __('main.important_security_notifications') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-badge kt-badge-success">{{ __('main.active') }}</div>
                            </div>
                            <div
                                class="kt-card flex items-center justify-between p-4 {{ $settings->app_two_factor_authentication == 1 ? 'bg-success-light' : 'bg-yellow-100' }} rounded">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold">
                                            <i class="ki-filled ki-shield-tick text-success text-xl"></i>
                                            {{ __('main.two_factor_auth') }}
                                        </div>
                                        <div class="text-sm text-secondary-foreground my-2">
                                            {{ __('main.important_security_notifications') }}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="kt-badge {{ $settings->app_two_factor_authentication == 1 ? 'kt-badge-success' : 'kt-badge-warning' }}">
                                    {{ $settings->app_two_factor_authentication == 1 ? __('main.enabled') : __('main.not_enabled') }}
                                </div>
                            </div>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 p-4">
                        <div class="flex items-center justify-between py-2 border-b">
                            <div>
                                <div class="text-sm font-semibold">{{ __('main.successful_login') }}</div>
                                <div class="text-xs text-secondary-foreground">
                                    {{ __('main.from_ip_address') }}: {{ request()->ip() }}
                                </div>
                            </div>
                            <div class="text-xs text-secondary-foreground">
                                {{ getActiveUser()->human_last_login_at }}
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b">
                            <div>
                                <div class="text-sm font-semibold">{{ __('main.password_change') }}</div>
                                <div class="text-xs text-secondary-foreground">
                                    {{ __('main.password_updated_successfully') }}
                                </div>
                            </div>
                            <div class="text-xs text-secondary-foreground">
                                @if (getActiveUser() && getActiveUser()->password_changed_at)
                                    {{ getActiveUser()->human_password_changed_at }}
                                @else
                                    {{ __('main.unknown') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
