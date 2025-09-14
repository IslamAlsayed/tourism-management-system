@extends('layouts.master')

@section('title', __('main.general_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.general_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_basic_app_settings') }}
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
            <!-- Application Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.app_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="grid lg:grid-cols-2 gap-6 p-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" class="kt-input h-[45px]" value="{{ $settings['app_name'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">{{ __('main.app_info') }}</div>
                            </div>
                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_url') }}</label>
                                <input type="url" class="kt-input h-[45px]" value="{{ $settings['app_url'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">{{ __('main.app_info') }}</div>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 p-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select class="kt-select h-[45px]">
                                    <option value="UTC" {{ $settings['app_timezone'] == 'UTC' ? 'selected' : '' }}>UTC
                                    </option>
                                    <option value="Asia/Riyadh"
                                        {{ $settings['app_timezone'] == 'Asia/Riyadh' ? 'selected' : '' }}>
                                        {{ __('main.maps.asia/riyadh (+3)') }}
                                    </option>
                                    <option value="Asia/Dubai"
                                        {{ $settings['app_timezone'] == 'Asia/Dubai' ? 'selected' : '' }}>
                                        {{ __('main.maps.asia/dubai (+4)') }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="kt-label mb-2">{{ __('main.language') }}</label>
                                <select class="kt-select h-[45px]">
                                    <option value="en" {{ $settings['app_locale'] == 'en' ? 'selected' : '' }}>
                                        {{ __('main.english') }}
                                    </option>
                                    <option value="ar" {{ $settings['app_locale'] == 'ar' ? 'selected' : '' }}>
                                        {{ __('main.arabic') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.server_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-2 gap-6 p-4">
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.app_version') }}</div>
                            <div class="font-semibold">{{ app()->version() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.php_version') }}</div>
                            <div class="font-semibold">{{ PHP_VERSION }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.operating_system') }}</div>
                            <div class="font-semibold">{{ app()->environment() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.status') }}</div>
                            <div class="font-semibold text-success">{{ __('main.active') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
