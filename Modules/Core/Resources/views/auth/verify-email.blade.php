@extends('layouts.auth')

@section('title', 'Verify Email')

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
            <div class="kt-card max-w-[440px] w-full border-0 shadow-none bg-transparent">
                <div class="flex justify-center mb-5">
                    <a href="{{ url('/') }}">
                        <img class="dark:hidden max-w-none"
                            src="{{ asset('metronic/media/app/mixjo-default-logo-dark.svg') }}"
                            style="height: 100px !important; min-height: 100px !important; width: auto !important; object-fit: contain !important;" />
                        <img class="hidden dark:block max-w-none"
                            src="{{ asset('metronic/media/app/mixjo-default-logo.svg') }}"
                            style="height: 100px !important; min-height: 100px !important; width: auto !important; object-fit: contain !important;" />
                    </a>
                </div>
                <div class="kt-card-content p-10">
                    <div class="flex justify-center py-10">
                        <img alt="image" class="dark:hidden max-h-[130px]"
                            src="{{ asset('metronic/media/illustrations/30.svg') }}" />
                        <img alt="image" class="light:hidden max-h-[130px]"
                            src="{{ asset('metronic/media/illustrations/30-dark.svg') }}" />
                    </div>
                    <h3 class="text-lg font-medium text-mono text-center mb-3">
                        Check your email
                    </h3>
                    <div class="text-sm text-center text-secondary-foreground mb-7.5">
                        Please click the link sent to your email
                        <a class="text-sm text-foreground font-medium hover:text-primary" href="#">
                            {{ $request->user()->email }}
                        </a>
                        <br />
                        to verify your account. Thank you
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-2 rounded text-center">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-4">
                        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                            @csrf
                            <button class="kt-btn kt-btn-primary flex justify-center w-full" type="submit">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="kt-btn kt-btn-light flex justify-center w-full">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
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
    <!--end::Authentication - Verify Email-->
@endsection

@push('scripts')
@endpush
