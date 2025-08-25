@extends('layouts.metronic')

@section('title', 'Confirm Password')

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
    <script>
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
    </script>
    <!-- End of Theme Mode -->
@endpush

@section('content')
    <!--begin::Authentication - Confirm Password -->
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1" style="height: 100svh">
        <div class="kt-card max-w-[370px] w-full">
            <form action="{{ route('password.confirm') }}" class="kt-card-content flex flex-col gap-5 p-10"
                id="reset_password_change_password_form" method="post">
                @csrf
                <div class="text-center">
                    <h3 class="text-lg font-medium text-mono">
                        Reset Password
                    </h3>
                    <span class="text-sm text-secondary-foreground">
                        Enter your new password
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label text-mono">
                        New Password
                    </label>
                    <label class="kt-input" data-kt-toggle-password="true">
                        <input name="user_new_password" placeholder="Enter a new password" type="password" value="" />
                        <div class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true">
                            <span class="kt-toggle-password-active:hidden">
                                <i class="ki-filled ki-eye text-muted-foreground">
                                </i>
                            </span>
                            <span class="hidden kt-toggle-password-active:block">
                                <i class="ki-filled ki-eye-slash text-muted-foreground">
                                </i>
                            </span>
                        </div>
                    </label>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Confirm New Password
                    </label>
                    <label class="kt-input" data-kt-toggle-password="true">
                        <input name="user_confirm_password" placeholder="Re-enter a new Password" type="password"
                            value="" />
                        <div class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true">
                            <span class="kt-toggle-password-active:hidden">
                                <i class="ki-filled ki-eye text-muted-foreground">
                                </i>
                            </span>
                            <span class="hidden kt-toggle-password-active:block">
                                <i class="ki-filled ki-eye-slash text-muted-foreground">
                                </i>
                            </span>
                        </div>
                    </label>
                </div>
                <button class="kt-btn kt-btn-primary flex justify-center grow">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Confirm Password-->
@endsection

@push('scripts')
@endpush
