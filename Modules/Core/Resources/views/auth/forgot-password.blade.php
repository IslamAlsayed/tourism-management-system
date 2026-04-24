@extends('layouts.auth')

@section('title', 'Password Recovery')

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
    <!--begin::Authentication - Forget Password -->
    <div class="auth-grid grow min-h-[100svh]">

        {{-- Left: Form (60% on desktop) --}}
        <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1 auth-form-col">
            <div class="kt-card max-w-[370px] w-full">
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
                <form action="{{ route('password.email') }}" class="kt-card-content flex flex-col gap-5 p-10"
                    id="kt_password_reset_form" method="post">
                    @csrf

                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                            Your Email
                        </h3>
                        <div class="flex items-center justify-center font-medium">
                            <span class="text-sm text-secondary-foreground">
                                Enter your email to reset your password
                            </span>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="text-sm font-medium text-success text-center -mb-2">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="text-sm font-medium text-danger text-center -mb-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Email</label>
                        <input class="kt-input" type="email" name="email" value="{{ old('email') }}"
                            placeholder="email@email.com" required autofocus />
                    </div>

                    <button class="kt-btn kt-btn-primary flex justify-center grow mt-2">
                        Continue
                        <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>

                    <div class="flex items-center justify-center mt-2">
                        <span class="text-sm text-secondary-foreground me-1.5">
                            Remembered your password?
                        </span>
                        <a class="text-sm text-primary font-medium hover:text-primary-active"
                            href="{{ route('login') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right: Branded background image (40% on desktop) --}}
        <div class="hidden lg:block lg:order-2 auth-image-col bg-center xl:bg-cover bg-no-repeat branded-bg">
            <div class="flex flex-col p-8 lg:p-16 gap-6">
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
    <!--end::Authentication - Forget Password-->
@endsection
