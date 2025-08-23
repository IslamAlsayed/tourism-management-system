@extends('layouts.master')

@section('title', 'Edit Profile')

@section('content')
    <!-- Container -->
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    Edit Profile
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Update your personal information
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a class="kt-btn kt-btn-outline" href="{{ route('user.profile') }}">
                    View Profile
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
                            Profile Photo
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
                                    <input accept=".png, .jpg, .jpeg" name="photo" type="file"
                                        style="display: none;" />
                                </label>
                            </div>
                            <p class="text-sm text-secondary-foreground text-center">
                                Click the image to change your profile photo. <br>
                                Allowed formats: JPEG, PNG. Max size: 1MB.
                            </p>
                            @error('photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="kt-btn kt-btn-primary w-full">
                                Update Photo
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Profile Information Column -->
                <div class="kt-card min-w-full">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            Profile Information
                        </h3>
                    </div>
                    <div class="kt-card-content p-6">
                        <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col gap-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label text-mono">
                                        Name
                                    </label>
                                    <input class="kt-input" name="name" placeholder="Your Name" type="text"
                                        value="{{ old('name', $user->name) }}" required />
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label text-mono">
                                        Email
                                    </label>
                                    <input class="kt-input" name="email" placeholder="your.email@example.com"
                                        type="email" value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label text-mono">
                                    Phone
                                </label>
                                <input class="kt-input" name="phone" placeholder="Your Phone Number" type="text"
                                    value="{{ old('phone', $user->phone) }}" />
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="kt-form-label text-mono">
                                    Bio
                                </label>
                                <textarea class="kt-textarea" name="bio" placeholder="Tell us about yourself" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="kt-btn kt-btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="kt-card min-w-full mt-5 lg:mt-7.5">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title text-danger">
                            Delete Account
                        </h3>
                    </div>
                    <div class="kt-card-content p-6">
                        <p class="text-secondary-foreground mb-5">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Before
                            deleting your account, please download any data or information that you wish to retain.
                        </p>
                        <form action="{{ route('profile.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="kt-form-label font-normal text-mono">
                                        Password
                                    </label>
                                    <div class="kt-input" data-kt-toggle-password="true">
                                        <input name="password" placeholder="Enter your current password" type="password"
                                            required>
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
                                    Delete Account
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
