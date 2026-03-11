@extends('layouts.master')

@section('title', __('main.account_settings'))

@section('content')
    <!-- Hero Section -->
    <div class="kt-container-fixed mb-10">
        <div class="kt-card bg-cover bg-no-repeat rounded-xl overflow-hidden"
            style="background-image: url('{{ asset('metronic/media/misc/bg-1.png') }}'); background-position: center;">
            <div class="kt-card-body p-8 sm:p-12 flex flex-col md:flex-row items-center gap-8 bg-black/70 backdrop-blur-lg">
                <!-- Avatar -->
                <div class="relative group">
                    <div
                        class="size-32 rounded-2xl border-4 border-white/30 overflow-hidden shadow-2xl transition-transform duration-300 group-hover:scale-105">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                            alt="{{ $user->name }}" class="size-full object-cover">
                    </div>
                    <a href="{{ route('dashboard.core.profile.edit') }}"
                        class="absolute -bottom-2 -right-2 size-10 bg-primary text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-primary-emphasis transition-colors">
                        <i class="ki-filled ki-pencil fs-4"></i>
                    </a>
                </div>

                <!-- Info -->
                <div class="flex-1 text-center md:text-start text-white">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <h1 class="text-3xl font-bold tracking-tight">
                            {{ $user->name }}
                        </h1>
                        @if ($user->email_verified_at)
                            <div class="size-6 bg-success rounded-full flex items-center justify-center shadow-sm"
                                title="Verified">
                                <i class="ki-solid ki-check text-white fs-8"></i>
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-white/80 text-sm font-medium mb-6">
                        <div class="flex items-center gap-2">
                            <i class="ki-filled ki-sms text-white fs-5"></i>
                            <span class="text-white">{{ $user->email }}</span>
                        </div>
                        @if ($user->mobile)
                            <div class="flex items-center gap-2 border-l border-white/30 pl-4">
                                <i class="ki-filled ki-phone text-white fs-5"></i>
                                <span class="text-white">{{ $user->mobile }}</span>
                            </div>
                        @endif
                        @if ($user->company_name)
                            <div class="flex items-center gap-2 border-l border-white/30 pl-4">
                                <i class="ki-filled ki-bank text-white fs-5"></i>
                                <span class="text-white">{{ $user->company_name }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Shortcuts -->
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <a href="{{ route('dashboard.core.profile.edit') }}"
                            class="kt-btn kt-btn-primary bg-white text-primary hover:bg-white/90 shadow-xl border-0 px-6">
                            <i class="ki-filled ki-setting-2"></i>
                            {{ __('main.edit_profile') }}
                        </a>
                        <a href="{{ route('dashboard.core.profile.settings.security') }}"
                            class="kt-btn kt-btn-light bg-white/10 hover:bg-white/20 border-white/20 text-white backdrop-blur-md px-6">
                            <i class="ki-filled ki-shield-tick"></i>
                            {{ __('main.security') }}
                        </a>
                    </div>
                </div>

                <!-- Stats Summary -->
                <div class="hidden lg:flex flex-col gap-4 min-w-[200px]">
                    <div class="bg-white/10 dark:bg-black/20 rounded-2xl p-4 backdrop-blur-md border border-white/20 shadow-sm">
                        <div class="text-white/70 text-[11px] font-bold uppercase tracking-widest mb-2">
                            {{ __('main.account_status') }}</div>
                        <div class="flex items-center gap-2">
                            @if ($user->is_approved ?? true)
                                <span class="size-2.5 bg-success rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-pulse"></span>
                                <span class="text-white font-bold text-sm">{{ __('main.active') }}</span>
                            @else
                                <span class="size-2.5 bg-warning rounded-full shadow-[0_0_10px_rgba(245,158,11,0.5)]"></span>
                                <span class="text-white font-bold text-sm">{{ __('main.pending_approval') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="bg-white/10 dark:bg-black/20 rounded-2xl p-4 backdrop-blur-md border border-white/20 shadow-sm text-center">
                        <div class="text-white font-black text-2xl leading-none mb-1">98%</div>
                        <div class="text-white/70 text-[10px] font-bold uppercase tracking-widest">
                            {{ __('main.profile_completion') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="kt-container-fixed">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left Column: Primary Details -->
            <div class="xl:col-span-2 space-y-6 lg:space-y-8">
                <!-- Overview Card -->
                <div class="kt-card">
                    <div class="kt-card-header flex items-center justify-between border-b-border/60">
                        <h3 class="kt-card-title text-lg font-bold">
                            <i class="ki-filled ki-note-2 text-primary fs-3 me-2"></i>
                            {{ __('main.account_overview') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-0">
                        <div class="divide-y divide-border/60">
                            <div class="flex flex-col sm:flex-row sm:items-center p-6 gap-2">
                                <div class="w-full sm:w-1/3 text-secondary-foreground font-medium">
                                    {{ __('main.full_name') }}</div>
                                <div class="w-full sm:w-2/3 text-foreground font-semibold">{{ $user->name }}</div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center p-6 gap-2">
                                <div class="w-full sm:w-1/3 text-secondary-foreground font-medium">
                                    {{ __('main.company_name') }}</div>
                                <div class="w-full sm:w-2/3 text-foreground font-semibold">{{ $user->company_name ?? '—' }}
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center p-6 gap-2">
                                <div class="w-full sm:w-1/3 text-secondary-foreground font-medium">{{ __('main.country') }}
                                </div>
                                <div class="w-full sm:w-2/3 flex items-center gap-2">
                                    @if ($user->country)
                                        <img src="{{ asset('metronic/media/flags/' . strtolower($user->country->iso2) . '.svg') }}"
                                            class="size-5 rounded-sm object-cover" onerror="this.style.display='none'">
                                        <span class="text-foreground font-semibold">{{ $user->country->name }}</span>
                                    @else
                                        <span class="text-foreground font-semibold">—</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center p-6 gap-2">
                                <div class="w-full sm:w-1/3 text-secondary-foreground font-medium">
                                    {{ __('main.member_since') }}</div>
                                <div class="w-full sm:w-2/3 text-foreground font-semibold">
                                    {{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Feed -->
                <div class="kt-card">
                    <div class="kt-card-header border-b-border/60">
                        <h3 class="kt-card-title text-lg font-bold">
                            {{ __('main.recent_activity') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-6 lg:p-8">
                        <div
                            class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-0 before:w-0.5 before:bg-border/60">
                            <!-- Item -->
                            <div class="relative">
                                <div
                                    class="absolute -left-8 size-6 bg-success/20 border border-success/30 rounded-full flex items-center justify-center z-10">
                                    <div class="size-1.5 bg-success rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]">
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-sm font-bold text-foreground">{{ __('main.profile_updated') }}</div>
                                    <div class="text-xs text-secondary-foreground">{{ $user->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <!-- Item -->
                            <div class="relative">
                                <div
                                    class="absolute -left-8 size-6 bg-primary/20 border border-primary/30 rounded-full flex items-center justify-center z-10">
                                    <div class="size-1.5 bg-primary rounded-full shadow-[0_0_8px_rgba(59,130,246,0.5)]">
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <div class="text-sm font-bold text-foreground">{{ __('main.account_created') }}</div>
                                    <div class="text-xs text-secondary-foreground">{{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card-footer border-t-border/60 p-4 text-center">
                        <button
                            class="text-sm font-bold text-primary hover:underline">{{ __('main.view_all_activity') }}</button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Security & Settings Summary -->
            <div class="space-y-6 lg:space-y-8">
                <!-- Security Overview -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title text-lg font-bold">{{ __('main.security_summary') }}</h3>
                    </div>
                    <div class="kt-card-body p-6">
                        <div class="space-y-4">
                            <!-- 2FA Status -->
                            <div
                                class="flex items-center justify-between p-4 bg-muted/20 rounded-2xl border border-border/40">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 bg-white dark:bg-muted/40 rounded-xl shadow-sm flex items-center justify-center">
                                        <i class="ki-filled ki-security-user text-primary fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold">{{ __('main.two_factor') }}</div>
                                        <div class="text-xs text-secondary-foreground">Standard Security</div>
                                    </div>
                                </div>
                                <div
                                    class="kt-badge kt-badge-sm kt-badge-outline {{ $user->two_factor_confirmed_at ? 'kt-badge-success' : 'kt-badge-muted' }}">
                                    {{ $user->two_factor_confirmed_at ? __('main.enabled') : __('main.disabled') }}
                                </div>
                            </div>

                            <!-- Password Last Changed -->
                            <div
                                class="flex items-center justify-between p-4 bg-muted/20 rounded-2xl border border-border/40">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 bg-white dark:bg-muted/40 rounded-xl shadow-sm flex items-center justify-center">
                                        <i class="ki-filled ki-key text-warning fs-3"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold">{{ __('main.password') }}</div>
                                        <div class="text-xs text-secondary-foreground">Last change: 2mo ago</div>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard.core.profile.settings.security') }}"
                                    class="text-primary hover:text-primary-emphasis transition-colors">
                                    <i class="ki-filled ki-right-square fs-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Widget -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title text-lg font-bold">{{ __('main.notifications_email') }}</h3>
                    </div>
                    <div class="kt-card-body p-6">
                        <p class="text-sm text-secondary-foreground mb-4">
                            {{ __('main.notifications_email_desc') }}
                        </p>
                        <a href="{{ route('dashboard.core.profile.settings.notifications') }}"
                            class="kt-btn kt-btn-outline w-full rounded-xl">
                            {{ __('main.manage_notifications') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
