@extends('layouts.master')

@section('title', 'الإحصائيات التفصيلية')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    الإحصائيات التفصيلية
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    تحليلات متقدمة ومقاييس الأداء والنمو
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('reports.index') }}" class="kt-btn kt-btn-outline">
                    العودة للتقارير
                </a>
                <button class="kt-btn kt-btn-primary">
                    تصدير التحليلات
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Growth Metrics -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">مؤشرات النمو الشهرية</h3>
                </div>
                <div class="kt-card-body">
                    <div class="grid lg:grid-cols-3 gap-5">
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $analytics['growth_metrics']['users_growth'] >= 0 ? 'text-success' : 'text-danger' }} mb-2">
                                {{ $analytics['growth_metrics']['users_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">نمو المستخدمين</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $analytics['growth_metrics']['cities_growth'] >= 0 ? 'text-success' : 'text-danger' }} mb-2">
                                {{ $analytics['growth_metrics']['cities_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">نمو المدن</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $analytics['growth_metrics']['countries_growth'] >= 0 ? 'text-success' : 'text-danger' }} mb-2">
                                {{ $analytics['growth_metrics']['countries_growth'] }}%
                            </div>
                            <div class="text-sm text-secondary-foreground">نمو البلدان</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-5">
                <!-- User Status Distribution -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">توزيع المستخدمين حسب الحالة</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span>المستخدمون النشطون</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded">
                                        <div class="h-2 bg-success rounded" style="width: {{ ($analytics['distribution']['users_by_status']['active'] / ($analytics['distribution']['users_by_status']['active'] + $analytics['distribution']['users_by_status']['inactive'])) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ number_format($analytics['distribution']['users_by_status']['active']) }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>المستخدمون غير النشطون</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded">
                                        <div class="h-2 bg-danger rounded" style="width: {{ ($analytics['distribution']['users_by_status']['inactive'] / ($analytics['distribution']['users_by_status']['active'] + $analytics['distribution']['users_by_status']['inactive'])) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ number_format($analytics['distribution']['users_by_status']['inactive']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Countries by Cities -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">أكثر 5 بلدان من حيث المدن</h3>
                    </div>
                    <div class="kt-card-body">
                        <div class="space-y-3">
                            @foreach($analytics['distribution']['cities_by_country'] as $country)
                            <div class="flex items-center justify-between">
                                <span class="text-sm">{{ $country->name }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 h-2 bg-gray-200 rounded">
                                        <div class="h-2 bg-primary rounded" style="width: {{ ($country->cities_count / $analytics['distribution']['cities_by_country']->first()->cities_count) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-semibold">{{ number_format($country->cities_count) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
