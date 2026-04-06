@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.currency')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.currency')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.currency')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.currencies')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-6">
            <!-- Currency Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.currency_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.localization.currencies.update', $currency->id) }}"
                        class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Currency Name -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $currency->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Name (English) -->
                            <div class="">
                                <label for="name_en" class="kt-label mb-2">{{ __('main.name_en') ?? 'Name (English)' }}</label>
                                <input type="text" name="name_en" id="name_en" class="kt-input h-[45px]"
                                    value="{{ $currency->name_en }}">
                                @error('name_en')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Code -->
                            <div class="">
                                <label for="code" class="kt-label mb-2">{{ __('main.currency_code_iso') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" maxlength="3"
                                    value="{{ $currency->code }}" />
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div class="">
                                <label for="symbol" class="kt-label mb-2">{{ __('main.currency_symbol') }}</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input h-[45px]" maxLength="5"
                                    value="{{ $currency->symbol }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Exchange Rate -->
                            <div class="">
                                <label for="exchange_rate" class="kt-label mb-2">{{ __('main.exchange_rate') }}</label>
                                <input type="number" step="0.000001" name="exchange_rate" id="exchange_rate" class="kt-input h-[45px]"
                                    value="{{ $currency->exchange_rate }}">
                                @error('exchange_rate')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Decimal Places -->
                            <div class="">
                                <label for="decimal_places" class="kt-label mb-2">{{ __('main.decimal_places') ?? 'Decimal Places' }}</label>
                                <input type="number" name="decimal_places" id="decimal_places" class="kt-input h-[45px]"
                                    value="{{ $currency->decimal_places }}">
                                @error('decimal_places')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Sort Order -->
                            <div class="">
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') ?? 'Sort Order' }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ $currency->sort_order }}">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-6 border-dashed border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-4">
                            <!-- Currency Settings -->
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="is_active" value="0">
                                <label class="switch switch-sm" for="is_active">
                                    <input class="switch-input" name="is_active" id="is_active" type="checkbox" value="1" {{ $currency->is_active ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.active') }}</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="hidden" name="is_auto_update" value="0">
                                <label class="switch switch-sm" for="is_auto_update">
                                    <input class="switch-input" name="is_auto_update" id="is_auto_update" type="checkbox" value="1" {{ $currency->is_auto_update ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.auto_update_rate') ?? 'Auto Update Rate' }}</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="hidden" name="is_base_currency" value="0">
                                <label class="switch switch-sm" for="is_base_currency">
                                    <input class="switch-input" name="is_base_currency" id="is_base_currency" type="checkbox" value="1" {{ $currency->is_base_currency ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.is_base_currency') ?? 'Base Currency' }}</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="hidden" name="is_major_currency" value="0">
                                <label class="switch switch-sm" for="is_major_currency">
                                    <input class="switch-input" name="is_major_currency" id="is_major_currency" type="checkbox" value="1" {{ $currency->is_major_currency ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.is_major_currency') ?? 'Major Currency' }}</span>
                                </label>
                            </div>
                        </div>

                            <!-- Update Submit Buttons -->
                            @include('components.elements.update-submit', [
                                'models' => 'currencies',
                                'cancel_route' => route('dashboard.localization.currencies.index'),
                            ])
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
                                <i class="fa-duotone fa-solid fa-circle-info text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.iso_4217_codes') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.use_standard_currency_codes') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-chart-line text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.exchange_rates') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.auto_update_rates_hint') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="fa-duotone fa-solid fa-dollar-sign text-warning"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.formatting_display') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.check_format_hint') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
