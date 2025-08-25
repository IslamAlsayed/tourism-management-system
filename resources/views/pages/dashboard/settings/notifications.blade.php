@extends('layouts.master')

@section('title', 'إعدادات الإشعارات')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إعدادات الإشعارات
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    تكوين الإشعارات والتنبيهات والرسائل
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
            <!-- Notification Channels -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">قنوات الإشعارات</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border rounded">
                                <div class="flex items-center gap-3">
                                    <i class="ki-filled ki-sms text-xl text-primary"></i>
                                    <div>
                                        <div class="font-semibold">إشعارات البريد الإلكتروني</div>
                                        <div class="text-sm text-secondary-foreground">استقبال الإشعارات عبر البريد الإلكتروني</div>
                                    </div>
                                </div>
                                <input type="checkbox" class="kt-checkbox kt-checkbox-lg" {{ $notificationSettings['email_notifications'] ? 'checked' : '' }} />
                            </div>

                            <div class="flex items-center justify-between p-4 border rounded">
                                <div class="flex items-center gap-3">
                                    <i class="ki-filled ki-phone text-xl text-success"></i>
                                    <div>
                                        <div class="font-semibold">رسائل SMS</div>
                                        <div class="text-sm text-secondary-foreground">استقبال الإشعارات عبر الرسائل النصية</div>
                                    </div>
                                </div>
                                <input type="checkbox" class="kt-checkbox kt-checkbox-lg" {{ $notificationSettings['sms_notifications'] ? 'checked' : '' }} />
                            </div>

                            <div class="flex items-center justify-between p-4 border rounded">
                                <div class="flex items-center gap-3">
                                    <i class="ki-filled ki-notification-bing text-xl text-warning"></i>
                                    <div>
                                        <div class="font-semibold">الإشعارات المنبثقة</div>
                                        <div class="text-sm text-secondary-foreground">إشعارات فورية في المتصفح</div>
                                    </div>
                                </div>
                                <input type="checkbox" class="kt-checkbox kt-checkbox-lg" {{ $notificationSettings['push_notifications'] ? 'checked' : '' }} />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification Types -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">أنواع الإشعارات</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">مستخدم جديد</div>
                                <div class="text-sm text-secondary-foreground">عند تسجيل مستخدم جديد</div>
                            </div>
                            <input type="checkbox" class="kt-checkbox" checked />
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">تحديث البيانات</div>
                                <div class="text-sm text-secondary-foreground">عند تحديث بيانات مهمة</div>
                            </div>
                            <input type="checkbox" class="kt-checkbox" checked />
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">تقارير النظام</div>
                                <div class="text-sm text-secondary-foreground">تقارير دورية عن حالة النظام</div>
                            </div>
                            <input type="checkbox" class="kt-checkbox" />
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">تحديثات الأمان</div>
                                <div class="text-sm text-secondary-foreground">إشعارات أمنية مهمة</div>
                            </div>
                            <input type="checkbox" class="kt-checkbox" checked />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Notification -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">اختبار الإشعارات</h3>
                </div>
                <div class="kt-card-body">
                    <p class="text-sm text-secondary-foreground mb-4">
                        يمكنك إرسال إشعار تجريبي للتأكد من عمل الإعدادات بشكل صحيح
                    </p>
                    <div class="flex gap-3">
                        <button class="kt-btn kt-btn-outline kt-btn-outline-primary">
                            <i class="ki-filled ki-sms text-sm me-2"></i>
                            اختبار البريد الإلكتروني
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-success">
                            <i class="ki-filled ki-phone text-sm me-2"></i>
                            اختبار SMS
                        </button>
                        <button class="kt-btn kt-btn-outline kt-btn-outline-warning">
                            <i class="ki-filled ki-notification-bing text-sm me-2"></i>
                            اختبار الإشعار المنبثق
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
