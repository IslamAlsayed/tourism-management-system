@extends('layouts.master')

@section('title', __('main.general_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
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
            <!-- Application Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.app_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('settings.update', $settings->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Setting Photo -->
                        @include('components.settings-image', [
                            'column' => 'application',
                            'photoUrl' => [
                                $settings->app_light_photo
                                    ? asset('storage/' . $settings->app_light_photo)
                                    : asset('storage/logos/default-logo.svg'),
                                $settings->app_dark_photo
                                    ? asset('storage/' . $settings->app_dark_photo)
                                    : asset('storage/logos/default-logo.svg'),
                                $settings->app_mini_photo
                                    ? asset('storage/' . $settings->app_mini_photo)
                                    : asset('storage/logos/mini-logo.svg'),
                            ],
                        ])

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="app_name" class="kt-input h-[45px]"
                                    value="{{ $settings->app_name }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_url') }}</label>
                                <input type="url" name="app_url" class="kt-input h-[45px]"
                                    value="{{ $settings->app_url }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="app_timezone" class="kt-select h-[45px]">
                                    @foreach (config('helpers.timezones') as $key => $item)
                                        <option value="{{ $key }}"
                                            {{ strtolower($settings->app_timezone) == $key ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.language') }}</label>
                                <select name="app_language" class="kt-select h-[45px]">
                                    @foreach (config('languages.languages') as $key => $language)
                                        <option value="{{ $key }}"
                                            {{ strtolower($settings->app_language) == $key ? 'selected' : '' }}>
                                            {{ $language }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_version') }}</label>
                                <input type="text" name="app_version" class="kt-input h-[45px]"
                                    value="{{ $settings->app_version }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_columns_length') }}</label>
                                <input type="number" name="app_columns_length" class="kt-input h-[45px]"
                                    value="{{ $settings->app_columns_length }}" />
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

            <!-- System Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.server_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-2 gap-6 p-4">
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.app_version') }}</div>
                            <div class="font-semibold">{{ $settings->app_version }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.php_version') }}</div>
                            <div class="font-semibold">{{ $settings->app_php_version }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.operating_system') }}</div>
                            <div class="font-semibold">{{ config('app.db_mode') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.status') }}</div>
                            <div class="font-semibold text-success">
                                {{ $settings->app_status == 1 || $settings->app_status == true ? __('main.active') : __('main.inactive') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
