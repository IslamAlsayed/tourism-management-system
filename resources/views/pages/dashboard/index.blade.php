@extends('layouts.master')

@section('title', __('main.dashboard'))

@push('styles')
<style>
.channel-stats-bg {
    background-image: url('{{ asset('metronic/media/images/2600x1600/bg-3.png') }}');
}

.dark .channel-stats-bg {
    background-image: url('{{ asset('metronic/media/images/2600x1600/bg-3-dark.png') }}');
}

.entry-callout-bg {
    background-image: url('{{ asset('metronic/media/images/2600x1600/2.png') }}');
}

.dark .entry-callout-bg {
    background-image: url('{{ asset('metronic/media/images/2600x1600/2-dark.png') }}');
}
</style>
@endpush

@section('content')
<!-- Container -->
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                {{ __('main.dashboard') }}
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                {{ __('main.dashboard_subtitle') }}
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="kt-btn kt-btn-primary" href="{{ route('user.profile') }}">
                {{ __('main.view_profile') }}
            </a>
        </div>
    </div>
</div>
<!-- End of Container -->

<!-- Container -->
<div class="kt-container-fixed">
    <div class="grid gap-4 lg:gap-6">
        <!-- begin: grid -->
        <div class="grid lg:grid-cols-3 gap-y-5 lg:gap-7.5 items-stretch">
            <div class="lg:col-span-1">
                <div class="grid grid-cols-2 gap-4 lg:gap-6 h-full items-stretch">
                    <div
                        class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="flex flex-col gap-1 p-4">
                            <span class="font-semibold text-mono">
                                <i class="ki-filled ki-users text-2xl text-primary"></i>
                                <span class="text-2xl">{{ number_format($stats['users']) }}</span>
                            </span>
                            <span class="text-sm mb-2 font-normal text-secondary-foreground">
                                {{ __('main.total_users') }}
                            </span>
                            <a href="{{ route('users.index') }}" class="text-xs text-blue-600 hover:underline">
                                {{ __('main.view_all') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                            </a>
                        </div>
                    </div>
                    <div
                        class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="flex flex-col gap-1 p-4">
                            <span class="font-semibold text-mono">
                                <i class="ki-filled ki-geolocation text-2xl text-green-500"></i>
                                <span class="text-2xl">{{ number_format($stats['countries']) }}</span>
                            </span>
                            <span class="text-sm mb-2 font-normal text-secondary-foreground">
                                {{ __('main.total_countries') }}
                            </span>
                            <a href="{{ route('countries.index') }}" class="text-xs text-blue-600 hover:underline">
                                {{ __('main.view_all') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                            </a>
                        </div>
                    </div>
                    <div
                        class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="flex flex-col gap-1 p-4">
                            <span class="font-semibold text-mono">
                                <i class="ki-filled ki-map text-2xl text-blue-500"></i>
                                <span class="text-2xl">{{ number_format($stats['cities']) }}</span>
                            </span>
                            <span class="text-sm mb-2 font-normal text-secondary-foreground">
                                {{ __('main.total_cities') }}
                            </span>
                            <a href="{{ route('cities.index') }}" class="text-xs text-blue-600 hover:underline">
                                {{ __('main.view_all') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                            </a>
                        </div>
                    </div>
                    <div
                        class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="flex flex-col gap-1 p-4">
                            <span class="font-semibold text-mono">
                                <i class="ki-filled ki-dollar text-2xl text-yellow-500"></i>
                                <span class="text-2xl">{{ number_format($stats['currencies']) }}</span>
                            </span>
                            <span class="text-sm mb-2 font-normal text-secondary-foreground">
                                {{ __('main.total_currencies') }}
                            </span>
                            <a href="{{ route('currencies.index') }}" class="text-xs text-blue-600 hover:underline">
                                {{ __('main.view_all') }}
                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="kt-card h-full">
                    <div
                        class="kt-card-content p-10 bg-[length:80%] rtl:[background-position:-70%_25%] [background-position:175%_25%] bg-no-repeat entry-callout-bg">
                        <div class="flex flex-col justify-center gap-4">
                            <div class="flex -space-x-2">
                                <div class="flex">
                                    <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10"
                                        src="{{ asset('metronic/media/avatars/300-4.png') }}" />
                                </div>
                                <div class="flex">
                                    <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10"
                                        src="{{ asset('metronic/media/avatars/300-1.png') }}" />
                                </div>
                                <div class="flex">
                                    <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10"
                                        src="{{ asset('metronic/media/avatars/300-2.png') }}" />
                                </div>
                                <div class="flex">
                                    <span
                                        class="hover:z-5 relative inline-flex items-center justify-center shrink-0 rounded-full ring-1 font-semibold leading-none text-2xs size-10 text-white text-xs ring-background bg-green-500">
                                        S
                                    </span>
                                </div>
                            </div>
                            <h2 class="text-xl font-semibold text-mono">
                                {{ __('main.welcome_message') }}
                                <br />
                                <a class="kt-link" href="#">
                                    {{ __('main.dashboard') }}
                                </a>
                            </h2>
                            <p class="text-sm font-normal text-secondary-foreground leading-5.5 max-w-[60%]">
                                {{ __('main.dashboard_welcome_description') }}
                            </p>
                        </div>
                    </div>
                    <div class="kt-card-footer justify-center">
                        <a class="kt-link kt-link-underlined kt-link-dashed" href="{{ route('user.profile') }}">
                            {{ __('main.get_started') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: grid -->

        <!-- begin: grid -->
        <div class="grid lg:grid-cols-3 gap-4 lg:gap-6 items-stretch">
            <div class="lg:col-span-1">
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.system_overview') }}
                        </h3>
                        <div class="kt-menu" data-kt-menu="true">
                            <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px"
                                data-kt-menu-item-placement="bottom-start" data-kt-menu-item-toggle="dropdown"
                                data-kt-menu-item-trigger="click">
                                <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                                    <i class="ki-filled ki-dots-vertical text-lg"></i>
                                </button>
                                <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]"
                                    data-kt-menu-dismiss="true">
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="{{ route('users.index') }}">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-users"></i>
                                            </span>
                                            <span class="kt-menu-title">{{ __('main.users') }}</span>
                                        </a>
                                    </div>
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="{{ route('countries.index') }}">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-geolocation"></i>
                                            </span>
                                            <span class="kt-menu-title">{{ __('main.countries') }}</span>
                                        </a>
                                    </div>
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="{{ route('cities.index') }}">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-map"></i>
                                            </span>
                                            <span class="kt-menu-title">{{ __('main.cities') }}</span>
                                        </a>
                                    </div>
                                    <div class="kt-menu-item">
                                        <a class="kt-menu-link" href="{{ route('currencies.index') }}">
                                            <span class="kt-menu-icon">
                                                <i class="ki-filled ki-dollar"></i>
                                            </span>
                                            <span class="kt-menu-title">{{ __('main.all_currencies') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-card-content flex flex-col gap-4 p-5 lg:p-7.5 lg:pt-4">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-sm font-normal text-secondary-foreground">
                                {{ __('main.total_records') }}
                            </span>
                            <div class="flex items-center gap-2.5">
                                <span class="text-3xl font-semibold text-mono">
                                    {{ array_sum($stats) }}
                                </span>
                                <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">
                                    {{ __('main.active') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mb-1.5">
                            <div class="kt-badge-success h-2 w-full max-w-[40%] rounded-xs"></div>
                            <div class="kt-badge-primary h-2 w-full max-w-[30%] rounded-xs"></div>
                            <div class="kt-badge-info h-2 w-full max-w-[20%] rounded-xs"></div>
                            <div class="kt-badge-warning h-2 w-full max-w-[10%] rounded-xs"></div>
                        </div>
                        <div class="flex items-center flex-wrap gap-4 mb-1">
                            <div class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full kt-badge-success"></span>
                                <span class="text-sm font-normal text-foreground">{{ __('main.users') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full kt-badge-primary"></span>
                                <span class="text-sm font-normal text-foreground">{{ __('main.countries') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full kt-badge-info"></span>
                                <span class="text-sm font-normal text-foreground">{{ __('main.cities') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="size-2 rounded-full kt-badge-warning"></span>
                                <span class="text-sm font-normal text-foreground">{{ __('main.currencies') }}</span>
                            </div>
                        </div>
                        <div class="border-b border-input"></div>
                        <div class="grid gap-3">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-users text-base text-muted-foreground"></i>
                                    <span class="text-sm font-normal text-mono">{{ __('main.users') }}</span>
                                </div>
                                <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                    <span class="lg:text-right">{{ $stats['users'] }}</span>
                                    <a href="{{ route('users.index') }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">{{ __('main.view') }}</a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-geolocation text-base text-muted-foreground"></i>
                                    <span class="text-sm font-normal text-mono">{{ __('main.countries') }}</span>
                                </div>
                                <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                    <span class="lg:text-right">{{ $stats['countries'] }}</span>
                                    <a href="{{ route('countries.index') }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">{{ __('main.view') }}</a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-map text-base text-muted-foreground"></i>
                                    <span class="text-sm font-normal text-mono">{{ __('main.cities') }}</span>
                                </div>
                                <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                    <span class="lg:text-right">{{ $stats['cities'] }}</span>
                                    <a href="{{ route('cities.index') }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">{{ __('main.view') }}</a>
                                </div>
                            </div>
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <div class="flex items-center gap-1.5">
                                    <i class="ki-filled ki-dollar text-base text-muted-foreground"></i>
                                    <span class="text-sm font-normal text-mono">{{ __('main.currencies') }}</span>
                                </div>
                                <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                    <span class="lg:text-right">{{ $stats['currencies'] }}</span>
                                    <a href="{{ route('currencies.index') }}"
                                        class="kt-btn kt-btn-sm kt-btn-outline">{{ __('main.view') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="kt-card h-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.quick_actions') }}
                        </h3>
                        <div class="flex gap-5 p-2 rounded-xs bg-yellow-100">
                            <label class="flex items-center gap-2 disabled">
                                <input class="kt-switch" name="check" type="checkbox" value="1" />
                                <span class="kt-label">{{ __('main.auto_refresh') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-card-content p-5 lg:p-7.5 content-center">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                            <div class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex items-center justify-center size-12 rounded-full bg-success/10">
                                        <i class="ki-filled ki-users text-xl text-success"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm mb-2 font-semibold text-mono text-primary">
                                            <a href="{{ route('users.index') }}">{{ __('main.manage_users') }}</a>
                                        </div>
                                        <div class="text-xs text-secondary-foreground">{{ $stats['users'] }}
                                            {{ __('main.total') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex items-center justify-center size-12 rounded-full bg-primary/10">
                                        <i class="ki-filled ki-geolocation text-xl text-primary"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm mb-2 font-semibold text-mono text-primary">
                                            <a href="{{ route('countries.index') }}">{{ __('main.countries') }}</a>
                                        </div>
                                        <div class="text-xs text-secondary-foreground">{{ $stats['countries'] }}
                                            {{ __('main.total') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex items-center justify-center size-12 rounded-full bg-primary/10">
                                        <i class="ki-filled ki-map text-xl text-info"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm mb-2 font-semibold text-mono text-primary">
                                            <a href="{{ route('cities.index') }}">{{ __('main.cities') }}</a>
                                        </div>
                                        <div class="text-xs text-secondary-foreground">{{ $stats['cities'] }}
                                            {{ __('main.total') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex items-center justify-center size-12 rounded-full bg-yellow/10">
                                        <i class="ki-filled ki-dollar text-xl text-warning"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm mb-2 font-semibold text-mono text-primary">
                                            <a href="{{ route('currencies.index') }}">{{ __('main.currencies') }}</a>
                                        </div>
                                        <div class="text-xs text-secondary-foreground">{{ $stats['currencies'] }}
                                            {{ __('main.total') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: grid -->
    </div>
</div>
<!-- End of Container -->
@endsection