@extends('layouts.master')

@section('title', __('main.add_currency'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_currency') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_currency_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_currencies') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Currency Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.currency_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('currencies.store') }}" class="space-y-6 p-4">
                        @csrf

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Currency Name -->
                            <div class="mb-3">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.currency_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.currency_name_english_example') }}" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Code -->
                            <div class="mb-3">
                                <label for="code"
                                    class="kt-label required mb-2">{{ __('main.currency_code_iso') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.currency_code_example') }}" maxlength="3" required
                                    value="{{ old('code') }}" />
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div class="mb-3">
                                <label for="symbol"
                                    class="kt-label required mb-2">{{ __('main.currency_symbol') }}</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.currency_symbol_example') }}" max="5" required
                                    value="{{ old('symbol') }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country using this currency -->
                            {{-- <div class="mb-3">
                                <label for="country_id"
                                    class="kt-label mb-2">{{ __('main.countries_using_currency') }}</label>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name_ar }} - {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.multiple_countries_hint') }}
                                </div>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        </div>

                        <!-- Currency Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">{{ __('main.currency_settings') }}</h4>

                            <div class="grid lg:grid-cols-1 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">{{ __('main.activate_currency') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="auto_update_rate" id="auto_update_rate" class="kt-checkbox"
                                        value="1" {{ old('auto_update_rate', '1') ? 'checked' : '' }}>
                                    <label for="auto_update_rate"
                                        class="kt-label mb-0">{{ __('main.auto_update_rate') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="kt-card bg-secondary-light mt-4">
                            <div class="kt-card-header">
                                <h4 class="kt-card-title">{{ __('main.format_preview') }}</h4>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between w-60">
                                        <span>{{ __('main.amount_example') }}:</span>
                                        <span id="amount-preview" class="font-mono">$ 1,234.56</span>
                                    </div>
                                    <div class="flex justify-between w-60">
                                        <span>{{ __('main.symbol') }}:</span>
                                        <span id="symbol-preview" class="font-mono">$</span>
                                    </div>
                                    <div class="flex justify-between w-60">
                                        <span>{{ __('main.code') }}:</span>
                                        <span id="code-preview" class="font-mono">USD</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_currency') }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') }}
                            </button>
                            <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
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

@push('scripts')
    <script>
        // Live preview update
        function updatePreview() {
            const symbol = document.getElementById('symbol').value || '$';
            const code = document.getElementById('code').value || 'USD';
            const position = document.getElementById('symbol_position').value;
            const separator = document.getElementById('thousand_separator').value || ',';

            // Update previews
            document.getElementById('symbol-preview').textContent = symbol;
            document.getElementById('code-preview').textContent = code;

            // Format sample amount
            let amount = '1234.56';
            if (separator) {
                amount = '1' + separator + '234.56';
            }

            const formattedAmount = position === 'before' ? symbol + ' ' + amount : amount + ' ' + symbol;
            document.getElementById('amount-preview').textContent = formattedAmount;
        }

        // Add event listeners
        ['symbol', 'code', 'symbol_position', 'thousand_separator'].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
            document.getElementById(id).addEventListener('change', updatePreview);
        });

        // Auto-uppercase code
        document.getElementById('code').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Crypto currency toggle
        document.getElementById('is_crypto').addEventListener('change', function() {
            const typeField = document.getElementById('type');
            if (this.checked) {
                typeField.value = 'crypto';
            } else {
                typeField.value = 'fiat';
            }
        });

        // Initialize preview
        updatePreview();
    </script>
@endpush
