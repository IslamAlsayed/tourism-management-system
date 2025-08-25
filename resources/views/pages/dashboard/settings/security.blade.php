@extends('layouts.master')

@section('title', 'إعدادات الأمان')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إعدادات الأمان
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    تكوين إعدادات الأمان وكلمات المرور
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
            <!-- Password Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">إعدادات كلمة المرور</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <label class="kt-label">الحد الأدنى لطول كلمة المرور</label>
                                <input type="number" class="kt-input" value="{{ $securitySettings['password_min_length'] }}" min="6" max="20" />
                                <div class="text-xs text-secondary-foreground mt-1">أقل عدد من الأحرف المطلوبة</div>
                            </div>
                            <div>
                                <label class="kt-label">مدة انتهاء الجلسة (بالدقائق)</label>
                                <input type="number" class="kt-input" value="{{ $securitySettings['session_lifetime'] }}" />
                                <div class="text-xs text-secondary-foreground mt-1">مدة بقاء المستخدم مسجل الدخول</div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="kt-checkbox" {{ $securitySettings['require_password_confirmation'] ? 'checked' : '' }} />
                                <label class="text-sm">طلب تأكيد كلمة المرور للعمليات الحساسة</label>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="kt-checkbox" {{ $securitySettings['enable_two_factor'] ? 'checked' : '' }} />
                                <label class="text-sm">تفعيل المصادقة الثنائية</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Status -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">حالة الأمان</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-success-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-shield-tick text-success text-xl"></i>
                                <div>
                                    <div class="font-semibold">تشفير البيانات</div>
                                    <div class="text-sm text-secondary-foreground">البيانات الحساسة محمية بالتشفير</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-success">نشط</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-success-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-key text-success text-xl"></i>
                                <div>
                                    <div class="font-semibold">حماية CSRF</div>
                                    <div class="text-sm text-secondary-foreground">الحماية من هجمات CSRF مفعلة</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-success">نشط</div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-warning-light rounded">
                            <div class="flex items-center gap-3">
                                <i class="ki-filled ki-security-user text-warning text-xl"></i>
                                <div>
                                    <div class="font-semibold">المصادقة الثنائية</div>
                                    <div class="text-sm text-secondary-foreground">طبقة حماية إضافية للحسابات</div>
                                </div>
                            </div>
                            <div class="kt-badge kt-badge-warning">غير مفعل</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Logs -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">سجل الأمان</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b">
                            <div>
                                <div class="text-sm font-semibold">تسجيل دخول ناجح</div>
                                <div class="text-xs text-secondary-foreground">من عنوان IP: 192.168.1.1</div>
                            </div>
                            <div class="text-xs text-secondary-foreground">منذ 5 دقائق</div>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b">
                            <div>
                                <div class="text-sm font-semibold">تغيير كلمة المرور</div>
                                <div class="text-xs text-secondary-foreground">تم تحديث كلمة المرور بنجاح</div>
                            </div>
                            <div class="text-xs text-secondary-foreground">منذ ساعة</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
