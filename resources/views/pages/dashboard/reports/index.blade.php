@extends('layouts.master')

@section('title', 'لوحة التقارير')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    لوحة التقارير والإحصائيات
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    تقارير شاملة عن أداء النظام والبيانات
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <button class="kt-btn kt-btn-primary">
                    <i class="ki-filled ki-printer text-sm"></i>
                    طباعة التقرير
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Statistics Overview -->
            <div class="grid lg:grid-cols-4 gap-5 lg:gap-7.5">
                <!-- Total Users -->
                <div class="kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex flex-col gap-2">
                                <span class="text-3xl font-bold text-primary">
                                    {{ number_format($stats['total_users']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    إجمالي المستخدمين
                                </span>
                            </div>
                            <div class="bg-primary-light rounded-full p-3">
                                <i class="ki-filled ki-users text-2xl text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex flex-col gap-2">
                                <span class="text-3xl font-bold text-success">
                                    {{ number_format($stats['active_users']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    المستخدمون النشطون
                                </span>
                            </div>
                            <div class="bg-success-light rounded-full p-3">
                                <i class="ki-filled ki-check-circle text-2xl text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Countries -->
                <div class="kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex flex-col gap-2">
                                <span class="text-3xl font-bold text-info">
                                    {{ number_format($stats['total_countries']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    البلدان
                                </span>
                            </div>
                            <div class="bg-info-light rounded-full p-3">
                                <i class="ki-filled ki-geolocation text-2xl text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cities -->
                <div class="kt-card">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex flex-col gap-2">
                                <span class="text-3xl font-bold text-warning">
                                    {{ number_format($stats['total_cities']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    المدن
                                </span>
                            </div>
                            <div class="bg-warning-light rounded-full p-3">
                                <i class="ki-filled ki-home-2 text-2xl text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Report Links -->
            <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5">
                <!-- User Reports -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">تقارير المستخدمين</h3>
                    </div>
                    <div class="kt-card-body">
                        <p class="text-sm text-secondary-foreground mb-4">
                            تقارير مفصلة عن المستخدمين والنشاط والنمو
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                <span class="text-success">{{ $stats['active_users'] }} نشط</span> /
                                <span class="text-danger">{{ $stats['inactive_users'] }} غير نشط</span>
                            </div>
                            <a href="{{ route('reports.users') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                عرض التقرير
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Location Reports -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">تقارير المواقع</h3>
                    </div>
                    <div class="kt-card-body">
                        <p class="text-sm text-secondary-foreground mb-4">
                            إحصائيات البلدان والمدن والتوزيع الجغرافي
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                {{ number_format($stats['total_cities'] / $stats['total_countries'], 1) }} مدينة/بلد
                            </div>
                            <a href="{{ route('reports.locations') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                عرض التقرير
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">الإحصائيات التفصيلية</h3>
                    </div>
                    <div class="kt-card-body">
                        <p class="text-sm text-secondary-foreground mb-4">
                            تحليلات متقدمة ومقاييس الأداء والنمو
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-info">
                                تحليلات متقدمة
                            </div>
                            <a href="{{ route('reports.analytics') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                عرض التحليلات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
