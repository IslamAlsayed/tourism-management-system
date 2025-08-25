@extends('layouts.master')

@section('title', 'تقارير المواقع')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    تقارير المواقع
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إحصائيات البلدان والمدن والتوزيع الجغرافي
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('reports.index') }}" class="kt-btn kt-btn-outline">
                    العودة للتقارير
                </a>
                <button class="kt-btn kt-btn-primary">
                    تصدير التقرير
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Location Statistics -->
            <div class="grid lg:grid-cols-4 gap-5">
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-primary mb-2">{{ number_format($locationStats['total_countries']) }}</div>
                        <div class="text-sm text-secondary-foreground">إجمالي البلدان</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-success mb-2">{{ number_format($locationStats['total_cities']) }}</div>
                        <div class="text-sm text-secondary-foreground">إجمالي المدن</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-warning mb-2">{{ $locationStats['avg_cities_per_country'] }}</div>
                        <div class="text-sm text-secondary-foreground">متوسط المدن لكل بلد</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-info mb-2">{{ number_format($locationStats['countries_with_cities']) }}</div>
                        <div class="text-sm text-secondary-foreground">بلدان تحتوي على مدن</div>
                    </div>
                </div>
            </div>

            <!-- Top Countries Table -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">أكثر البلدان من حيث عدد المدن</h3>
                </div>
                <div class="kt-card-body">
                    <div class="table-responsive">
                        <table class="kt-table">
                            <thead>
                                <tr>
                                    <th>الترتيب</th>
                                    <th>اسم البلد</th>
                                    <th>عدد المدن</th>
                                    <th>النسبة المئوية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCountries as $index => $country)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $country->name }}</td>
                                    <td>{{ number_format($country->cities_count) }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="progress-bar bg-primary" style="width: {{ ($country->cities_count / $locationStats['total_cities']) * 100 }}%"></div>
                                            <span>{{ number_format(($country->cities_count / $locationStats['total_cities']) * 100, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
