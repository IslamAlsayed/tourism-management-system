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

@section('content')
    <!--begin::Authentication - Sign-in -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        <div class="kt-card max-w-[370px] w-full">
            <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-6" id="kt_sign_in_form"
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
                    <input class="kt-input h-[45px]" placeholder="email@email.com" type="email" name="email"
                        value="{{ request()->ip() == '156.210.211.81' ? 'tawfig@example.com' : (request()->ip() == '156.211.118.168' ? 'islam@example.com' : 'islam@example.com') }}" />
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
                    <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                        <input name="password" placeholder="Enter Password" type="password" value="12345678" />
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
                    @include('components.elements.checkbox-button', [
                        'name' => 'remember',
                        'id' => 'remember-me',
                        'value' => '1',
                        'label' => 'Remember me',
                    ])
                </label>
                <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit" toggle-button>
                    Sign In
                </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Sign-in-->
@endsection

@push('scripts')
    @if (session('session_expired'))
        <script>
            window.showToast({
                type: 'info',
                message: '{{ __('messages.session_expired') }}'
            });
        </script>
    @endif
@endpush
