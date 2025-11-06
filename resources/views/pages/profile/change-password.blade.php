@extends('layouts.master')

@section('title', __('main.edit_password'))

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_password') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.update_your_password') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('user.profile') }}">
                    {{ __('main.view_profile') }}
                </a>
            </div>
        </div>
    </div>
    <!-- End of Container -->

    <!-- Container -->
    <div class="kt-container-fixed">
        <!-- begin: grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6">
            <!-- Profile Information Column -->
            <div class="kt-card min-w-full">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">
                        {{ __('main.profile_information') }}
                    </h3>
                </div>
                <div class="kt-card-content p-6">
                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label font-normal text-mono">{{ __('main.email') }}</label>

                                <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                    <input type="email" name="email" value="{{ $user->email }}" disabled required>
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                                        data-kt-toggle-password-trigger="true" type="button">
                                        <span class="hidden kt-toggle-password-active:block">
                                            <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                                        </span>
                                    </button>
                                </div>

                                @error('password')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label font-normal text-mono">{{ __('main.old_password') }}</label>

                                <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                    <input type="password" name="password" required>
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
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label font-normal text-mono">{{ __('main.new_password') }}</label>

                                <div class="kt-input h-[45px]" data-kt-toggle-password="true">
                                    <input type="password" name="confirmation_password" required>
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

                                @error('confirmation_password')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="kt-btn kt-btn-danger w-full sm:w-auto">
                                {{ __('main.update_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end: grid -->
    </div>
    <!-- End of Container -->
@endsection

@push('scripts')
    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("ki-eye");
                icon.classList.add("ki-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("ki-eye-slash");
                icon.classList.add("ki-eye");
            }
        }
    </script>
@endpush
