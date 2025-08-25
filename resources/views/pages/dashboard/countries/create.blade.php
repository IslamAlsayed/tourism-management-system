@extends('layouts.master')

@section('title', 'إضافة بلد جديد')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إضافة بلد جديد
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إضافة بلد جديد إلى قاعدة البيانات الجغرافية
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    العودة للبلدان
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات البلد</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Flag Upload -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div class="w-32 h-20 rounded-lg bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden flex items-center justify-center">
                                    <img id="flag-preview" src="" alt="علم البلد"
                                         class="w-full h-full object-cover hidden">
                                    <div id="flag-placeholder" class="text-4xl">🏳️</div>
                                </div>
                                <label for="flag" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="flag" name="flag" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">اضغط لتحميل علم البلد</div>
                            @error('flag')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country Name (Arabic) -->
                            <div>
                                <label for="name_ar" class="kt-label required">اسم البلد (عربي)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                       placeholder="أدخل اسم البلد بالعربية" required value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (English) -->
                            <div>
                                <label for="name_en" class="kt-label required">اسم البلد (إنجليزي)</label>
                                <input type="text" name="name_en" id="name_en" class="kt-input"
                                       placeholder="Enter country name in English" required value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Country Code (ISO 2) -->
                            <div>
                                <label for="code_iso2" class="kt-label required">كود البلد (ISO 2)</label>
                                <input type="text" name="code_iso2" id="code_iso2" class="kt-input"
                                       placeholder="مثال: SA, AE" maxlength="2" required value="{{ old('code_iso2') }}">
                                @error('code_iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div>
                                <label for="code_iso3" class="kt-label">كود البلد (ISO 3)</label>
                                <input type="text" name="code_iso3" id="code_iso3" class="kt-input"
                                       placeholder="مثال: SAU, ARE" maxlength="3" value="{{ old('code_iso3') }}">
                                @error('code_iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div>
                                <label for="phone_code" class="kt-label">كود الهاتف</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input"
                                       placeholder="مثال: +966" value="{{ old('phone_code') }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Capital City -->
                            <div>
                                <label for="capital" class="kt-label">العاصمة</label>
                                <input type="text" name="capital" id="capital" class="kt-input"
                                       placeholder="مثال: الرياض" value="{{ old('capital') }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency_id" class="kt-label">العملة الرسمية</label>
                                <select name="currency_id" id="currency_id" class="kt-select">
                                    <option value="">اختر العملة</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Population -->
                            <div>
                                <label for="population" class="kt-label">عدد السكان</label>
                                <input type="number" name="population" id="population" class="kt-input"
                                       placeholder="مثال: 35000000" value="{{ old('population') }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Area (km²) -->
                            <div>
                                <label for="area" class="kt-label">المساحة (كم²)</label>
                                <input type="number" step="any" name="area" id="area" class="kt-input"
                                       placeholder="مثال: 2149690" value="{{ old('area') }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Continent -->
                            <div>
                                <label for="continent" class="kt-label">القارة</label>
                                <select name="continent" id="continent" class="kt-select">
                                    <option value="">اختر القارة</option>
                                    <option value="Asia" {{ old('continent') == 'Asia' ? 'selected' : '' }}>آسيا</option>
                                    <option value="Africa" {{ old('continent') == 'Africa' ? 'selected' : '' }}>أفريقيا</option>
                                    <option value="Europe" {{ old('continent') == 'Europe' ? 'selected' : '' }}>أوروبا</option>
                                    <option value="North America" {{ old('continent') == 'North America' ? 'selected' : '' }}>أمريكا الشمالية</option>
                                    <option value="South America" {{ old('continent') == 'South America' ? 'selected' : '' }}>أمريكا الجنوبية</option>
                                    <option value="Australia" {{ old('continent') == 'Australia' ? 'selected' : '' }}>أستراليا</option>
                                    <option value="Antarctica" {{ old('continent') == 'Antarctica' ? 'selected' : '' }}>القارة القطبية الجنوبية</option>
                                </select>
                                @error('continent')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Region -->
                            <div>
                                <label for="region" class="kt-label">المنطقة</label>
                                <input type="text" name="region" id="region" class="kt-input"
                                       placeholder="مثال: الشرق الأوسط" value="{{ old('region') }}">
                                @error('region')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Latitude -->
                            <div>
                                <label for="latitude" class="kt-label">خط العرض</label>
                                <input type="number" step="any" name="latitude" id="latitude" class="kt-input"
                                       placeholder="مثال: 23.8859" value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div>
                                <label for="longitude" class="kt-label">خط الطول</label>
                                <input type="number" step="any" name="longitude" id="longitude" class="kt-input"
                                       placeholder="مثال: 45.0792" value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Timezone -->
                        <div>
                            <label for="timezone" class="kt-label">المنطقة الزمنية الرئيسية</label>
                            <select name="timezone" id="timezone" class="kt-select">
                                <option value="">اختر المنطقة الزمنية</option>
                                <option value="Asia/Riyadh" {{ old('timezone') == 'Asia/Riyadh' ? 'selected' : '' }}>آسيا/الرياض (+3)</option>
                                <option value="Asia/Dubai" {{ old('timezone') == 'Asia/Dubai' ? 'selected' : '' }}>آسيا/دبي (+4)</option>
                                <option value="Asia/Kuwait" {{ old('timezone') == 'Asia/Kuwait' ? 'selected' : '' }}>آسيا/الكويت (+3)</option>
                                <option value="Asia/Baghdad" {{ old('timezone') == 'Asia/Baghdad' ? 'selected' : '' }}>آسيا/بغداد (+3)</option>
                                <option value="Africa/Cairo" {{ old('timezone') == 'Africa/Cairo' ? 'selected' : '' }}>أفريقيا/القاهرة (+2)</option>
                                <option value="Europe/London" {{ old('timezone') == 'Europe/London' ? 'selected' : '' }}>أوروبا/لندن (+0)</option>
                                <option value="America/New_York" {{ old('timezone') == 'America/New_York' ? 'selected' : '' }}>أمريكا/نيويورك (-5)</option>
                            </select>
                            @error('timezone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Languages -->
                        <div>
                            <label for="languages" class="kt-label">اللغات الرسمية</label>
                            <input type="text" name="languages" id="languages" class="kt-input"
                                   placeholder="مثال: العربية، الإنجليزية" value="{{ old('languages') }}">
                            <div class="text-xs text-secondary-foreground mt-1">
                                اكتب اللغات مفصولة بفواصل
                            </div>
                            @error('languages')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="kt-label">وصف البلد</label>
                            <textarea name="description" id="description" rows="4" class="kt-input"
                                      placeholder="معلومات عامة عن البلد...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Country Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">إعدادات البلد</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1"
                                           {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">تفعيل البلد</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_independent" id="is_independent" class="kt-checkbox" value="1"
                                           {{ old('is_independent', '1') ? 'checked' : '' }}>
                                    <label for="is_independent" class="kt-label mb-0">دولة مستقلة</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_developed" id="is_developed" class="kt-checkbox" value="1"
                                           {{ old('is_developed') ? 'checked' : '' }}>
                                    <label for="is_developed" class="kt-label mb-0">دولة متقدمة</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_landlocked" id="is_landlocked" class="kt-checkbox" value="1"
                                           {{ old('is_landlocked') ? 'checked' : '' }}>
                                    <label for="is_landlocked" class="kt-label mb-0">غير ساحلية</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                حفظ البلد
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                حفظ وإضافة آخر
                            </button>
                            <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Geographic Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات جغرافية</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">الإحداثيات الجغرافية</div>
                                <div class="text-sm text-secondary-foreground">استخدم خدمات الخرائط للحصول على إحداثيات دقيقة</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">أكواد ISO</div>
                                <div class="text-sm text-secondary-foreground">تأكد من استخدام الأكواد الدولية المعتمدة</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-dollar text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">العملة الرسمية</div>
                                <div class="text-sm text-secondary-foreground">اختر العملة الرسمية للبلد</div>
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
    // Flag preview
    document.getElementById('flag').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('flag-preview');
                const placeholder = document.getElementById('flag-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-generate ISO codes
    document.getElementById('name_en').addEventListener('blur', function() {
        const name = this.value.toUpperCase();
        const iso2Field = document.getElementById('code_iso2');
        const iso3Field = document.getElementById('code_iso3');

        if (name && !iso2Field.value) {
            // Auto-generate basic codes (you can improve this logic)
            iso2Field.value = name.substring(0, 2);
        }

        if (name && !iso3Field.value) {
            iso3Field.value = name.substring(0, 3);
        }
    });

    // Phone code formatting
    document.getElementById('phone_code').addEventListener('input', function() {
        let value = this.value.replace(/[^\d]/g, '');
        if (value && !value.startsWith('+')) {
            this.value = '+' + value;
        }
    });
</script>
@endpush
