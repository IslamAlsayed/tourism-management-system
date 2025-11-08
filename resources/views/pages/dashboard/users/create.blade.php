@extends('layouts.master')

@section('title', __('main.create_new_user'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_new_user') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_new_user_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Personal Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.personal_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <form class="space-y-6" method="POST" action="{{ route('users.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo -->
                        @include('components.input-image', [
                            'column' => 'user',
                            'columnName' => 'photo',
                        ])

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- First Name -->
                            <div class="">
                                <label for="first_name" class="kt-label required mb-2">{{ __('main.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]"
                                    value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="">
                                <label for="last_name" class="kt-label required mb-2">{{ __('main.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- Password -->
                            <div class="">
                                <label for="password" class="kt-label required mb-2">{{ __('main.password') }}</label>
                                <input type="password" name="password" id="password" class="kt-input h-[45px]" required>
                                @error('password')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation Password -->
                            <div class="">
                                <label for="password_confirmation"
                                    class="kt-label required mb-2">{{ __('main.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="kt-input h-[45px]" required>
                                @error('password_confirmation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6">
                                    <!-- Phone -->
                                    <div class="">
                                        <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="">
                                        <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                        <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                            value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="">
                                        <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                                        <input type="text" name="address" id="address" class="kt-input h-[45px]"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.employment_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6">
                                    <!-- Birth Date -->
                                    <div class="">
                                        <label for="birth_date" class="kt-label mb-2">{{ __('main.birth_date') }}</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="kt-input h-[45px]" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Department -->
                                    <div class="">
                                        <label for="department"
                                            class="kt-label required mb-2">{{ __('main.department') }}</label>
                                        <select name="department" id="department" class="kt-input h-[45px]"
                                            special-search required>
                                            <option value="">{{ __('main.select_department') }}</option>
                                            @foreach (config('helpers.departments') as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('department') == $key ? 'selected' : '' }}>
                                                    {{ ucfirst($value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Position -->
                                    <div class="">
                                        <label for="position"
                                            class="kt-label required mb-2">{{ __('main.position') }}</label>
                                        <select name="position" id="position" class="kt-input h-[45px]" special-search
                                            required>
                                            <option value="">{{ __('main.select_position') }}</option>
                                            @foreach (config('helpers.positions') as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('position') == $key ? 'selected' : '' }}>{{ ucfirst($value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- System Settings -->
                            <div class="kt-card mb-4">
                                <div class="kt-card-header">
                                    <h3 class="kt-card-title">{{ __('main.system_settings') }}</h3>
                                </div>
                                <div class="kt-card-body p-4">
                                    <div class="grid lg:grid-cols-3 gap-6 mb-4">
                                        <!-- Preferred Language -->
                                        <div class="">
                                            <label for="preferred_language"
                                                class="kt-label mb-2">{{ __('main.preferred_language') }}</label>
                                            <select name="preferred_language" id="preferred_language"
                                                class="kt-select h-[45px]" special-search>
                                                <option value="">{{ __('main.select_language') }}</option>
                                                <option value="en"
                                                    {{ old('preferred_language') == 'en' ? 'selected' : '' }}>
                                                    {{ __('main.english') }}</option>
                                                <option value="ar"
                                                    {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>
                                                    {{ __('main.arabic') }}</option>
                                            </select>
                                            @error('preferred_language')
                                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Timezone -->
                                        <div class="">
                                            <label for="timezone"
                                                class="kt-label mb-2">{{ __('main.timezone_field') }}</label>
                                            <select name="timezone" id="timezone" class="kt-select h-[45px]"
                                                special-search>
                                                <option value="">{{ __('main.select_timezone') }}</option>
                                                <option value="UTC" {{ old('timezone') == 'UTC' ? 'selected' : '' }}>
                                                    UTC
                                                </option>
                                                <option value="Asia/Riyadh"
                                                    {{ old('timezone') == 'Asia/Riyadh' ? 'selected' : '' }}>
                                                    Asia/Riyadh
                                                </option>
                                                <option value="Asia/Dubai"
                                                    {{ old('timezone') == 'Asia/Dubai' ? 'selected' : '' }}>
                                                    Asia/Dubai
                                                </option>
                                                <option value="Europe/London"
                                                    {{ old('timezone') == 'Europe/London' ? 'selected' : '' }}>
                                                    Europe/London
                                                </option>
                                                <option value="America/New_York"
                                                    {{ old('timezone') == 'America/New_York' ? 'selected' : '' }}>
                                                    America/New_York
                                                </option>
                                            </select>
                                            @error('timezone')
                                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- User Flags -->
                                    <div class="grid lg:grid-cols-3 gap-6 mb-4">
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="is_admin" value="0">
                                            <input type="checkbox" name="is_admin" id="is_admin" class="kt-checkbox"
                                                value="1" {{ old('is_admin') ? 'checked' : '' }}>
                                            <label for="is_admin" class="kt-label mb-0">{{ __('main.is_admin') }}</label>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                                value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                            <label for="is_active"
                                                class="kt-label mb-0">{{ __('main.is_active') }}</label>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="is_verified" value="0">
                                            <input type="checkbox" name="is_verified" id="is_verified"
                                                class="kt-checkbox" value="1"
                                                {{ old('is_verified') ? 'checked' : '' }}>
                                            <label for="is_verified"
                                                class="kt-label mb-0">{{ __('main.is_verified') }}</label>
                                        </div>
                                    </div>

                                    <div class="grid lg:grid-cols-2 gap-6">
                                        <div class="flex items-center gap-3">
                                            <input type="hidden" name="force_password_change" value="0">
                                            <input type="checkbox" name="force_password_change" disabled
                                                id="force_password_change" class="kt-checkbox" value="1"
                                                {{ old('force_password_change') ? 'checked' : '' }}>
                                            <label for="force_password_change"
                                                class="kt-label mb-0">{{ __('main.force_password_change') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="kt-card">
                                <div class="kt-card-header">
                                    <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                                </div>
                                <div class="kt-card-body p-4">
                                    <!-- Preferences -->
                                    <div class="mb-4">
                                        <label for="preferences"
                                            class="kt-label mb-2">{{ __('main.preferences') }}</label>
                                        <input id="preferences" type="hidden" name="preferences"
                                            value="{{ old('preferences') }}">
                                        <trix-editor input="preferences"></trix-editor>
                                        @error('preferences')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="mb-4">
                                        <label for="notes" class="kt-label mb-2">{{ __('main.notes') }}</label>
                                        <input id="notes" type="hidden" name="notes"
                                            value="{{ old('notes') }}">
                                        <trix-editor input="notes"></trix-editor>
                                        @error('notes')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Save Submit Buttons -->
                                    @include('components.elements.save-submit', ['models' => 'users'])
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User Creation Tips -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.user_creation_tips') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-information text-success"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.complete_profile') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.complete_profile_desc') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-security-user text-warning"></i>
                            </div>
                            <div>
                                <div class="font-semibold">{{ __('main.secure_password') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.secure_password_desc') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-security-user"></i>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ __('main.user_permissions') }}
                                </div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.user_permissions_desc') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
