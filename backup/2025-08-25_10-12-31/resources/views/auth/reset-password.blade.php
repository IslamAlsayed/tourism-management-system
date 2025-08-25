@extends('layouts.metronic')

@section('title', 'Reset Password')

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
    <!--begin::Authentication - Reset Password -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[440px] w-full">
            <form action="{{ route('password.store') }}" class="kt-card-content flex flex-col gap-5 p-10"
                id="kt_new_password_form" method="post">
                @csrf
                <div class="text-center">
                    <h3 class="text-lg font-medium text-mono">
                        🔒 Reset Password
                    </h3>
                    <span class="text-sm text-secondary-foreground">
                        Create your new secure password
                        <br />For <strong>MixJo Tourism</strong> account
                    </span>
                </div>

                <!--begin::Subtitle-->
                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password?
                    <a class="text-sm kt-link" href="{{ route('login') }}">
                        Sign in
                    </a>
                </div>
                <!--end::Subtitle-->

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!--begin::Input group-->
                <div class="flex flex-col gap-1">
                    <input class="kt-input" placeholder="email@email.com" type="text" name="email"
                        value="{{ old('email', $request->email) }}" />
                    @error('email')
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="flex flex-col gap-1">
                    <input class="kt-input" placeholder="New Password" type="password" name="password" />
                    @error('password')
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="flex flex-col gap-1">
                    <input class="kt-input" placeholder="Confirm New Password" type="password"
                        name="password_confirmation" />
                    @error('password_confirmation')
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block"><span role="alert">{{ $message }}</span></div>
                        </div>
                    @enderror
                </div>
                <!--end::Input group-->

                <button class="kt-btn kt-btn-primary flex justify-center grow">
                    Reset Password
                    <i class="ki-filled ki-black-right"></i>
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Reset Password-->
@endsection

@push('scripts')
@endpush
