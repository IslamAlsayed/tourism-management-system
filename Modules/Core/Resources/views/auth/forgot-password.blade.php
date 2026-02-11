@extends('layouts.metronic')

@section('title', 'Password Recovery')

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
    <!--begin::Authentication - Forget Password -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[370px] w-full">
            <form action="{{ route('password.email') }}" class="kt-card-content flex flex-col gap-5 p-10"
                id="kt_password_reset_form" method="post">
                @csrf
                <div class="text-center">
                    <h3 class="text-lg font-medium text-mono">
                        Your Email
                    </h3>
                    <span class="text-sm text-secondary-foreground">
                        Enter your email to reset password
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Email
                    </label>
                    <input class="kt-input h-[45px]" type="text" name="email" value="" />
                </div>
                <button class="kt-btn kt-btn-primary flex justify-center grow">
                    Continue
                    <i class="ki-filled ki-black-right"></i>
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Forget Password-->
@endsection

@push('scripts')
@endpush
