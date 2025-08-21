@extends('layouts.metronic')

@section('title', 'Login')

@push('styles')
    <style>
        .page-bg {
            background-image: url('metronic/media/images/2600x1200/bg-10.png');
        }

        .dark .page-bg {
            background-image: url('metronic/media/images/2600x1200/bg-10-dark.png');
        }
    </style>
@endpush

@push('scripts')
    <!-- Google tag (gtag.js) -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-52YZ3XGZJ6');
    </script>

    <!-- Theme Mode -->
    {{-- <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                    'dark' :
                    'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script> --}}
    <!-- End of Theme Mode -->
@endpush

@section('content')
    <!--begin::Authentication - Sign-in -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[370px] w-full">
            <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-10" id="kt_sign_in_form"
                method="post">
                @csrf
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        Sign in
                    </h3>
                    <div class="flex items-center justify-center font-medium">
                        <span class="text-sm text-secondary-foreground me-1.5">
                            Need an account?
                        </span>
                        <a class="text-sm kt-link" href="{{ route('register') }}">
                            Register
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="" class="size-3.5 shrink-0"
                            src="{{ asset('metronic/media/brand-logos/google.svg') }}" />
                        Use Google
                    </a>
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="" class="size-3.5 shrink-0 dark:hidden"
                            src="{{ asset('metronic/media/brand-logos/apple-black.svg') }}" />
                        <img alt="" class="size-3.5 shrink-0 light:hidden"
                            src="{{ asset('metronic/media/brand-logos/apple-white.svg') }}" />
                        Use Apple
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <span class="border-t border-border w-full">
                    </span>
                    <span class="text-xs text-muted-foreground font-medium uppercase">
                        Or
                    </span>
                    <span class="border-t border-border w-full">
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Email
                    </label>
                    <input class="kt-input" placeholder="email@email.com" type="email" name="email" />
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label class="kt-form-label font-normal text-mono">
                            Password
                        </label>
                        <a class="text-sm kt-link shrink-0" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    </div>
                    <div class="kt-input" data-kt-toggle-password="true">
                        <input name="password" placeholder="Enter Password" type="password" />
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true" type="button">
                            <span class="kt-toggle-password-active:hidden">
                                <i class="ki-filled ki-eye text-muted-foreground">
                                </i>
                            </span>
                            <span class="hidden kt-toggle-password-active:block">
                                <i class="ki-filled ki-eye-slash text-muted-foreground">
                                </i>
                            </span>
                        </button>
                    </div>
                </div>
                <label class="kt-label">
                    <input class="kt-checkbox kt-checkbox-sm" name="check" type="checkbox" value="1" />
                    <span class="kt-checkbox-label">
                        Remember me
                    </span>
                </label>
                <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                    Sign In
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
@endpush
