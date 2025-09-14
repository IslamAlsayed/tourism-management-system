@extends('layouts.master')

@section('title', __('main.edit_user'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_user') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_user_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_users') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- User Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_user_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo -->
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-24 h-24 rounded-full bg-secondary-light border-4 border-white shadow-lg mx-auto mb-4 overflow-hidden">
                                    <img id="profile-preview" src="{{ asset('metronic/media/avatars/300-3.png') }}"
                                        alt="{{ __('main.user_avatar') }}" class="w-full h-full object-cover">
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 cursor-pointer hover:bg-primary-dark">
                                    <i class="ki-filled ki-camera text-sm"></i>
                                </label>
                                <input type="file" id="photo" name="photo" class="hidden" accept="image/*">
                            </div>
                            <div class="text-sm text-secondary-foreground">{{ __('main.upload_profile_photo') }}</div>
                            @error('photo')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div class="mb-4">
                                <label for="first_name" class="kt-label required mb-2">{{ __('main.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.first_name') }}" required value="{{ $user->first_name }}">
                                @error('first_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-4">
                                <label for="last_name" class="kt-label required mb-2">{{ __('main.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.last_name') }}" required value="{{ $user->last_name }}">
                                @error('last_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                <input type="hidden" name="email" required value="{{ $user->email }}">
                                <input type="email" id="email" class="kt-input h-[45px]"
                                    placeholder="example@domain.com" required value="{{ $user->email }}" disabled>
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-4">
                                <label for="username" class="kt-label mb-2">{{ __('main.username') }}</label>
                                <input type="text" name="username" id="username" class="kt-input h-[45px]"
                                    placeholder="username123" value="{{ $user->name }}">
                                @error('username')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]"
                                    placeholder="+966 50 123 4567" value="{{ $user->phone }}">
                                @error('phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="mb-4">
                                <label for="birth_date" class="kt-label mb-2">{{ __('main.date_of_birth') }}</label>
                                <input type="date" name="birth_date" id="birth_date" class="kt-input h-[45px]"
                                    value="{{ $user->birth_date }}">
                                @error('birth_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Gender -->
                            <div class="mb-4">
                                <label for="gender" class="kt-label mb-2">{{ __('main.gender') }}</label>
                                <select name="gender" id="gender" class="kt-select h-[45px]">
                                    <option value="">{{ __('main.select_status') }}</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>
                                        {{ __('main.male') }}</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>
                                        {{ __('main.female') }}</option>
                                </select>
                                @error('gender')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="mb-4">
                                <label for="country_id" class="kt-label mb-2">{{ __('main.country') }}</label>
                                <select name="country_id" id="country_id" class="kt-select h-[45px]">
                                    <option value="">{{ __('main.select_status') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="kt-label required mb-2">{{ __('main.password') }}
                                    ({{ __('main.optional') }})</label>
                                <input type="password" name="password" id="password" class="kt-input h-[45px]"
                                    placeholder="{{ __('main.enter_new_password') }}">
                                <div class="text-xs text-secondary-foreground mt-1">
                                    {{ __('main.password_hint') ?? 'Must be at least 8 characters' }}
                                </div>
                                @error('password')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="kt-label required mb-2">{{ __('main.confirm_password') }}
                                    ({{ __('main.optional') }})</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="kt-input h-[45px]" placeholder="{{ __('main.confirm_password') }}">
                                @error('password_confirmation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="kt-label required mb-2">{{ __('main.role') ?? 'Role' }}</label>
                            <select name="role" id="role" class="kt-select h-[45px]" required>
                                <option value="">{{ __('main.select_role') ?? 'Select user role' }}</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                    {{ __('main.admin') ?? 'Admin' }}</option>
                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>
                                    {{ __('main.moderator') ?? 'Moderator' }}</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                                    {{ __('main.regular_user') ?? 'Regular User' }}</option>
                            </select>
                            @error('role')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="mb-4">
                            <label for="bio" class="kt-label mb-2">{{ __('main.bio') }}</label>
                            <textarea name="bio" id="bio" rows="4" class="kt-input h-[45px]"
                                placeholder="{{ __('main.additional_user_info') ?? 'Additional information about the user...' }}">{{ $user->bio }}</textarea>
                            @error('bio')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User Settings -->
                        <div class="space-y-4">
                            <h4 class="font-semibold">{{ __('main.account_settings') }}</h4>

                            <div class="grid lg:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                        value="1" {{ $user->is_active ? 'checked' : '' }}>
                                    <label for="is_active"
                                        class="kt-label mb-0">{{ __('main.activate_account') ?? 'Activate Account' }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="email_verified" id="email_verified" class="kt-checkbox"
                                        value="1" {{ $user->email_verified ? 'checked' : '' }}>
                                    <label for="email_verified"
                                        class="kt-label mb-0">{{ __('main.verify_email') ?? 'Verify Email' }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notifications_enabled" id="notifications_enabled"
                                        class="kt-checkbox" value="1"
                                        {{ $user->notifications_enabled ? 'checked' : '' }}>
                                    <label for="notifications_enabled"
                                        class="kt-label mb-0">{{ __('main.enable_notifications') ?? 'Enable Notifications' }}</label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="marketing_emails" id="marketing_emails"
                                        class="kt-checkbox" value="1"
                                        {{ $user->marketing_emails ? 'checked' : '' }}>
                                    <label for="marketing_emails"
                                        class="kt-label mb-0">{{ __('main.marketing_emails') ?? 'Marketing Emails' }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.create_user') ?? 'Create User' }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') ?? 'Save and Add Another' }}
                            </button>
                            <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.security_tips') ?? 'Security Tips' }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-shield-tick text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.strong_password') ?? 'Strong Password' }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.password_mix_tip') ?? 'Use a mix of letters, numbers and symbols' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-information text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.permission_setting') ?? 'Permission Setting' }}
                                </div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.appropriate_permissions_tip') ?? 'Grant user only the appropriate permissions for their role' }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-message-text-2 text-primary"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.email_verification') ?? 'Email Verification' }}
                                </div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.verify_email_tip') ?? 'Ensure the email is valid before activation' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Photo preview
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-generate username from first and last name
        function generateUsername() {
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const usernameField = document.getElementById('username');

            if (firstName && lastName && !usernameField.value) {
                const username = (firstName + lastName).toLowerCase().replace(/\s+/g, '');
                usernameField.value = username;
            }
        }

        document.getElementById('first_name').addEventListener('blur', generateUsername);
        document.getElementById('last_name').addEventListener('blur', generateUsername);

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            // Add password strength validation here
        });
    </script>
@endpush
