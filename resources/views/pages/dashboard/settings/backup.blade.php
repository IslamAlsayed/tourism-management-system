@extends('layouts.master')

@section('title', 'إدارة النسخ الاحتياطي')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    إدارة النسخ الاحتياطي
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إدارة النسخ الاحتياطية واستعادة البيانات
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('settings.index') }}" class="kt-btn kt-btn-outline">
                    العودة للإعدادات
                </a>
                <form method="POST" action="{{ route('settings.backup.create') }}" class="inline">
                    @csrf
                    <button type="submit" class="kt-btn kt-btn-primary">
                        <i class="ki-filled ki-cloud-download text-sm me-2"></i>
                        إنشاء نسخة احتياطية
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Backup Status -->
            <div class="grid lg:grid-cols-3 gap-5">
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-primary-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="ki-filled ki-calendar text-2xl text-primary"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">آخر نسخة احتياطية</div>
                        <div class="font-semibold">{{ $backupInfo['last_backup'] }}</div>
                    </div>
                </div>

                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-success-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="ki-filled ki-size text-2xl text-success"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">حجم النسخ الاحتياطية</div>
                        <div class="font-semibold">{{ $backupInfo['backup_size'] }}</div>
                    </div>
                </div>

                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-info-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="ki-filled ki-setting-2 text-2xl text-info"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">النسخ التلقائي</div>
                        <div class="font-semibold">{{ $backupInfo['auto_backup_enabled'] ? 'مفعل' : 'غير مفعل' }}</div>
                    </div>
                </div>
            </div>

            <!-- Backup Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">إعدادات النسخ الاحتياطي</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">تفعيل النسخ التلقائي</div>
                                <div class="text-sm text-secondary-foreground">إنشاء نسخ احتياطية تلقائية بشكل دوري</div>
                            </div>
                            <input type="checkbox" class="kt-checkbox kt-checkbox-lg" {{ $backupInfo['auto_backup_enabled'] ? 'checked' : '' }} />
                        </div>

                        <div>
                            <label class="kt-label">تكرار النسخ التلقائي</label>
                            <select class="kt-select">
                                <option value="daily" {{ $backupInfo['backup_frequency'] == 'daily' ? 'selected' : '' }}>يومياً</option>
                                <option value="weekly" {{ $backupInfo['backup_frequency'] == 'weekly' ? 'selected' : '' }}>أسبوعياً</option>
                                <option value="monthly" {{ $backupInfo['backup_frequency'] == 'monthly' ? 'selected' : '' }}>شهرياً</option>
                            </select>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                حفظ الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Backup History -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">سجل النسخ الاحتياطية</h3>
                </div>
                <div class="kt-card-body">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 border rounded">
                            <div class="flex items-center gap-3">
                                <div class="bg-success-light rounded-full p-2">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">نسخة احتياطية كاملة</div>
                                    <div class="text-sm text-secondary-foreground">25 أغسطس 2025 - 10:12 ص</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">206 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    تحميل
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 border rounded">
                            <div class="flex items-center gap-3">
                                <div class="bg-success-light rounded-full p-2">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">نسخة احتياطية تلقائية</div>
                                    <div class="text-sm text-secondary-foreground">24 أغسطس 2025 - 03:00 ص</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">198 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    تحميل
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 border rounded">
                            <div class="flex items-center gap-3">
                                <div class="bg-success-light rounded-full p-2">
                                    <i class="ki-filled ki-check-circle text-success"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">نسخة احتياطية يدوية</div>
                                    <div class="text-sm text-secondary-foreground">23 أغسطس 2025 - 14:30 م</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-secondary-foreground">195 KB</span>
                                <button class="kt-btn kt-btn-sm kt-btn-outline">
                                    تحميل
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restore Options -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">استعادة البيانات</h3>
                </div>
                <div class="kt-card-body">
                    <div class="bg-warning-light p-4 rounded mb-4">
                        <div class="flex items-center gap-3">
                            <i class="ki-filled ki-information text-warning text-xl"></i>
                            <div>
                                <div class="font-semibold">تحذير هام</div>
                                <div class="text-sm">استعادة البيانات ستحل محل البيانات الحالية. تأكد من إنشاء نسخة احتياطية قبل المتابعة.</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="kt-label">اختيار ملف النسخة الاحتياطية</label>
                        <input type="file" class="kt-input" accept=".zip,.sql" />
                        <div class="text-xs text-secondary-foreground mt-1">يدعم ملفات .zip و .sql فقط</div>
                    </div>

                    <div class="pt-4">
                        <button class="kt-btn kt-btn-danger">
                            <i class="ki-filled ki-arrows-circle text-sm me-2"></i>
                            استعادة البيانات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
