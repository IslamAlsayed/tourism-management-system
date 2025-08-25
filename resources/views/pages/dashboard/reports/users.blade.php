@extends('layouts.master')

@section('title', 'تقارير المستخدمين')

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    تقارير المستخدمين
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    إحصائيات مفصلة عن المستخدمين والنشاط
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
            <!-- User Statistics -->
            <div class="grid lg:grid-cols-4 gap-5">
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-primary mb-2">{{ number_format($userStats['total_users']) }}</div>
                        <div class="text-sm text-secondary-foreground">إجمالي المستخدمين</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-success mb-2">{{ number_format($userStats['active_users']) }}</div>
                        <div class="text-sm text-secondary-foreground">المستخدمون النشطون</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-warning mb-2">{{ number_format($userStats['new_users_this_month']) }}</div>
                        <div class="text-sm text-secondary-foreground">مستخدمون جدد هذا الشهر</div>
                    </div>
                </div>
                <div class="kt-card">
                    <div class="kt-card-body text-center">
                        <div class="text-3xl font-bold text-info mb-2">{{ number_format($userStats['new_users_this_week']) }}</div>
                        <div class="text-sm text-secondary-foreground">مستخدمون جدد هذا الأسبوع</div>
                    </div>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">المستخدمون الجدد</h3>
                </div>
                <div class="kt-card-body">
                    <div class="table-responsive">
                        <table class="kt-table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="kt-badge kt-badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                            {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
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
