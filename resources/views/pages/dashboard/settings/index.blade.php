@extends('layouts.master')

@section('title', 'إعدادات النظام')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إعدادات النظام
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إدارة وتكوين إعدادات النظام العامة
                </div>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Settings Menu -->
            <div class="grid lg:grid-cols-2 xl:grid-cols-4 gap-5">
                <!-- General Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center">
                        <div class="bg-primary-light rounded-full p-4 mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-setting-2 text-3xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">الإعدادات العامة</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            إعدادات التطبيق الأساسية والتكوين العام
                        </p>
                        <a href="{{ route('settings.general') }}" class="kt-btn kt-btn-primary kt-btn-sm">
                            إدارة الإعدادات
                        </a>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center">
                        <div class="bg-success-light rounded-full p-4 mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-shield-tick text-3xl text-success"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">إعدادات الأمان</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            إعدادات كلمات المرور والأمان والحماية
                        </p>
                        <a href="{{ route('settings.security') }}" class="kt-btn kt-btn-success kt-btn-sm">
                            إدارة الأمان
                        </a>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center">
                        <div class="bg-warning-light rounded-full p-4 mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-notification-bing text-3xl text-warning"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">إعدادات الإشعارات</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            تكوين الإشعارات والتنبيهات والرسائل
                        </p>
                        <a href="{{ route('settings.notifications') }}" class="kt-btn kt-btn-warning kt-btn-sm">
                            إدارة الإشعارات
                        </a>
                    </div>
                </div>

                <!-- Backup Settings -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-body text-center">
                        <div class="bg-info-light rounded-full p-4 mx-auto mb-4 w-fit">
                            <i class="ki-filled ki-cloud-download text-3xl text-info"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">النسخ الاحتياطي</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            إدارة النسخ الاحتياطية واستعادة البيانات
                        </p>
                        <a href="{{ route('settings.backup') }}" class="kt-btn kt-btn-info kt-btn-sm">
                            إدارة النسخ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">إجراءات سريعة</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-3 gap-4">
                        <button class="kt-btn kt-btn-outline kt-btn-outline-primary">
                            <i class="ki-filled ki-arrows-circle text-sm me-2"></i>
                            مسح الذاكرة المؤقتة
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-success">
                            <i class="ki-filled ki-check-circle text-sm me-2"></i>
                            فحص النظام
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-warning">
                            <i class="ki-filled ki-file-up text-sm me-2"></i>
                            تحديث النظام
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
