@extends('layouts.master')

@section('title', __('main.user_reports'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.user_reports') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.detailed_user_statistics') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('reports.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['type' => __('main.user_reports')]) }}
                </a>
                <button class="kt-btn kt-btn-primary">
                    {{ __('main.export_report') }}
                </button>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- User Statistics -->
            <div class="grid lg:grid-cols-4 gap-5">
                <!-- Total Users -->
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($userStats['total_users']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.total_users') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Active Users --}}
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($userStats['active_users']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.active_users_label') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- New Users This Month --}}
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($userStats['new_users_this_month']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.new_users_this_month') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- New Users This Week --}}
                <div class="kt-card p-2">
                    <div class="kt-card-body">
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-3xl font-bold text-primary">
                                {{ number_format($userStats['new_users_this_week']) }}
                            </span>
                            <span class="text-sm text-secondary-foreground">
                                {{ __('main.new_users_this_week') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.recent_users') }}</h3>
                </div>
                <div class="kt-card-body">
                    <div class="table-responsive">
                        <table class="kt-table">
                            <thead>
                                <tr>
                                    <th>{{ __('main.name') }}</th>
                                    <th>{{ __('main.email') }}</th>
                                    <th>{{ __('main.status') }}</th>
                                    <th>{{ __('main.registration_date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="kt-badge kt-badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                                {{ $user->is_active ? __('main.active') : __('main.inactive') }}
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
