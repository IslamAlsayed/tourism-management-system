@extends('layouts.master')

@section('title', __('main.edit_country'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_country') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_country_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_countries') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Country Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.country_information') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('countries.update', $country->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Flag Upload -->
                        <div class="text-center mb-4">
                            <div class="relative inline-block">
                                <div
                                    class="w-32 h-20 rounded-lg bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden flex items-center justify-center">
                                    <img id="flag-preview" src="" alt="{{ __('main.country_flag') }}"
                                        class="w-full h-full object-cover hidden">
                                    <div id="flag-placeholder" class="text-4xl">🏳️</div>
                                </div>
                                <label for="flag"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="flag" name="flag" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.click_to_upload_flag') }}</div>
                            @error('flag')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Country Name (Arabic) -->
                            <div class="mb-3">
                                <label for="name_ar"
                                    class="kt-label required mb-2">{{ __('main.country_name_arabic') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input"
                                    placeholder="{{ __('main.enter_country_name_arabic') }}" required
                                    value="{{ $country->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Name (English) -->
                            <div class="mb-3">
                                <label for="name"
                                    class="kt-label required mb-2">{{ __('main.country_name_english') }}</label>
                                <input type="text" name="name" id="name" class="kt-input"
                                    placeholder="{{ __('main.enter_country_name_english') }}" required
                                    value="{{ $country->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Code -->
                            <div class="mb-3">
                                <label for="phone_code" class="kt-label mb-2">{{ __('main.phone_code') }}</label>
                                <input type="text" name="phone_code" id="phone_code" class="kt-input"
                                    placeholder="{{ __('main.phone_code_example') }}" value="{{ $country->phone_code }}">
                                @error('phone_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Country Code (ISO 2) -->
                            <div class="mb-3">
                                <label for="iso2"
                                    class="kt-label required mb-2">{{ __('main.country_code_iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input"
                                    placeholder="{{ __('main.iso2_example') }}" max="2" required
                                    value="{{ $country->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code (ISO 3) -->
                            <div class="mb-3">
                                <label for="iso3" class="kt-label mb-2">كود البلد (ISO 3)</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input"
                                    placeholder="مثال: SAU, ARE" max="3" value="{{ $country->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capital City -->
                            <div class="mb-3">
                                <label for="capital" class="kt-label mb-2">العاصمة</label>
                                <input type="text" name="capital" id="capital" class="kt-input"
                                    placeholder="مثال: الرياض" value="{{ $country->capital }}">
                                @error('capital')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Currency -->
                            <div class="mb-3">
                                <label for="currency_id" class="kt-label mb-2">العملة الرسمية</label>
                                <select name="currency_id" id="currency_id" class="kt-select">
                                    <option value="">اختر العملة</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $country->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }} - {{ $currency->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Population -->
                            <div class="mb-3">
                                <label for="population" class="kt-label mb-2">عدد السكان</label>
                                <input type="number" name="population" id="population" class="kt-input"
                                    placeholder="مثال: 35000000" value="{{ $country->population }}">
                                @error('population')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Area (km²) -->
                            <div class="mb-3">
                                <label for="area" class="kt-label mb-2">المساحة (كم²)</label>
                                <input type="number" step="any" name="area" id="area" class="kt-input"
                                    placeholder="مثال: 2149690" value="{{ $country->area }}">
                                @error('area')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Continent -->
                            <div class="mb-3">
                                <label for="continent" class="kt-label mb-2">القارة</label>
                                <select name="continent" id="continent" class="kt-select">
                                    <option value="">اختر القارة</option>
                                    @foreach (config('helpers.continents') as $continent)
                                        <option value="{{ $continent }}"
                                            {{ $country->continent == $continent ? 'selected' : '' }}>
                                            {{ __('main.maps.' . $continent) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('continent')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Region -->
                            <div class="mb-3">
                                <label for="region" class="kt-label mb-2">المنطقة</label>
                                <input type="text" name="region" id="region" class="kt-input"
                                    placeholder="مثال: الشرق الأوسط" value="{{ $country->region }}">
                                @error('region')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="mb-3">
                                <label for="latitude" class="kt-label mb-2">خط العرض</label>
                                <input type="number" step="any" name="latitude" id="latitude" class="kt-input"
                                    placeholder="مثال: 23.8859" value="{{ $country->latitude }}">
                                @error('latitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6">
                            <!-- Longitude -->
                            <div class="mb-3">
                                <label for="longitude" class="kt-label mb-2">خط الطول</label>
                                <input type="number" step="any" name="longitude" id="longitude" class="kt-input"
                                    placeholder="مثال: 45.0792" value="{{ $country->longitude }}">
                                @error('longitude')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="mb-3">
                                <label for="timezone" class="kt-label mb-2">المنطقة الزمنية الرئيسية</label>
                                <select name="timezone" id="timezone" class="kt-select">
                                    <option value="">اختر المنطقة الزمنية</option>
                                    @foreach (config('helpers.timezones') as $zone)
                                        <option value="{{ $zone }}"
                                            {{ $country->timezone == $zone ? 'selected' : '' }}>
                                            {{ __('main.maps.' . $zone) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Languages -->
                            <div class="mb-3">
                                <label for="languages" class="kt-label mb-2">اللغات الرسمية</label>
                                <input type="text" name="languages" id="languages" class="kt-input"
                                    placeholder="مثال: العربية، الإنجليزية" value="{{ $country->languages }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    اكتب اللغات مفصولة بفواصل
                                </div>
                                @error('languages')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="kt-label mb-2">وصف البلد</label>
                                <textarea name="description" id="description" rows="4" class="kt-input"
                                    placeholder="معلومات عامة عن البلد...">{{ $country->description }}</textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Country Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold mb-1">إعدادات البلد</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ $country->is_active == 1 ? 'checked' : '' }}>
                                    <label for="is_active" class="kt-label mb-0">تفعيل البلد</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_independent" id="is_independent" class="kt-checkbox"
                                        value="1" {{ $country->is_independent == '1' ? 'checked' : '' }}>
                                    <label for="is_independent" class="kt-label mb-0">دولة مستقلة</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_developed" id="is_developed" class="kt-checkbox"
                                        value="1" {{ $country->is_developed ? 'checked' : '' }}>
                                    <label for="is_developed" class="kt-label mb-0">دولة متقدمة</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="is_landlocked" id="is_landlocked" class="kt-checkbox"
                                        value="1" {{ $country->is_landlocked ? 'checked' : '' }}>
                                    <label for="is_landlocked" class="kt-label mb-0">غير ساحلية</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                تعديل البلد
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
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">الإحداثيات الجغرافية</div>
                                <div class="text-sm text-secondary-foreground">
                                    استخدم خدمات الخرائط للحصول على إحداثيات دقيقة
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-flag text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">أكواد ISO</div>
                                <div class="text-sm text-secondary-foreground">تأكد من استخدام الأكواد الدولية المعتمدة
                                </div>
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
        document.getElementById('name').addEventListener('blur', function() {
            const name = this.value.toUpperCase();
            const iso2Field = document.getElementById('iso2');
            const iso3Field = document.getElementById('iso3');

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
