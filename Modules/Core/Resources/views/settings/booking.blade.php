@extends('layouts.master')

@section('title', __('main.booking_settings'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.booking_settings') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.configure_booking_payment_settings') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.settings.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.settings')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <form method="POST" action="{{ route('dashboard.core.settings.update', $settings->id) }}">
                @csrf
                @method('PUT')

                <!-- Booking Settings -->
                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.booking_rules') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-6 p-4">
                            <div class="grid lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.free_cancellation_days') }}</label>
                                    <input type="number" name="app_free_cancellation_days" class="kt-input h-[45px]"
                                        value="{{ $settings->app_free_cancellation_days }}" minLength="0" />
                                    <div class="text-xs text-secondary-foreground mt-1">
                                        {{ __('main.days_before_checkin_free_cancel') }}
                                    </div>
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.min_advance_booking') }}</label>
                                    <input type="number" name="app_min_advance_booking_days" class="kt-input h-[45px]"
                                        value="{{ $settings->app_min_advance_booking_days }}" minLength="0" />
                                    <div class="text-xs text-secondary-foreground mt-1">
                                        {{ __('main.minimum_days_advance_booking') }}
                                    </div>
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.default_currency') }}</label>
                                    <select name="app_default_currency" class="kt-select h-[45px]">
                                        <option value="SAR" {{ $settings->app_default_currency == 'SAR' ? 'selected' : '' }}>
                                            {{ __('main.sar') }} (﷼)
                                        </option>
                                        <option value="USD" {{ $settings->app_default_currency == 'USD' ? 'selected' : '' }}>
                                            {{ __('main.usd') }} ($)
                                        </option>
                                        <option value="EUR" {{ $settings->app_default_currency == 'EUR' ? 'selected' : '' }}>
                                            {{ __('main.eur') }} (€)
                                        </option>
                                        <option value="GBP" {{ $settings->app_default_currency == 'GBP' ? 'selected' : '' }}>
                                            {{ __('main.gbp') }} (£)
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.default_tax_rate') }} (%)</label>
                                    <input type="number" name="app_default_tax_rate" class="kt-input h-[45px]" value="{{ $settings->app_default_tax_rate }}"
                                        step="0.01" minLength="0" maxLength="100" />
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.service_fee') }} (%)</label>
                                    <input type="number" name="app_service_fee_percentage" class="kt-input h-[45px]"
                                        value="{{ $settings->app_service_fee_percentage }}" step="0.01" minLength="0" maxLength="100" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.payment_settings') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-6 p-4">
                            <div class="grid lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.minimum_deposit') }} (%)</label>
                                    <input type="number" name="app_minimum_deposit_percentage" class="kt-input h-[45px]"
                                        value="{{ $settings->app_minimum_deposit_percentage }}" step="0.01" minLength="0" maxLength="100" />
                                    <div class="text-xs text-secondary-foreground mt-1">
                                        {{ __('main.min_required_deposit_percentage') }}
                                    </div>
                                </div>

                                <div>
                                    <label class="kt-label mb-2">{{ __('main.payment_grace_period') }}</label>
                                    <input type="number" name="app_payment_grace_period_days" class="kt-input h-[45px]"
                                        value="{{ $settings->app_payment_grace_period_days }}" minLength="0" />
                                    <div class="text-xs text-secondary-foreground mt-1">
                                        {{ __('main.days_allowed_for_payment') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Settings -->
                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.display_settings') }}</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-6 p-4">
                            <div class="grid lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="kt-label mb-2">{{ __('main.new_deals_duration') }}</label>
                                    <input type="number" name="app_new_deals_duration_days" class="kt-input h-[45px]"
                                        value="{{ $settings->app_new_deals_duration_days }}" minLength="1" />
                                    <div class="text-xs text-secondary-foreground mt-1">
                                        {{ __('main.days_to_show_as_new') }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="app_smart_search_enabled" value="0">
                                    @include('components.elements.checkbox-button', [
                                        'name' => 'app_smart_search_enabled',
                                        'id' => 'app_smart_search_enabled',
                                        'value' => '1',
                                        'checked' => $settings->app_smart_search_enabled == 1,
                                        'label' => __('main.app_smart_search_enabled'),
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-start gap-4">
                    <button type="submit" class="kt-btn kt-btn-primary">
                        <i class="fas fa-check text-sm me-2"></i>
                        {{ __('main.save_type', ['type' => __('main.settings')]) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
