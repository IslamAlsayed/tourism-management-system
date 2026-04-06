@extends('layouts.master')

@section('title', 'أسعار صرف العملات')

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    أسعار صرف العملات
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إدارة وتحديث أسعار صرف العملات العالمية
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.currencies.index') }}" class="kt-btn kt-btn-outline">
                    العودة للعملات
                </a>
                <form method="POST" action="{{ route('dashboard.localization.currencies.rates.update') }}" class="inline">
                    @csrf
                    <button type="submit" class="kt-btn kt-btn-primary">
                        <i class="fa-duotone fa-solid fa-arrows-rotate text-sm me-2"></i>
                        تحديث الأسعار
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Exchange Rate Stats -->
            <div class="grid lg:grid-cols-4 gap-5">
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-primary-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="fa-duotone fa-solid fa-dollar-sign text-2xl text-primary"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">USD/EUR</div>
                        <div class="font-semibold text-lg">0.85</div>
                        <div class="text-xs text-success">+0.02%</div>
                    </div>
                </div>

                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-success-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="fa-duotone fa-solid fa-receipt text-2xl text-success"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">USD/SAR</div>
                        <div class="font-semibold text-lg">3.75</div>
                        <div class="text-xs text-danger">-0.01%</div>
                    </div>
                </div>

                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-warning-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="fa-duotone fa-solid fa-chart-line text-2xl text-warning"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">EUR/SAR</div>
                        <div class="font-semibold text-lg">4.41</div>
                        <div class="text-xs text-success">+0.05%</div>
                    </div>
                </div>

                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="bg-info-light rounded-full p-4 mx-auto mb-3 w-fit">
                            <i class="fa-duotone fa-solid fa-calendar text-2xl text-info"></i>
                        </div>
                        <div class="text-sm text-secondary-foreground">آخر تحديث</div>
                        <div class="font-semibold">اليوم</div>
                        <div class="text-xs text-secondary-foreground">10:30 ص</div>
                    </div>
                </div>
            </div>

            <!-- Exchange Rates Table -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">جدول أسعار الصرف</h3>
                    <div class="kt-card-toolbar">
                        <div class="flex items-center gap-2">
                            <select class="kt-select h-[45px] kt-select-sm">
                                <option value="all">جميع العملات</option>
                                <option value="major">العملات الرئيسية</option>
                                <option value="arab">العملات العربية</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="kt-card-body">
                    <div class="kt-table kt-table-border-gray-200">
                        <table class="table">
                            <thead>
                                <tr class="bg-secondary-light">
                                    <th class="p-4 text-start">العملة الأساسية</th>
                                    <th class="p-4 text-start">العملة المقابلة</th>
                                    <th class="p-4 text-center">سعر الصرف</th>
                                    <th class="p-4 text-center">التغيير</th>
                                    <th class="p-4 text-center">آخر تحديث</th>
                                    <th class="p-4 text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇺🇸</div>
                                            <div>
                                                <div class="font-semibold">USD</div>
                                                <div class="text-sm text-secondary-foreground">دولار أمريكي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇪🇺</div>
                                            <div>
                                                <div class="font-semibold">EUR</div>
                                                <div class="text-sm text-secondary-foreground">يورو</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-semibold">0.8537</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-success">+0.02%</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-sm">10:30 ص</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="kt-btn kt-btn-sm kt-btn-outline">
                                            تحديث
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇺🇸</div>
                                            <div>
                                                <div class="font-semibold">USD</div>
                                                <div class="text-sm text-secondary-foreground">دولار أمريكي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇸🇦</div>
                                            <div>
                                                <div class="font-semibold">SAR</div>
                                                <div class="text-sm text-secondary-foreground">ريال سعودي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-semibold">3.7500</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-danger">-0.01%</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-sm">10:30 ص</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="kt-btn kt-btn-sm kt-btn-outline">
                                            تحديث
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇬🇧</div>
                                            <div>
                                                <div class="font-semibold">GBP</div>
                                                <div class="text-sm text-secondary-foreground">جنيه إسترليني</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇺🇸</div>
                                            <div>
                                                <div class="font-semibold">USD</div>
                                                <div class="text-sm text-secondary-foreground">دولار أمريكي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-semibold">1.2745</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-success">+0.15%</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-sm">10:30 ص</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="kt-btn kt-btn-sm kt-btn-outline">
                                            تحديث
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇦🇪</div>
                                            <div>
                                                <div class="font-semibold">AED</div>
                                                <div class="text-sm text-secondary-foreground">درهم إماراتي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl">🇺🇸</div>
                                            <div>
                                                <div class="font-semibold">USD</div>
                                                <div class="text-sm text-secondary-foreground">دولار أمريكي</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="font-semibold">3.6725</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-muted">0.00%</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="text-sm">10:30 ص</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button class="kt-btn kt-btn-sm kt-btn-outline">
                                            تحديث
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rate Update Settings -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">إعدادات التحديث التلقائي</h3>
                </div>
                <div class="kt-card-body">
                    <form class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">تفعيل التحديث التلقائي</div>
                                <div class="text-sm text-secondary-foreground">تحديث أسعار الصرف تلقائياً من مصادر خارجية
                                </div>
                            </div>
                            <input type="checkbox" class="kt-checkbox kt-checkbox-lg" checked />
                        </div>

                        <div>
                            <label class="kt-label">تكرار التحديث</label>
                            <select class="kt-select h-[45px]" special-search>
                                <option value="15min">كل 15 دقيقة</option>
                                <option value="30min">كل 30 دقيقة</option>
                                <option value="1hour" selected>كل ساعة</option>
                                <option value="daily">يومياً</option>
                            </select>
                        </div>

                        <div>
                            <label class="kt-label">مصدر البيانات</label>
                            <select class="kt-select h-[45px]" special-search>
                                <option value="fixer">Fixer.io</option>
                                <option value="exchangerate" selected>ExchangeRate-API</option>
                                <option value="currencylayer">CurrencyLayer</option>
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
        </div>
    </div>
@endsection
