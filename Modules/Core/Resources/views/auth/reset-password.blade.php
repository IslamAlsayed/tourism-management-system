@extends('layouts.auth')

@section('title', 'Reset Password')

@push('styles')
    <style>
        .branded-bg {
            background-image: url('{{ asset('metronic/media/images/2600x1600/bg-2.png') }}');
        }

        .dark .branded-bg {
            background-image: url('{{ asset('metronic/media/images/2600x1600/bg-2-dark.png') }}');
        }

        @media (min-width: 1024px) {
            .auth-grid {
                display: grid !important;
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }

            .auth-form-col {
                grid-column: span 7 / span 7 !important;
            }

            .auth-image-col {
                grid-column: span 5 / span 5 !important;
            }
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
@endpush

@section('content')
    <div class="auth-grid grow min-h-[100svh]">

        {{-- Left: Form (60% on desktop) --}}
        <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1 auth-form-col">
            <div class="kt-card max-w-[370px] w-full border-0 shadow-none bg-transparent">
                <div class="flex justify-center mb-10">
                    <a href="{{ url('/') }}">
                        @php
                            $settings = \Modules\Core\Entities\Setting::first();
                            $aWidth = optional($settings)->auth_logo_width ?? '150px';
                            if (is_numeric($aWidth)) { $aWidth .= 'px'; }
                            $aHeight = optional($settings)->auth_logo_height ?? 'auto';
                            if (is_numeric($aHeight)) { $aHeight .= 'px'; }
                        @endphp
                        <img class="dark:hidden max-w-full transition-all duration-300 object-contain"
                            src="{{ optional($settings)->app_dark_photo ? asset('storage/' . $settings->app_dark_photo) : asset('metronic/media/app/mixjo-default-logo-dark.svg') }}"
                            style="width: {{ $aWidth }} !important; height: {{ $aHeight }} !important; min-height: {{ $aHeight }} !important;" />
                        <img class="hidden dark:block max-w-full transition-all duration-300 object-contain"
                            src="{{ optional($settings)->app_light_photo ? asset('storage/' . $settings->app_light_photo) : asset('metronic/media/app/mixjo-default-logo.svg') }}"
                            style="width: {{ $aWidth }} !important; height: {{ $aHeight }} !important; min-height: {{ $aHeight }} !important;" />
                    </a>
                </div>
                <form action="{{ route('password.store') }}" class="kt-card-content flex flex-col gap-5 p-10"
                    id="reset_password_change_password_form" method="post">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="text-center">
                        <h3 class="text-lg font-medium text-mono">
                            Reset Password
                        </h3>
                        <span class="text-sm text-secondary-foreground">
                            Enter your new password
                        </span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">
                            Email
                        </label>
                        <input class="kt-input" placeholder="email@email.com" type="email" name="email"
                            value="{{ old('email', $request->email) }}" required autofocus />
                        @error('email')
                            <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label text-mono">
                            New Password
                        </label>
                        <label class="kt-input" data-kt-toggle-password="true">
                            <input name="password" placeholder="Enter a new password" type="password" required />
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
                        @error('password')
                            <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">
                            Confirm New Password
                        </label>
                        <label class="kt-input" data-kt-toggle-password="true">
                            <input name="password_confirmation" placeholder="Re-enter a new Password" type="password"
                                required />
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
                    <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                        Submit
                    </button>
                    <div class="flex justify-center mt-2">
                        <a href="{{ route('login') }}" class="text-sm link">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
        {{-- Right: Branded background image (40% on desktop) --}}
        <div class="hidden lg:block lg:order-2 auth-image-col bg-center xl:bg-cover bg-no-repeat branded-bg">
            <div class="flex flex-col p-8 lg:p-16 gap-6">
                {{-- Logo removed from here to be exclusively in the form section as requested --}}
                <div class="flex flex-col gap-3">
                    <h3 class="text-2xl font-semibold text-mono">
                        Secure Access Portal
                    </h3>
                    <div class="text-base font-medium text-secondary-foreground">
                        A robust authentication gateway ensuring
                        <br />
                        secure
                        <span class="text-mono font-semibold">
                            efficient user access
                        </span>
                        to the Metronic
                        <br />
                        Dashboard interface.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Authentication - Reset Password-->
@endsection

@push('scripts')
@endpush
