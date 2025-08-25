@extends('layouts.master')

@section('title', 'الإعدادات العامة')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    الإعدادات العامة
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    تكوين الإعدادات الأساسية للتطبيق
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    العودة للإعدادات
                </a>
                <button class="kt-btn kt-btn-primary">
                    حفظ التغييرات
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Application Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">إعدادات التطبيق</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label class="kt-label">اسم التطبيق</label>
                                <input type="text" class="kt-input" value="{{ $settings['app_name'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">اسم التطبيق الذي سيظهر في العنوان</div>
                            </div>
                            <div>
                                <label class="kt-label">رابط التطبيق</label>
                                <input type="url" class="kt-input" value="{{ $settings['app_url'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">الرابط الأساسي للتطبيق</div>
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label class="kt-label">المنطقة الزمنية</label>
                                <select class="kt-select">
                                    <option value="UTC" {{ $settings['app_timezone'] == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="Asia/Riyadh" {{ $settings['app_timezone'] == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh</option>
                                    <option value="Asia/Dubai" {{ $settings['app_timezone'] == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                </select>
                            </div>
                            <div>
                                <label class="kt-label">اللغة الافتراضية</label>
                                <select class="kt-select">
                                    <option value="en" {{ $settings['app_locale'] == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ $settings['app_locale'] == 'ar' ? 'selected' : '' }}>العربية</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- System Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">معلومات النظام</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm text-secondary-foreground">إصدار Laravel</div>
                            <div class="font-semibold">{{ app()->version() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">إصدار PHP</div>
                            <div class="font-semibold">{{ PHP_VERSION }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">بيئة التشغيل</div>
                            <div class="font-semibold">{{ app()->environment() }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-secondary-foreground">حالة التطبيق</div>
                            <div class="font-semibold text-success">يعمل بشكل طبيعي</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
