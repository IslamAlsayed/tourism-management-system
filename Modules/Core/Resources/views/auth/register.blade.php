@extends('layouts.auth')

@section('title', 'Register')

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
    <!--begin::Authentication - Register -->
    <div class="auth-grid grow min-h-[100svh]">

        {{-- Left: Form (60% on desktop) --}}
        <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1 auth-form-col">
            <div class="kt-card max-w-[650px] w-full">
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
                <form action="{{ route('register') }}" class="kt-card-content flex flex-col gap-5 p-10" id="sign_up_form"
                    method="post" autocomplete="off">
                    @csrf

                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                            Sign up
                        </h3>
                        <div class="flex items-center justify-center">
                            <span class="text-sm text-secondary-foreground me-1.5">
                                Already have an Account?
                            </span>
                            <a class="text-sm text-primary font-medium hover:text-primary-active"
                                href="{{ route('login') }}">
                                Sign In
                            </a>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="text-sm font-medium text-danger text-center -mb-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Two-column grid for all fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Name --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Name</label>
                            <input class="kt-input" name="name" placeholder="Your Name" type="text"
                                value="{{ old('name') }}" required autocomplete="off" />
                            @error('name')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Email</label>
                            <input class="kt-input" name="email" placeholder="email@email.com" type="email"
                                value="{{ old('email') }}" required autocomplete="off" />
                            @error('email')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Country --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Country</label>
                            <select class="kt-input" id="country_selector" name="country_id" required>
                                <option value="">Select your country</option>
                                @foreach ($countries ?? [] as $country)
                                    <option data-phone-code="{{ $country->phone_code }}" value="{{ $country->id }}"
                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $country->name_ar ?? $country->native : $country->name ?? $country->native }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Mobile Number</label>
                            <input class="kt-input" id="mobile_input" name="mobile" placeholder="Your Mobile Number"
                                type="text" value="{{ old('mobile') }}" required autocomplete="off" />
                            @error('mobile')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Company Name --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Company Name</label>
                            <input class="kt-input" name="company_name" placeholder="Your Company Name" type="text"
                                value="{{ old('company_name') }}" required autocomplete="off" />
                            @error('company_name')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Company Website (optional) --}}
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between gap-1">
                                <label class="kt-form-label font-normal text-mono">Company Website</label>
                                <span class="text-xs text-muted-foreground">Optional</span>
                            </div>
                            <input class="kt-input" name="company_website" placeholder="https://example.com" type="text"
                                value="{{ old('company_website') }}" autocomplete="off" />
                            @error('company_website')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Password</label>
                            <div class="kt-input" data-kt-toggle-password="true">
                                <input name="password" placeholder="Enter Password" type="password"
                                    required autocomplete="off" />
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
                            @error('password')
                                <div class="text-sm font-medium text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="flex flex-col gap-1">
                            <label class="kt-form-label font-normal text-mono">Confirm Password</label>
                            <div class="kt-input" data-kt-toggle-password="true">
                                <input name="password_confirmation" placeholder="Re-enter Password" type="password"
                                    required autocomplete="off" />
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

                    </div>{{-- end grid --}}

                    <label class="kt-checkbox-group">
                        <input class="kt-checkbox kt-checkbox-sm" name="accept" type="checkbox" value="1"
                            required />
                        <span class="kt-checkbox-label">
                            I accept
                            <a class="text-sm text-primary font-medium hover:text-primary-active" href="#">Terms
                                &amp; Conditions</a>
                        </span>
                    </label>

                    <button class="kt-btn kt-btn-primary flex justify-center grow" type="submit">
                        Sign up
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
    <!--end::Authentication - Register-->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelector = document.getElementById('country_selector');
            const mobileInput = document.getElementById('mobile_input');

            if (countrySelector && mobileInput) {
                countrySelector.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const phoneCode = selectedOption.getAttribute('data-phone-code');

                    if (phoneCode) {
                        // If mobile input is empty or just contains a plus/code, update it
                        if (!mobileInput.value || /^\+?\d*$/.test(mobileInput.value)) {
                            mobileInput.value = '+' + phoneCode;
                            mobileInput.focus();
                        }
                    }
                });
            }
        });
    </script>
@endpush
