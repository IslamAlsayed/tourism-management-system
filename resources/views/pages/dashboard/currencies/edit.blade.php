@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.currency')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.currency')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.currency')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.currencies')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-6">
            <!-- Currency Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.currency_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('currencies.update', $currency->id) }}" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Currency Name -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.currency_name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ $currency->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Code -->
                            <div class="">
                                <label for="code"
                                    class="kt-label required mb-2">{{ __('main.currency_code_iso') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" maxlength="3"
                                    required value="{{ $currency->code }}" />
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div class="">
                                <label for="symbol"
                                    class="kt-label required mb-2">{{ __('main.currency_symbol') }}</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input h-[45px]" max="5"
                                    required value="{{ $currency->symbol }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Currency Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">{{ __('main.currency_settings') }}</h4>

                            <div class="grid lg:grid-cols-1 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ $currency->is_active == 1 ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">{{ __('main.activate_currency') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="auto_update_rate" id="auto_update_rate" class="kt-checkbox"
                                        value="1" {{ $currency->auto_update_rate == 1 ? 'checked' : '' }}>
                                    <label for="auto_update_rate"
                                        class="kt-label mb-0">{{ __('main.auto_update_rate') }}</label>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit" class="kt-btn kt-btn-primary">
                                    <i class="ki-filled ki-check text-sm me-2"></i>
                                    {{ __('main.save_currency') }}
                                </button>
                                <button type="submit" name="save_and_edit" value="1"
                                    class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                    <i class="ki-filled ki-plus text-sm me-2"></i>
                                    {{ __('main.save_and_edit_another') }}
                                </button>
                                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                                    {{ __('main.cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Currency Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.iso_4217_codes') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.use_standard_currency_codes') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-chart-line text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.exchange_rates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.auto_update_rates_hint') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.formatting_display') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.check_format_hint') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
