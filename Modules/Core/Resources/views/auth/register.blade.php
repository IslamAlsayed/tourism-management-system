@extends('layouts.metronic')

@section('title', 'Register')

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

@section('content')
    <!--begin::Authentication - Register -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[370px] m-auto" style="width: calc(100% - 40px);">
            <form action="{{ route('register') }}" class="kt-card-content p-6" id="sign_up_form" method="post" autocomplete="off">
                @csrf

                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        Sign up
                    </h3>
                    <div class="flex items-center justify-center">
                        <span class="text-sm text-secondary-foreground me-1.5">
                            Already have an Account ?
                        </span>
                        <a class="text-sm kt-link" href="{{ route('login') }}">
                            Sign In
                        </a>
                    </div>
                </div>

                {{-- <div class="grid grid-cols-2 gap-2">
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

                <div class="flex items-center gap-2 mt-4 mb-2">
                    <span class="border-t border-border w-full"></span>
                    <span class="text-xs text-secondary-foreground uppercase">or</span>
                    <span class="border-t border-border w-full"></span>
                </div> --}}

                <div class="grid grid-cols-1 gap-2">
                    <div class="flex flex-col gap-1 mb-2">
                        <label class="kt-form-label font-normal text-mono mb-1">Name</label>
                        <input class="kt-input h-[45px]" name="name" placeholder="Your Name" type="text" value="{{ old('name') }}" required
                            autocomplete="off" />
                    </div>

                    <div class="flex flex-col gap-1 mb-2">
                        <label class="kt-form-label font-normal text-mono mb-1">Email</label>
                        <input class="kt-input h-[45px]" name="email" placeholder="email@email.com" type="text" value="{{ old('email') }}" required
                            autocomplete="off" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-2">
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono mb-1">
                                Password
                            </label>
                            <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                <input name="password" placeholder="Enter Password" type="password" required autocomplete="off">
                                <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true"
                                    type="button">
                                    <span class="kt-toggle-password-active:hidden">
                                        <i class="ki-filled ki-eye text-muted-foreground">
                                        </i>
                                    </span>
                                    <span class="hidden kt-toggle-password-active:block">
                                        <i class="ki-filled ki-eye-slash text-muted-foreground">
                                        </i>
                                    </span>
                                </button>
                                </input>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono mb-1">Confirm Password</label>
                            <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                <input name="password_confirmation" placeholder="Re-enter Password" type="password" required />
                                <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true"
                                    type="button">
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
                    </div>
                </div>

                <div class="custom-input mb-4 disabled opacity-50">
                    <input type="checkbox" name="accept" class="mb-0" id="accept" value="1">
                    <label for="accept">
                        I accept
                        <a class="text-sm text-primary link" href="#">Terms &amp; Conditions</a>
                    </label>
                </div>

                <button class="w-full kt-btn kt-btn-primary flex justify-center grow" type="submit">
                    Sign up
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Register-->
@endsection
