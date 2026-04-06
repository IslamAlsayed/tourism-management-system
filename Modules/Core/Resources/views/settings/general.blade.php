@extends('layouts.master')

@section('title', __('main.general_settings'))

@section('content')
    <div class="container-fixed">
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
                <a href="{{ route('dashboard.core.settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.settings')]) }}
                </a>
                <button type="button" onclick="document.getElementById('general-settings-form').submit()" class="kt-btn kt-btn-primary">
                    {{ __('main.save_changes') }}
                </button>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Application Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.app_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.core.settings.update', optional($settings)->id ?? 0) }}" enctype="multipart/form-data" class="space-y-6 p-4" id="general-settings-form">
                        @csrf
                        @method('PUT')

                        <!-- Setting Photo -->
                        @include('components.settings-image', [
                            'column' => 'app_logo',
                            'record' => $settings,
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 items-end mb-4">
                            <div>
                                <label class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="app_name" class="kt-input h-[45px]" value="{{ optional($settings)->app_name }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_url') }}</label>
                                <input type="url" name="app_url" class="kt-input h-[45px]" value="{{ optional($settings)->app_url }}" />
                            </div>

                            {{-- Timezone --}}
                            @include('components.selects.timezone', ['record' => $settings, 'name' => 'app_timezone'])

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_version') }}</label>
                                <input type="text" name="app_version" class="kt-input h-[45px]" value="{{ optional($settings)->app_version }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.template_version') }}</label>
                                <input type="text" name="app_template_version" class="kt-input h-[45px]" value="{{ optional($settings)->app_template_version }}" placeholder="e.g. v12.37.0" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.logo_width') ?? 'Logo Width' }} <span class="font-semibold text-primary">(px / %, e.g. 150px)</span></label>
                                <input type="text" name="app_logo_width" class="kt-input h-[45px]" value="{{ optional($settings)->app_logo_width ?? '150px' }}" placeholder="150px" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.logo_height') ?? 'Logo Height' }} <span class="font-semibold text-primary">(px / %, e.g. auto)</span></label>
                                <input type="text" name="app_logo_height" class="kt-input h-[45px]" value="{{ optional($settings)->app_logo_height ?? 'auto' }}" placeholder="auto" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.auth_logo_width') ?? 'Auth Logo Width' }} <span class="font-semibold text-primary">(px / %, e.g. 150px)</span></label>
                                <input type="text" name="auth_logo_width" class="kt-input h-[45px]" value="{{ optional($settings)->auth_logo_width ?? '150px' }}" placeholder="150px" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.auth_logo_height') ?? 'Auth Logo Height' }} <span class="font-semibold text-primary">(px / %, e.g. auto)</span></label>
                                <input type="text" name="auth_logo_height" class="kt-input h-[45px]" value="{{ optional($settings)->auth_logo_height ?? 'auto' }}" placeholder="auto" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_columns_length') }}</label>
                                <input type="number" name="app_columns_length" class="kt-input h-[45px]" value="{{ optional($settings)->app_columns_length ?? 5 }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.app_sidebar_width') }}
                                    <span class="font-semibold text-primary">(px)</span>
                                </label>
                                <input type="number" name="app_sidebar_width" class="kt-input h-[45px]" value="{{ optional($settings)->app_sidebar_width ?? 250 }}" />
                            </div>

                            <div>
                                <label class="kt-label mb-2">{{ __('main.button_display_mode') }}</label>
                                <select name="button_display_mode" id="button_display_mode" class="kt-input h-[45px]" data-kt-select="true"
                                    data-kt-select-placeholder="{{ __('main.button_display_mode') }}">
                                    <option value="text" {{ getActiveUser()->button_display_mode == 'text' ? 'selected' : '' }}>
                                        {{ __('main.text') }}
                                    </option>
                                    <option value="icon" {{ getActiveUser()->button_display_mode == 'icon' ? 'selected' : '' }}>
                                        {{ __('main.icon') }}
                                    </option>
                                    <option value="both" {{ getActiveUser()->button_display_mode == 'both' ? 'selected' : '' }}>
                                        {{ __('main.both') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="flex gap-6 mb-4">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="app_show_uuid_column" value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="app_show_uuid_column" id="app_show_uuid_column"
                                        value="1" {{ optional($settings)->app_show_uuid_column ? 'checked' : '' }}>
                                    <label for="app_show_uuid_column">{{ __('main.app_show_uuid_column') }}</label>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="app_display_menu_labels" value="0">
                                <div class="custom-input">
                                    <input type="checkbox" name="app_display_menu_labels" id="app_display_menu_labels"
                                        value="1" {{ optional($settings)->app_display_menu_labels ? 'checked' : '' }}>
                                    <label for="app_display_menu_labels">{{ __('main.app_display_menu_labels') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-start gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="fa-duotone fa-solid fa-check text-sm me-2"></i>
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
                            <div class="font-semibold">{{ optional($settings)->app_version ?? '1.0.0' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.php_version') }}</div>
                            <div class="font-semibold">{{ optional($settings)->app_php_version ?? PHP_VERSION }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.operating_system') }}</div>
                            <div class="font-semibold">{{ env('DB_MODE') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.status') }}</div>
                            <div class="font-semibold text-success">
                                {{ optional($settings)->app_status == 1 || optional($settings)->app_status == true ? __('main.active') : __('main.inactive') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
