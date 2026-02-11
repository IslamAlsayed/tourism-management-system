@extends('layouts.master')

@section('title', __('main.reports_dashboard'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.reports_and_statistics') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.comprehensive_reports') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <button class="kt-btn kt-btn-primary" onclick="window.print()">
                    <i class="ki-filled ki-printer text-sm"></i>
                    {{ __('main.print_report') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Statistics Overview -->
            <div class="grid lg:grid-cols-4 gap-4 lg:gap-6">
                <!-- Total Users -->
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-bold text-primary">
                                    {{ number_format($stats['total_users']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    {{ __('main.total_users') }}
                                </span>
                            </div>
                            <div class="bg-primary-light rounded-full p-3">
                                <i class="ki-filled ki-users text-2xl text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-bold text-success">
                                    {{ number_format($stats['active_users']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    {{ __('main.total_active_users') }}
                                </span>
                            </div>
                            <div class="bg-success-light rounded-full p-3">
                                <i class="ki-filled ki-check-circle text-2xl text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Countries -->
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-bold text-info">
                                    {{ number_format($stats['total_countries']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    {{ __('main.countries') }}
                                </span>
                            </div>
                            <div class="bg-info-light rounded-full p-3">
                                <i class="ki-filled ki-geolocation text-2xl text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cities -->
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center gap-2">
                                <span class="text-3xl font-bold text-warning">
                                    {{ number_format($stats['total_cities']) }}
                                </span>
                                <span class="text-sm text-secondary-foreground">
                                    {{ __('main.cities') }}
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
            <div class="grid lg:grid-cols-3 gap-4 lg:gap-6">
                <!-- User Reports -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.user_reports') }}</h3>
                    </div>
                    <div class="kt-card-body p-2">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.detailed_user_reports') }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                <span class="text-success">{{ $stats['active_users'] }}
                                    {{ __('main.active_users_count_status') }}</span> /
                                <span class="text-danger">{{ $stats['inactive_users'] }}
                                    {{ __('main.inactive_users_count_status') }}</span>
                            </div>
                            <a href="{{ route('dashboard.core.reports.users') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                {{ __('main.view_report') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Location Reports -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.location_reports') }}</h3>
                    </div>
                    <div class="kt-card-body p-2">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.location_statistics') }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                {{ $stats['total_countries'] > 0 ? number_format($stats['total_cities'] / $stats['total_countries'], 1) : 0 }}
                                {{ __('main.cities_per_country') }}
                            </div>
                            <a href="{{ route('dashboard.core.reports.locations') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                {{ __('main.view_report') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="kt-card hover:shadow-lg transition-shadow">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.detailed_analytics') }}</h3>
                    </div>
                    <div class="kt-card-body p-2">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.advanced_analytics') }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-info">
                                {{ __('main.advanced_analytics_short') }}
                            </div>
                            <a href="{{ route('dashboard.core.reports.analytics') }}" class="kt-btn kt-btn-sm kt-btn-primary">
                                {{ __('main.view_analytics') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
