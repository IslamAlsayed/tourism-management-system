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
        <div class="kt-card max-w-[370px] m-auto" style="width: calc(100% - 40px);">
            <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-6" id="kt_sign_in_form" method="post" autocomplete="off">
                @csrf
                <div class="text-center ">
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
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        Email
                    </label>
                    <input class="kt-input h-[45px]" placeholder="e@e.com" type="email" name="email" autocomplete="off" value="{{ old('email') }}"
                        list="emails" />
                    <datalist id="emails">
                        <option value="tawfiq@example.com">
                        <option value="islam@example.com">
                        <option value="ahmed@example.com">
                    </datalist>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1 disabled opacity-50">
                        <label class="kt-form-label font-normal text-mono">
                            Password
                        </label>
                        <a class="text-sm kt-link shrink-0" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    </div>
                    <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                        <input name="password" type="password" value="" autocomplete="off" />
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                            <span class="kt-toggle-password-active:hidden">
                                <i class="ki-filled ki-eye text-muted-foreground"></i>
                            </span>
                            <span class="hidden kt-toggle-password-active:block">
                                <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                            </span>
                        </button>
                    </div>
                </div>
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
                message: '{{ __('messages.session_expired ') }}',
            });
        </script>
    @endif
@endpush
