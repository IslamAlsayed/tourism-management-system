@extends('layouts.master')

@section('title', 'إضافة عملة جديدة')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إضافة عملة جديدة
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إضافة عملة جديدة إلى النظام المالي
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                    العودة للعملات
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Currency Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات العملة</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('currencies.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Currency Name (Arabic) -->
                            <div>
                                <label for="name_ar" class="kt-label required">اسم العملة (عربي)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                       placeholder="مثال: الريال السعودي" required value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Name (English) -->
                            <div>
                                <label for="name_en" class="kt-label required">اسم العملة (إنجليزي)</label>
                                <input type="text" name="name_en" id="name_en" class="kt-input"
                                       placeholder="Example: Saudi Riyal" required value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Currency Code -->
                            <div>
                                <label for="code" class="kt-label required">كود العملة (ISO)</label>
                                <input type="text" name="code" id="code" class="kt-input"
                                       placeholder="مثال: SAR, USD" maxlength="3" required value="{{ old('code') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    كود ISO 4217 المعياري (3 أحرف)
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Symbol -->
                            <div>
                                <label for="symbol" class="kt-label required">رمز العملة</label>
                                <input type="text" name="symbol" id="symbol" class="kt-input"
                                       placeholder="مثال: ﷼، $" maxlength="5" required value="{{ old('symbol') }}">
                                @error('symbol')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numeric Code -->
                            <div>
                                <label for="numeric_code" class="kt-label">الكود الرقمي</label>
                                <input type="number" name="numeric_code" id="numeric_code" class="kt-input"
                                       placeholder="مثال: 682" value="{{ old('numeric_code') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    كود ISO 4217 الرقمي (3 أرقام)
                                </div>
                                @error('numeric_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Exchange Rate to USD -->
                            <div>
                                <label for="exchange_rate" class="kt-label required">سعر الصرف مقابل الدولار</label>
                                <input type="number" step="0.0001" name="exchange_rate" id="exchange_rate" class="kt-input"
                                       placeholder="مثال: 3.7500" required value="{{ old('exchange_rate') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    1 USD = كم وحدة من هذه العملة
                                </div>
                                @error('exchange_rate')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Decimal Places -->
                            <div>
                                <label for="decimal_places" class="kt-label">عدد المنازل العشرية</label>
                                <select name="decimal_places" id="decimal_places" class="kt-select">
                                    <option value="0" {{ old('decimal_places') == '0' ? 'selected' : '' }}>0 (بدون كسور)</option>
                                    <option value="2" {{ old('decimal_places', '2') == '2' ? 'selected' : '' }}>2 (افتراضي)</option>
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
                            <div>
                                <label for="countries" class="kt-label">البلدان التي تستخدم هذه العملة</label>
                                <select name="countries[]" id="countries" class="kt-select" multiple>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name_ar }} - {{ $country->name_en }}</option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-secondary-foreground mt-1">
                                    يمكنك اختيار عدة بلدان
                                </div>
                                @error('countries')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency Type -->
                            <div>
                                <label for="type" class="kt-label">نوع العملة</label>
                                <select name="type" id="type" class="kt-select">
                                    <option value="fiat" {{ old('type', 'fiat') == 'fiat' ? 'selected' : '' }}>عملة ورقية</option>
                                    <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>عملة رقمية</option>
                                    <option value="commodity" {{ old('type') == 'commodity' ? 'selected' : '' }}>عملة سلعية</option>
                                </select>
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Subunits -->
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label for="subunit_name" class="kt-label">اسم الوحدة الفرعية</label>
                                <input type="text" name="subunit_name" id="subunit_name" class="kt-input"
                                       placeholder="مثال: هللة، سنت" value="{{ old('subunit_name') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    الوحدة الأصغر من العملة (مثل الهللة للريال)
                                </div>
                                @error('subunit_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="subunit_ratio" class="kt-label">نسبة الوحدة الفرعية</label>
                                <input type="number" name="subunit_ratio" id="subunit_ratio" class="kt-input"
                                       placeholder="مثال: 100" value="{{ old('subunit_ratio', '100') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    كم وحدة فرعية تساوي وحدة واحدة أساسية
                                </div>
                                @error('subunit_ratio')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Symbol Position -->
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label for="symbol_position" class="kt-label">موضع الرمز</label>
                                <select name="symbol_position" id="symbol_position" class="kt-select">
                                    <option value="before" {{ old('symbol_position', 'before') == 'before' ? 'selected' : '' }}>قبل الرقم ($ 100)</option>
                                    <option value="after" {{ old('symbol_position') == 'after' ? 'selected' : '' }}>بعد الرقم (100 ﷼)</option>
                                </select>
                                @error('symbol_position')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="thousand_separator" class="kt-label">فاصل الآلاف</label>
                                <select name="thousand_separator" id="thousand_separator" class="kt-select">
                                    <option value="," {{ old('thousand_separator', ',') == ',' ? 'selected' : '' }}>فاصلة (1,000)</option>
                                    <option value="." {{ old('thousand_separator') == '.' ? 'selected' : '' }}>نقطة (1.000)</option>
                                    <option value=" " {{ old('thousand_separator') == ' ' ? 'selected' : '' }}>مسافة (1 000)</option>
                                    <option value="" {{ old('thousand_separator') == '' ? 'selected' : '' }}>بدون فاصل</option>
                                </select>
                                @error('thousand_separator')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="kt-label">وصف العملة</label>
                            <textarea name="description" id="description" rows="4" class="kt-input"
                                      placeholder="معلومات إضافية عن العملة...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Currency Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">إعدادات العملة</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1"
                                           {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">تفعيل العملة</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_crypto" id="is_crypto" class="kt-checkbox" value="1"
                                           {{ old('is_crypto') ? 'checked' : '' }}>
                                    <label for="is_crypto" class="kt-label mb-0">عملة رقمية</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="auto_update_rate" id="auto_update_rate" class="kt-checkbox" value="1"
                                           {{ old('auto_update_rate', '1') ? 'checked' : '' }}>
                                    <label for="auto_update_rate" class="kt-label mb-0">تحديث السعر تلقائياً</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_base_currency" id="is_base_currency" class="kt-checkbox" value="1"
                                           {{ old('is_base_currency') ? 'checked' : '' }}>
                                    <label for="is_base_currency" class="kt-label mb-0">العملة الأساسية</label>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="kt-card bg-secondary-light">
                            <div class="kt-card-header">
                                <h4 class="kt-card-title">معاينة التنسيق</h4>
                            </div>
                            <div class="kt-card-body">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>مثال على المبلغ:</span>
                                        <span id="amount-preview" class="font-mono">$ 1,234.56</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>الرمز:</span>
                                        <span id="symbol-preview" class="font-mono">$</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>الكود:</span>
                                        <span id="code-preview" class="font-mono">USD</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                حفظ العملة
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                حفظ وإضافة أخرى
                            </button>
                            <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-outline">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Currency Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات مهمة</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">أكواد ISO 4217</div>
                                <div class="text-sm text-secondary-foreground">استخدم الأكواد المعيارية الدولية للعملات</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-chart-line text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">أسعار الصرف</div>
                                <div class="text-sm text-secondary-foreground">سيتم تحديث الأسعار تلقائياً من مصادر موثوقة</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">التنسيق والعرض</div>
                                <div class="text-sm text-secondary-foreground">تأكد من ضبط موضع الرمز وفاصل الآلاف بشكل صحيح</div>
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
