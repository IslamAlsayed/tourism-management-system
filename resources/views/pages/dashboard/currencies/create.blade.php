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
                            <!-- Currency Name (Arabic) -->
                            <div class="mb-3">
                                <label for="name_ar"
                                    class="kt-label required mb-2">{{ __('main.currency_name_arabic') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                    placeholder="{{ __('main.currency_name_arabic_example') }}" required
                                    value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Name (English) -->
                            <div class="mb-3">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.currency_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input"
                                    placeholder="{{ __('main.currency_name_english_example') }}" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Currency Code -->
                            <div class="mb-3">
                                <label for="code"
                                    class="kt-label required mb-2">{{ __('main.currency_code_iso') }}</label>
                                <input type="text" name="code" id="code" class="kt-input"
                                    placeholder="{{ __('main.currency_code_example') }}" maxlength="3" required
                                    value="{{ old('code') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.currency_code_hint') }}
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div class="mb-3">
                                <label for="symbol"
                                    class="kt-label required mb-2">{{ __('main.currency_symbol') }}</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input"
                                    placeholder="{{ __('main.currency_symbol_example') }}" maxlength="5" required
                                    value="{{ old('symbol') }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numeric Code -->
                            <div class="mb-3">
                                <label for="numeric_code" class="kt-label mb-2">{{ __('main.numeric_code') }}</label>
                                <input type="number" name="numeric_code" id="numeric_code" class="kt-input"
                                    placeholder="{{ __('main.numeric_code_example') }}" value="{{ old('numeric_code') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.numeric_code_hint') }}
                                </div>
                                @error('numeric_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Exchange Rate to USD -->
                            <div class="mb-3">
                                <label for="exchange_rate"
                                    class="kt-label required mb-2">{{ __('main.exchange_rate_usd') }}</label>
                                <input type="number" step="0.0001" name="exchange_rate" id="exchange_rate"
                                    class="kt-input" placeholder="{{ __('main.exchange_rate_example') }}" required
                                    value="{{ old('exchange_rate') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.exchange_rate_hint') }}
                                </div>
                                @error('exchange_rate')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Decimal Places -->
                            <div class="mb-3">
                                <label for="decimal_places" class="kt-label mb-2">{{ __('main.decimal_places') }}</label>
                                <select name="decimal_places" id="decimal_places" class="kt-select">
                                    <option value="0" {{ old('decimal_places') == '0' ? 'selected' : '' }}>
                                        {{ __('main.decimal_places_0') }}</option>
                                    <option value="2" {{ old('decimal_places', '2') == '2' ? 'selected' : '' }}>
                                        {{ __('main.decimal_places_2') }}</option>
                                    <option value="3" {{ old('decimal_places') == '3' ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ old('decimal_places') == '4' ? 'selected' : '' }}>4</option>
                                </select>
                                @error('decimal_places')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Countries using this currency -->
                            <div class="mb-3">
                                <label for="countries"
                                    class="kt-label mb-2">{{ __('main.countries_using_currency') }}</label>
                                <select name="countries[]" id="countries" class="kt-select" multiple>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name_ar }} -
                                            {{ $country->name_en }}</option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.multiple_countries_hint') }}
                                </div>
                                @error('countries')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Type -->
                            <div class="mb-3">
                                <label for="type" class="kt-label mb-2">{{ __('main.currency_type') }}</label>
                                <select name="type" id="type" class="kt-select">
                                    <option value="fiat" {{ old('type', 'fiat') == 'fiat' ? 'selected' : '' }}>
                                        {{ __('main.fiat_currency') }}</option>
                                    <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>
                                        {{ __('main.crypto_currency') }}</option>
                                    <option value="commodity" {{ old('type') == 'commodity' ? 'selected' : '' }}>
                                        {{ __('main.commodity_currency') }}</option>
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Subunits -->
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="mb-3">
                                <label for="subunit_name" class="kt-label mb-2">{{ __('main.subunit_name') }}</label>
                                <input type="text" name="subunit_name" id="subunit_name" class="kt-input"
                                    placeholder="{{ __('main.subunit_name_example') }}"
                                    value="{{ old('subunit_name') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.subunit_name_hint') }}
                                </div>
                                @error('subunit_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subunit_ratio" class="kt-label mb-2">{{ __('main.subunit_ratio') }}</label>
                                <input type="number" name="subunit_ratio" id="subunit_ratio" class="kt-input"
                                    placeholder="{{ __('main.subunit_ratio_example') }}"
                                    value="{{ old('subunit_ratio', '100') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.subunit_ratio_hint') }}
                                </div>
                                @error('subunit_ratio')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Symbol Position -->
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="mb-3">
                                <label for="symbol_position"
                                    class="kt-label mb-2">{{ __('main.symbol_position') }}</label>
                                <select name="symbol_position" id="symbol_position" class="kt-select">
                                    <option value="before"
                                        {{ old('symbol_position', 'before') == 'before' ? 'selected' : '' }}>
                                        {{ __('main.symbol_before') }}</option>
                                    <option value="after" {{ old('symbol_position') == 'after' ? 'selected' : '' }}>
                                        {{ __('main.symbol_after') }}</option>
                                </select>
                                @error('symbol_position')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="thousand_separator"
                                    class="kt-label mb-2">{{ __('main.thousand_separator') }}</label>
                                <select name="thousand_separator" id="thousand_separator" class="kt-select">
                                    <option value="," {{ old('thousand_separator', ',') == ',' ? 'selected' : '' }}>
                                        {{ __('main.comma_separator') }}</option>
                                    <option value="." {{ old('thousand_separator') == '.' ? 'selected' : '' }}>
                                        {{ __('main.dot_separator') }}</option>
                                    <option value=" " {{ old('thousand_separator') == ' ' ? 'selected' : '' }}>
                                        {{ __('main.space_separator') }}</option>
                                    <option value="" {{ old('thousand_separator') == '' ? 'selected' : '' }}>
                                        {{ __('main.no_separator') }}</option>
                                </select>
                                @error('thousand_separator')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="kt-label mb-2">{{ __('main.currency_description') }}</label>
                            <textarea name="description" id="description" rows="4" class="kt-input"
                                placeholder="{{ __('main.currency_description_placeholder') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Currency Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">{{ __('main.currency_settings') }}</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label for="is_active"
                                        class="kt-label mb-0">{{ __('main.activate_currency') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_crypto" id="is_crypto" class="kt-checkbox"
                                        value="1" {{ old('is_crypto') ? 'checked' : '' }}>
                                    <label for="is_crypto"
                                        class="kt-label mb-0">{{ __('main.is_crypto_currency') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="auto_update_rate" id="auto_update_rate"
                                        class="kt-checkbox" value="1"
                                        {{ old('auto_update_rate', '1') ? 'checked' : '' }}>
                                    <label for="auto_update_rate"
                                        class="kt-label mb-0">{{ __('main.auto_update_rate') }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_base_currency" id="is_base_currency"
                                        class="kt-checkbox" value="1"
                                        {{ old('is_base_currency') ? 'checked' : '' }}>
                                    <label for="is_base_currency"
                                        class="kt-label mb-0">{{ __('main.base_currency') }}</label>
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
