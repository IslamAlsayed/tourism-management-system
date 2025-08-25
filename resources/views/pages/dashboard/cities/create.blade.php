@extends('layouts.master')

@section('title', 'إضافة مدينة جديدة')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إضافة مدينة جديدة
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إضافة مدينة جديدة إلى قاعدة البيانات الجغرافية
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                    العودة للمدن
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- City Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات المدينة</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('cities.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- City Name (Arabic) -->
                            <div>
                                <label for="name_ar" class="kt-label required">اسم المدينة (عربي)</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                       placeholder="أدخل اسم المدينة بالعربية" required>
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City Name (English) -->
                            <div>
                                <label for="name_en" class="kt-label required">اسم المدينة (إنجليزي)</label>
                                <input type="text" name="name_en" id="name_en" class="kt-input"
                                       placeholder="Enter city name in English" required>
                                @error('name_en')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Country -->
                            <div>
                                <label for="country_id" class="kt-label required">البلد</label>
                                <select name="country_id" id="country_id" class="kt-select" required>
                                    <option value="">اختر البلد</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name_ar }} - {{ $country->name_en }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City Code -->
                            <div>
                                <label for="code" class="kt-label">كود المدينة</label>
                                <input type="text" name="code" id="code" class="kt-input"
                                       placeholder="مثال: RYD, JED">
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Latitude -->
                            <div>
                                <label for="latitude" class="kt-label">خط العرض</label>
                                <input type="number" step="any" name="latitude" id="latitude" class="kt-input"
                                       placeholder="مثال: 24.7136">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div>
                                <label for="longitude" class="kt-label">خط الطول</label>
                                <input type="number" step="any" name="longitude" id="longitude" class="kt-input"
                                       placeholder="مثال: 46.6753">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Population -->
                            <div>
                                <label for="population" class="kt-label">عدد السكان</label>
                                <input type="number" name="population" id="population" class="kt-input"
                                       placeholder="مثال: 1000000">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Time Zone -->
                            <div>
                                <label for="timezone" class="kt-label">المنطقة الزمنية</label>
                                <select name="timezone" id="timezone" class="kt-select">
                                    <option value="">اختر المنطقة الزمنية</option>
                                    <option value="Asia/Riyadh">آسيا/الرياض (+3)</option>
                                    <option value="Asia/Dubai">آسيا/دبي (+4)</option>
                                    <option value="Asia/Kuwait">آسيا/الكويت (+3)</option>
                                    <option value="Asia/Baghdad">آسيا/بغداد (+3)</option>
                                    <option value="Africa/Cairo">أفريقيا/القاهرة (+2)</option>
                                    <option value="Asia/Beirut">آسيا/بيروت (+2)</option>
                                </select>
                                @error('timezone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="kt-label">وصف المدينة</label>
                            <textarea name="description" id="description" rows="4" class="kt-input"
                                      placeholder="معلومات إضافية عن المدينة..."></textarea>
                            @error('description')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox" value="1" checked>
                                <label for="is_active" class="kt-label mb-0">تفعيل المدينة</label>
                            </div>
                            <div class="text-sm text-secondary-foreground mt-1">
                                المدن المفعلة ستظهر في القوائم والتقارير
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                حفظ المدينة
                            </button>
                            <button type="submit" name="save_and_add" value="1" class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                حفظ وإضافة أخرى
                            </button>
                            <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-outline">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
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
                                <div class="font-semibold">تأكد من دقة البيانات</div>
                                <div class="text-sm text-secondary-foreground">يُرجى التحقق من صحة إحداثيات المدينة قبل الحفظ</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">الإحداثيات الجغرافية</div>
                                <div class="text-sm text-secondary-foreground">استخدم خدمات الخرائط للحصول على إحداثيات دقيقة</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">اختيار البلد</div>
                                <div class="text-sm text-secondary-foreground">يجب تحديد البلد قبل إضافة المدينة</div>
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
    // Auto-generate English name from Arabic
    document.getElementById('name_ar').addEventListener('input', function() {
        const arabicName = this.value;
        // You can add transliteration logic here if needed
    });

    // Country change handler
    document.getElementById('country_id').addEventListener('change', function() {
        const countryId = this.value;
        if (countryId) {
            // You can load timezone and other country-specific data here
        }
    });
</script>
@endpush
