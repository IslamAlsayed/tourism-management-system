@extends('layouts.master')

@section('title', __('main.user_profile'))

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.user_profile') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.central_hub_customization') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-primary" href="{{ route('profile.edit') }}">
                    {{ __('main.account_settings') }}
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <!-- Status Message -->
        @if (session('status'))
            <div class="p-4 mb-5 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- begin: grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6">
            <!-- User Info Card -->
            <div class="col-span-1 xl:col-span-3">
                <div class="kt-card min-w-full mb-6">
                    <div class="kt-card-body p-5 flex flex-col items-center">
                        <div class="relative mb-5">
                            <div class="size-32 rounded-full overflow-hidden">
                                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                                    alt="{{ $user->name }}" class="size-full object-cover">
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="absolute bottom-0 right-0 size-8 flex items-center justify-center bg-primary text-white rounded-full shadow-md">
                                <i class="ki-solid ki-pencil fs-6"></i>
                            </a>
                        </div>
                        <h3 class="text-xl font-medium text-mono mb-1">
                            {{ $user->name }}
                        </h3>
                        <p class="text-secondary-foreground mb-4">
                            {{ $user->email }}
                        </p>
                        <div class="flex items-center gap-2 mb-5">
                            <span class="kt-badge kt-badge-sm kt-badge-outline kt-badge-success">
                                {{ __('main.active_account') }}
                            </span>
                        </div>
                        <div class="w-full border-t border-border pt-5">
                            <ul class="flex flex-col gap-4 w-full">
                                @if ($user->phone)
                                    <li class="flex items-center gap-3">
                                        <div
                                            class="size-10 bg-muted/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="ki-solid ki-call text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="text-secondary-foreground text-sm">{{ __('main.phone') }}</span>
                                            <p class="text-foreground">{{ $user->phone }}</p>
                                        </div>
                                    </li>
                                @endif
                                <li class="flex items-start gap-3">
                                    <div
                                        class="size-10 bg-muted/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="ki-solid ki-sms text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary-foreground text-sm">{{ __('main.email') }}</span>
                                        <p class="text-foreground">{{ $user->email }}</p>
                                    </div>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div
                                        class="size-10 bg-muted/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="ki-solid ki-security-user text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary-foreground text-sm">{{ __('main.role') }}</span>
                                        <p class="text-foreground">{{ __('main.user') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- About Me Card -->
                <div class="kt-card min-w-full mb-5 lg:mb-7.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.about') }}
                        </h3>
                        <div class="kt-card-toolbar">
                            <a href="{{ route('profile.edit') }}"
                                class="kt-btn kt-btn-icon kt-btn-sm kt-btn-ghost kt-btn-primary">
                                <i class="ki-filled ki-notepad-edit"></i>
                            </a>
                        </div>
                    </div>
                    <div class="kt-card-body p-2">
                        @if ($user->bio)
                            <p class="text-secondary-foreground" style="padding: 10px">
                                {{ $user->bio }}
                            </p>
                        @else
                            <p class="text-secondary-foreground italic" style="padding: 10px">
                                {{ __('main.no_bio_provided') }} <a href="{{ route('profile.edit') }}"
                                    class="text-primary hover:underline">{{ __('main.add_your_bio') }}</a>
                                {{ __('main.to_tell_about_yourself') }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Activity Card (For future implementation) -->
                <div class="kt-card min-w-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.recent_activity') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-2">
                        <div class="relative">
                            <!-- Timeline -->
                            <div class="absolute top-0 bottom-0 left-4 border-l-2 border-dashed border-muted"></div>

                            <!-- Activity Items -->
                            <div class="space-y-8 relative">
                                <div class="flex items-start gap-4" style="padding: 10px">
                                    <div class="size-8 bg-primary/10 rounded-full flex items-center justify-center z-10">
                                        <i class="ki-solid ki-user-edit text-primary fs-6"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-foreground font-medium">{{ __('main.profile_created') }}</h4>
                                        <p class="text-secondary-foreground text-sm">{{ __('main.account_was_created') }}
                                        </p>
                                        <span
                                            class="text-xs text-muted-foreground">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                @if ($user->email_verified_at)
                                    <div class="flex items-start gap-4" style="padding: 10px">
                                        <div
                                            class="size-8 bg-success/10 rounded-full flex items-center justify-center z-10">
                                            <i class="ki-solid ki-check text-success fs-6"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-foreground font-medium">{{ __('main.email_verified') }}</h4>
                                            <p class="text-secondary-foreground text-sm">
                                                {{ __('main.email_was_verified') }}</p>
                                            <span
                                                class="text-xs text-muted-foreground">{{ $user->email_verified_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Placeholder for future activity -->
                                <div class="flex items-start gap-4 opacity-50" style="padding: 10px">
                                    <div class="size-8 bg-muted rounded-full flex items-center justify-center z-10">
                                        <i class="ki-solid ki-abstract-26 text-muted-foreground fs-6"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-foreground font-medium">{{ __('main.future_activity') }}</h4>
                                        <p class="text-secondary-foreground text-sm">
                                            {{ __('main.activity_will_appear_here') }}</p>
                                        <span class="text-xs text-muted-foreground">{{ __('main.coming_soon') }}</span>
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
    <!-- End of Container -->
    <!-- end: grid -->
    <!-- End of Container -->
@endsection
