@extends('layouts.master')

@section('title', __('main.edit_profile'))

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_profile') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.update_personal_info') }}
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
        <!-- Status Message -->
        {{-- @if (session('status'))
            <div class="p-4 mb-5 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                role="alert">
                @if (session('status') == 'profile-updated')
                    Profile information updated successfully.
                @elseif (session('status') == 'photo-updated')
                    Profile photo updated successfully.
                @else
                    {{ session('status') }}
                @endif
            </div>
        @endif --}}

        <!-- begin: grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-7.5">
            <!-- Profile Photo Column -->
            <div class="col-span-1 xl:col-span-3">
                <div class="kt-card min-w-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.profile_photo') }}
                        </h3>
                    </div>
                    <div class="kt-card-content p-6">
                        <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data"
                            class="flex flex-col items-center gap-5">
                            @csrf
                            {{-- <div class="kt-image-input size-32" data-kt-image-input="true"> --}}
                            <div class="" data-kt-image-input="true">
                                <label class="kt-image-input-change" data-kt-image-input-trigger="true"
                                    style="cursor: pointer">
                                    <div style="width: 150px; margin: auto;">
                                        <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : asset('metronic/media/avatars/blank.png') }}"
                                            alt="{{ $user->name }}" style="width: 100%;">
                                    </div>
                                    <input accept=".png, .jpg, .jpeg, .webp" name="photo" type="file"
                                        style="display: none;" />
                                </label>
                            </div>
                            <p class="text-sm text-secondary-foreground text-center">
                                {{ __('main.click_to_change_photo') }} <br>
                                {{ __('main.allowed_formats') }}
                            </p>
                            @error('photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="kt-btn kt-btn-primary w-full">
                                {{ __('main.update_photo') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Profile Information Column -->
                <div class="kt-card min-w-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.profile_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-content p-6">
                        <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col gap-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label text-mono">
                                        {{ __('main.name') }}
                                    </label>
                                    <input class="kt-input" name="name" placeholder="{{ __('main.your_name') }}"
                                        type="text" value="{{ old('name', $user->name) }}" required />
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label text-mono">
                                        {{ __('main.email') }}
                                    </label>
                                    <input class="kt-input" name="email" placeholder="{{ __('main.your_email') }}"
                                        type="email" value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label text-mono">
                                    {{ __('main.phone') }}
                                </label>
                                <input class="kt-input" name="phone" placeholder="{{ __('main.your_phone') }}"
                                    type="text" value="{{ old('phone', $user->phone) }}" />
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label text-mono">
                                    {{ __('main.bio') }}
                                </label>
                                <textarea class="kt-textarea" name="bio" placeholder="{{ __('main.tell_about_yourself') }}" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="kt-btn kt-btn-primary">
                                    {{ __('main.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="kt-card min-w-full mt-5 lg:mt-7.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title text-danger">
                            {{ __('main.delete_account') }}
                        </h3>
                    </div>
                    <div class="kt-card-content p-6">
                        <p class="text-secondary-foreground mb-5">
                            {{ __('main.account_deletion_warning') }}
                        </p>
                        <form action="{{ route('profile.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label font-normal text-mono">
                                        {{ __('main.password') }}
                                    </label>
                                    <div class="kt-input" data-kt-toggle-password="true">
                                        <input name="password" placeholder="{{ __('main.enter_current_password') }}"
                                            type="password" required>
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
                                    @error('password', 'userDeletion')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="kt-btn kt-btn-danger w-full sm:w-auto">
                                    {{ __('main.delete_account') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: grid -->
    </div>
    <!-- End of Container -->
@endsection

@push('scripts')
    <script>
        // Initialize image input components
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof KTUI !== 'undefined') {
                KTUI.imageInput.init();
            }
        });
    </script>
@endpush
