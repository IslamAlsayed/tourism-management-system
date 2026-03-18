@extends('layouts.auth')

@section('title', 'Sign In')

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

@section('content')
    <!--begin::Authentication - Sign-in -->
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
                        {{-- Swapping: mixjo-default-logo is light (belongs in dark), mixjo-default-logo-dark is dark (belongs in light) --}}
                        <img class="dark:hidden max-w-full transition-all duration-300 object-contain"
                            src="{{ optional($settings)->app_dark_photo ? asset('storage/' . $settings->app_dark_photo) : asset('metronic/media/app/mixjo-default-logo-dark.svg') }}"
                            style="width: {{ $aWidth }} !important; height: {{ $aHeight }} !important; min-height: {{ $aHeight }} !important;" />
                        <img class="hidden dark:block max-w-full transition-all duration-300 object-contain"
                            src="{{ optional($settings)->app_light_photo ? asset('storage/' . $settings->app_light_photo) : asset('metronic/media/app/mixjo-default-logo.svg') }}"
                            style="width: {{ $aWidth }} !important; height: {{ $aHeight }} !important; min-height: {{ $aHeight }} !important;" />
                    </a>
                </div>
                <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-10" id="sign_in_form"
                    method="post" autocomplete="off">
                    @csrf

                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                            Sign in
                        </h3>
                        <div class="flex items-center justify-center font-medium">
                            <span class="text-sm text-secondary-foreground me-1.5">
                                Need an account?
                            </span>
                            <a class="text-sm text-primary font-medium hover:text-primary-active"
                                href="{{ route('register') }}">
                                Sign up
                            </a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="text-sm font-medium text-danger text-center -mb-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Email</label>
                        <input class="kt-input" placeholder="email@email.com" type="email" name="email"
                            autocomplete="off" value="{{ old('email') }}" required />
                    </div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between gap-1">
                            <label class="kt-form-label font-normal text-mono">Password</label>
                            <a class="text-sm text-primary font-medium hover:text-primary-active shrink-0"
                                href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="kt-input" data-kt-toggle-password="true">
                            <input name="password" placeholder="Enter Password" type="password" required
                                autocomplete="off" />
                            <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                                data-kt-toggle-password-trigger="true" type="button">
                                <span class="kt-toggle-password-active:hidden">
                                    <i class="ki-filled ki-eye text-muted-foreground"></i>
                                </span>
                                <span class="hidden kt-toggle-password-active:block">
                                    <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                                </span>
                            </button>
                        </div>
                    </div>

                    <label class="kt-label">
                        <input class="kt-checkbox kt-checkbox-sm" name="remember" type="checkbox" value="1" />
                        <span class="kt-checkbox-label">Remember me</span>
                    </label>

                    <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                        Sign In
                    </button>
                </form>
            </div>
        </div>

        {{-- Right: Branded background image (40% on desktop) --}}
        <div class="hidden lg:block lg:order-2 auth-image-col bg-center xl:bg-cover bg-no-repeat branded-bg">
            <div class="flex flex-col p-8 lg:p-16 gap-6">
                {{-- Logo removed from here to be exclusively in the form section as requested --}}
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-2xl font-semibold text-mono">Welcome to MixJo.</h3>
                        <div class="text-base font-medium text-secondary-foreground">
                            Everything you need to optimise and grow your travel business in one solution.
                        </div>
                    </div>
                    <div class="text-base font-medium text-secondary-foreground">
                        Travel CRM + backoffice + booking engine software tailored for travel agents, tour operators,
                        homeworkers and DMC's.
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
    @if (session('session_expired'))
        <script>
            window.showToast({
                type: 'info',
                message: '{{ __('messages.session_expired ') }}',
            });
        </script>
    @endif
@endpush
