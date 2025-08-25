@extends('layouts.master')

@section('title', 'Dashboard Dashboard')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed" id="contentContainer">
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Dashboard
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Central Hub for Personal Customization
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('user.profile') }}">
                    View Profile
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- begin: grid -->
            <div class="grid lg:grid-cols-3 gap-y-5 lg:gap-7.5 items-stretch">
                <div class="lg:col-span-1">
                    <div class="grid grid-cols-2 gap-5 lg:gap-7.5 h-full items-stretch">
                        <style>
                            .channel-stats-bg {
                                background-image: url('{{ asset('metronic/media/images/2600x1600/bg-3.png') }}');
                            }
                            .dark .channel-stats-bg {
                                background-image: url('{{ asset('metronic/media/images/2600x1600/bg-3-dark.png') }}');
                            }
                        </style>
                        <div class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                            <i class="ki-filled ki-users text-2xl text-primary mt-4 ms-5"></i>
                            <div class="flex flex-col gap-1 pb-4 px-5">
                                <span class="text-3xl font-semibold text-mono">
                                    {{ number_format($stats['users']) }}
                                </span>
                                <span class="text-sm font-normal text-secondary-foreground">
                                    إجمالي المستخدمين
                                </span>
                                <a href="{{ route('users.index') }}" class="text-xs text-blue-600 hover:underline">
                                    عرض الجميع →
                                </a>
                            </div>
                        </div>
                        <div class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                            <i class="ki-filled ki-geolocation text-2xl text-success mt-4 ms-5"></i>
                            <div class="flex flex-col gap-1 pb-4 px-5">
                                <span class="text-3xl font-semibold text-mono">
                                    {{ number_format($stats['countries']) }}
                                </span>
                                <span class="text-sm font-normal text-secondary-foreground">
                                    إجمالي البلدان
                                </span>
                                <a href="{{ route('countries.index') }}" class="text-xs text-blue-600 hover:underline">
                                    عرض الجميع →
                                </a>
                            </div>
                        </div>
                        <div class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                            <i class="ki-filled ki-map text-2xl text-info mt-4 ms-5"></i>
                            <div class="flex flex-col gap-1 pb-4 px-5">
                                <span class="text-3xl font-semibold text-mono">
                                    {{ number_format($stats['cities']) }}
                                </span>
                                <span class="text-sm font-normal text-secondary-foreground">
                                    إجمالي المدن
                                </span>
                                <a href="{{ route('cities.index') }}" class="text-xs text-blue-600 hover:underline">
                                    عرض الجميع →
                                </a>
                            </div>
                        </div>
                        <div class="kt-card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                            <i class="ki-filled ki-dollar text-2xl text-warning mt-4 ms-5"></i>
                            <div class="flex flex-col gap-1 pb-4 px-5">
                                <span class="text-3xl font-semibold text-mono">
                                    {{ number_format($stats['currencies']) }}
                                </span>
                                <span class="text-sm font-normal text-secondary-foreground">
                                    إجمالي العملات
                                </span>
                                <a href="{{ route('currencies.index') }}" class="text-xs text-blue-600 hover:underline">
                                    عرض الجميع →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <style>
                        .entry-callout-bg {
                            background-image: url('{{ asset('metronic/media/images/2600x1600/2.png') }}');
                        }
                        .dark .entry-callout-bg {
                            background-image: url('{{ asset('metronic/media/images/2600x1600/2-dark.png') }}');
                        }
                    </style>
                    <div class="kt-card h-full">
                        <div class="kt-card-content p-10 bg-[length:80%] rtl:[background-position:-70%_25%] [background-position:175%_25%] bg-no-repeat entry-callout-bg">
                            <div class="flex flex-col justify-center gap-4">
                                <div class="flex -space-x-2">
                                    <div class="flex">
                                        <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10" src="{{ asset('metronic/media/avatars/300-4.png') }}"/>
                                    </div>
                                    <div class="flex">
                                        <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10" src="{{ asset('metronic/media/avatars/300-1.png') }}"/>
                                    </div>
                                    <div class="flex">
                                        <img class="hover:z-5 relative shrink-0 rounded-full ring-1 ring-background size-10" src="{{ asset('metronic/media/avatars/300-2.png') }}"/>
                                    </div>
                                    <div class="flex">
                                        <span class="hover:z-5 relative inline-flex items-center justify-center shrink-0 rounded-full ring-1 font-semibold leading-none text-2xs size-10 text-white text-xs ring-background bg-green-500">
                                            S
                                        </span>
                                    </div>
                                </div>
                                <h2 class="text-xl font-semibold text-mono">
                                    Welcome to MixJo2025
                                    <br/>
                                    <a class="kt-link" href="#">
                                        Dashboard
                                    </a>
                                </h2>
                                <p class="text-sm font-normal text-secondary-foreground leading-5.5">
                                    Manage your application data efficiently with
                                    <br/>
                                    our comprehensive dashboard. Access all
                                    <br/>
                                    features and controls in one place.
                                </p>
                            </div>
                        </div>
                        <div class="kt-card-footer justify-center">
                            <a class="kt-link kt-link-underlined kt-link-dashed" href="{{ route('user.profile') }}">
                                Get Started
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: grid -->

            <!-- begin: grid -->
            <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
                <div class="lg:col-span-1">
                    <div class="kt-card h-full">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">
                                System Overview
                            </h3>
                            <div class="kt-menu" data-kt-menu="true">
                                <div class="kt-menu-item" data-kt-menu-item-offset="0, 10px" data-kt-menu-item-placement="bottom-start" data-kt-menu-item-toggle="dropdown" data-kt-menu-item-trigger="click">
                                    <button class="kt-menu-toggle kt-btn kt-btn-sm kt-btn-icon kt-btn-ghost">
                                        <i class="ki-filled ki-dots-vertical text-lg"></i>
                                    </button>
                                    <div class="kt-menu-dropdown kt-menu-default w-full max-w-[200px]" data-kt-menu-dismiss="true">
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('users.index') }}">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-users"></i>
                                                </span>
                                                <span class="kt-menu-title">Users</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('countries.index') }}">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-geolocation"></i>
                                                </span>
                                                <span class="kt-menu-title">Countries</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('cities.index') }}">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-map"></i>
                                                </span>
                                                <span class="kt-menu-title">Cities</span>
                                            </a>
                                        </div>
                                        <div class="kt-menu-item">
                                            <a class="kt-menu-link" href="{{ route('currencies.index') }}">
                                                <span class="kt-menu-icon">
                                                    <i class="ki-filled ki-dollar"></i>
                                                </span>
                                                <span class="kt-menu-title">Currencies</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-card-content flex flex-col gap-4 p-5 lg:p-7.5 lg:pt-4">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-sm font-normal text-secondary-foreground">
                                    Total Records
                                </span>
                                <div class="flex items-center gap-2.5">
                                    <span class="text-3xl font-semibold text-mono">
                                        {{ array_sum($stats) }}
                                    </span>
                                    <span class="kt-badge kt-badge-outline kt-badge-success kt-badge-sm">
                                        Active
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mb-1.5">
                                <div class="bg-green-500 h-2 w-full max-w-[40%] rounded-xs"></div>
                                <div class="bg-primary h-2 w-full max-w-[30%] rounded-xs"></div>
                                <div class="bg-violet-500 h-2 w-full max-w-[20%] rounded-xs"></div>
                                <div class="bg-orange-500 h-2 w-full max-w-[10%] rounded-xs"></div>
                            </div>
                            <div class="flex items-center flex-wrap gap-4 mb-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="size-2 rounded-full kt-badge-success"></span>
                                    <span class="text-sm font-normal text-foreground">Users</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="size-2 rounded-full kt-badge-primary"></span>
                                    <span class="text-sm font-normal text-foreground">Countries</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="size-2 rounded-full kt-badge-info"></span>
                                    <span class="text-sm font-normal text-foreground">Cities</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="size-2 rounded-full kt-badge-warning"></span>
                                    <span class="text-sm font-normal text-foreground">Currencies</span>
                                </div>
                            </div>
                            <div class="border-b border-input"></div>
                            <div class="grid gap-3">
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ki-filled ki-users text-base text-muted-foreground"></i>
                                        <span class="text-sm font-normal text-mono">Users</span>
                                    </div>
                                    <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                        <span class="lg:text-right">{{ $stats['users'] }}</span>
                                        <a href="{{ route('users.index') }}" class="kt-btn kt-btn-sm kt-btn-outline">View</a>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ki-filled ki-geolocation text-base text-muted-foreground"></i>
                                        <span class="text-sm font-normal text-mono">Countries</span>
                                    </div>
                                    <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                        <span class="lg:text-right">{{ $stats['countries'] }}</span>
                                        <a href="{{ route('countries.index') }}" class="kt-btn kt-btn-sm kt-btn-outline">View</a>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ki-filled ki-map text-base text-muted-foreground"></i>
                                        <span class="text-sm font-normal text-mono">Cities</span>
                                    </div>
                                    <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                        <span class="lg:text-right">{{ $stats['cities'] }}</span>
                                        <a href="{{ route('cities.index') }}" class="kt-btn kt-btn-sm kt-btn-outline">View</a>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ki-filled ki-dollar text-base text-muted-foreground"></i>
                                        <span class="text-sm font-normal text-mono">Currencies</span>
                                    </div>
                                    <div class="flex items-center text-sm font-medium text-foreground gap-6">
                                        <span class="lg:text-right">{{ $stats['currencies'] }}</span>
                                        <a href="{{ route('currencies.index') }}" class="kt-btn kt-btn-sm kt-btn-outline">View</a>
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
                                Quick Actions
                            </h3>
                            <div class="flex gap-5">
                                <label class="flex items-center gap-2">
                                    <input class="kt-switch" name="check" type="checkbox" value="1"/>
                                    <span class="kt-label">Auto refresh</span>
                                </label>
                            </div>
                        </div>
                        <div class="kt-card-content p-5 lg:p-7.5">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                                <a href="{{ route('users.index') }}" class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="flex items-center justify-center size-12 rounded-full bg-success/10">
                                            <i class="ki-filled ki-users text-xl text-success"></i>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-semibold text-mono">Manage Users</div>
                                            <div class="text-xs text-secondary-foreground">{{ $stats['users'] }} total</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('countries.index') }}" class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="flex items-center justify-center size-12 rounded-full bg-primary/10">
                                            <i class="ki-filled ki-geolocation text-xl text-primary"></i>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-semibold text-mono">Countries</div>
                                            <div class="text-xs text-secondary-foreground">{{ $stats['countries'] }} total</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('cities.index') }}" class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="flex items-center justify-center size-12 rounded-full bg-info/10">
                                            <i class="ki-filled ki-map text-xl text-info"></i>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-semibold text-mono">Cities</div>
                                            <div class="text-xs text-secondary-foreground">{{ $stats['cities'] }} total</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('currencies.index') }}" class="kt-card kt-card-outline hover:bg-accent/60 p-5">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="flex items-center justify-center size-12 rounded-full bg-warning/10">
                                            <i class="ki-filled ki-dollar text-xl text-warning"></i>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-sm font-semibold text-mono">Currencies</div>
                                            <div class="text-xs text-secondary-foreground">{{ $stats['currencies'] }} total</div>
                                        </div>
                                    </div>
                                </a>
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
