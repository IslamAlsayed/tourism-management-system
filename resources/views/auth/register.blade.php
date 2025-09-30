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

@push('scripts')
    <!-- Google tag (gtag.js) -->
    {{--
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script> --}}
    {{--
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-52YZ3XGZJ6');
    </script> --}}

    <!-- Theme Mode -->
    {{--
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
    </script> --}}
    <!-- End of Theme Mode -->
@endpush

@section('content')
    <!--begin::Authentication - Sign-in -->
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg" style="height: 100svh">
        {{-- <div class="kt-card max-w-[500px] w-full"> --}}
            <div class="kt-card max-w-[370px] w-full">
                <form action="{{ route('register') }}" class="kt-card-content p-6" id="sign_up_form" method="post">
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

                    <div class="grid grid-cols-2 gap-2">
                        <a class="kt-btn kt-btn-outline justify-center" href="#">
                            <img alt="" class="size-3.5 shrink-0" src="{{ asset('metronic/media/brand-logos/google.svg') }}" />
                            Use Google
                        </a>
                        <a class="kt-btn kt-btn-outline justify-center" href="#">
                            <img alt="" class="size-3.5 shrink-0 dark:hidden" src="{{ asset('metronic/media/brand-logos/apple-black.svg') }}" />
                            <img alt="" class="size-3.5 shrink-0 light:hidden" src="{{ asset('metronic/media/brand-logos/apple-white.svg') }}" />
                            Use Apple
                        </a>
                    </div>

                    <div class="flex items-center gap-2 mt-4 mb-2">
                        <span class="border-t border-border w-full"></span>
                        <span class="text-xs text-secondary-foreground uppercase">or</span>
                        <span class="border-t border-border w-full"></span>
                    </div>

                    <div class="grid grid-cols-1 gap-2">
                        <div class="flex flex-col gap-1 mb-2">
                            <label class="kt-form-label font-normal text-mono mb-1">Name</label>
                            <input class="kt-input h-[45px]" name="name" placeholder="Your Name" type="text" value="{{ old('name') }}" required autofocus />
                        </div>

                        <div class="flex flex-col gap-1 mb-2">
                            <label class="kt-form-label font-normal text-mono mb-1">Email</label>
                            <input class="kt-input h-[45px]" name="email" placeholder="email@email.com" type="text" value="{{ old('email') }}" required />
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label font-normal text-mono mb-1">
                                    Password
                                </label>
                                <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                    <input name="password" placeholder="Enter Password" type="password" required>
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
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
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
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

                    <label class="kt-checkbox-group inline-flex items-center gap-1 mt-2 mb-4">
                        <input class="kt-checkbox kt-checkbox-sm" name="check" type="checkbox" value="1" />
                        <span class="kt-checkbox-label">
                            I accept
                            <a class="text-sm link" href="#">Terms &amp; Conditions</a>
                        </span>
                    </label>

                    {{-- <div class="mt-2">
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            @for($i = 1; $i <= 10; $i++) <div class="cursor-pointer" style="width: 60px; height: 60px;">
                                <img class="user-photo" data-id="{{$i}}" src="{{asset('assets/images/avatars/avatar' . $i . '.png')}}" alt="{{$i . '.png'}}" />
                        </div>
                        @endfor
                        <input type="hidden" name="photo" id="photo" />
                    </div>
            </div> --}}

            <button class="w-full kt-btn kt-btn-primary flex justify-center grow" type="submit">
                Sign up
            </button>
            </form>
        </div>
    </div>
    <!--end::Authentication - Sign-in-->
@endsection

{{-- @push('scripts')
<script>
    let userPhotos = document.querySelectorAll('.user-photo');
    userPhotos.forEach(photo => {
        photo.addEventListener('click', (e) => {
            document.getElementById('photo').value = e.target.dataset.id;
        })
    });
</script>
@endpush --}}