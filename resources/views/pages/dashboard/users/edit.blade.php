@extends('layouts.master')

@section('title', __('main.edit_user'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
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
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-6">
            <!-- Personal Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.personal_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <form class="space-y-6" method="POST" action="{{ route('users.update', $user->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo -->
                        @include('components.input-image', [
                            'modelKey' => $user->name ?? 'U',
                            'column' => 'user',
                            'columnName' => 'photo',
                            'record' => $user,
                        ])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- First Name -->
                            <div class="">
                                <label for="first_name" class="kt-label mb-2">{{ __('main.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]"
                                    value="{{ $user->first_name }}">
                                @error('first_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="">
                                <label for="last_name" class="kt-label mb-2">{{ __('main.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]"
                                    value="{{ $user->last_name }}">
                                @error('last_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ $user->email }}">
                                @error('email')
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
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Phone -->
                                    <div class="">
                                        <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                            value="{{ $user->phone }}">
                                        @error('phone')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="">
                                        <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                        <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                            value="{{ $user->mobile }}">
                                        @error('mobile')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="">
                                        <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                                        <input type="text" name="address" id="address" class="kt-input h-[45px]"
                                            value="{{ $user->address }}">
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
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Birth Date -->
                                    <div class="">
                                        <label for="birth_date" class="kt-label mb-2">{{ __('main.birth_date') }}</label>
                                        <input type="date" name="birth_date" id="birth_date" class="kt-input h-[45px]"
                                            value="{{ $user->birth_date ? $user->birth_date->format('Y-m-d') : '' }}">
                                        @error('birth_date')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Hire Date -->
                                    <div class="">
                                        <label for="hire_date" class="kt-label mb-2">{{ __('main.hire_date') }}</label>
                                        <input type="date" name="hire_date" id="hire_date" class="kt-input h-[45px]"
                                            value="{{ $user->hire_date ? $user->hire_date->format('Y-m-d') : '' }}">
                                        @error('hire_date')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Department -->
                                    <div class="">
                                        <label for="department" class="kt-label mb-2">{{ __('main.department') }}</label>
                                        <select name="department" id="department" class="kt-input basic-single">
                                            <option value="" disabled selected></option>
                                            @foreach (config('helpers.departments') as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $user->department == $key ? 'selected' : '' }}>
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
                                        <label for="position" class="kt-label mb-2">{{ __('main.position') }}</label>
                                        <select name="position" id="position" class="kt-input basic-single">
                                            <option value="" disabled selected></option>
                                            @foreach (config('helpers.positions') as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $user->position == $key ? 'selected' : '' }}>{{ ucfirst($value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Settings -->
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.system_settings') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Preferred Language -->
                                    <div class="">
                                        <label for="preferred_language"
                                            class="kt-label mb-2">{{ __('main.preferred_language') }}</label>
                                        <select name="preferred_language" id="preferred_language"
                                            class="kt-select basic-single">
                                            <option value="" disabled selected></option>
                                            <option value="en"
                                                {{ $user->preferred_language == 'en' ? 'selected' : '' }}>
                                                {{ __('main.english') }}</option>
                                            <option value="ar"
                                                {{ $user->preferred_language == 'ar' ? 'selected' : '' }}>
                                                {{ __('main.arabic') }}</option>
                                        </select>
                                        @error('preferred_language')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Timezone -->
                                    <div class="">
                                        <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                        <select name="timezone_id" id="timezone_id" class="kt-select basic-single">
                                            <option value="" disabled selected></option>
                                            @foreach ($timezones as $zone)
                                                <option value="{{ $zone['id'] }}"
                                                    {{ $user->timezone_id == $zone['id'] ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar' ? ($zone['name_ar'] ? $zone['name_ar'] . ' ' : '') : ($zone['name'] ? $zone['name'] . ' ' : '') }}({{ $zone['abbreviation'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('timezone_id')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- User Flags -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_admin" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'is_admin',
                                            'id' => 'is_admin',
                                            'value' => '1',
                                            'checked' => $user->is_admin == 1,
                                            'label' => __('main.is_admin'),
                                        ])
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_active" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'is_active',
                                            'id' => 'is_active',
                                            'value' => '1',
                                            'checked' => $user->is_active == 1,
                                            'label' => __('main.is_active'),
                                        ])
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_verified" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'is_verified',
                                            'id' => 'is_verified',
                                            'value' => '1',
                                            'checked' => $user->is_verified == 1,
                                            'label' => __('main.is_verified'),
                                        ])
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="force_password_change" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'force_password_change',
                                            'id' => 'force_password_change',
                                            'value' => '1',
                                            'checked' => $user->force_password_change == 1,
                                            'label' => __('main.force_password_change'),
                                        ])
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
                                @include('components.elements.input-text-editor', [
                                    'column' => 'preferences',
                                    'value' => $user->preferences,
                                ])

                                <!-- Notes -->
                                @include('components.elements.input-text-editor', [
                                    'column' => 'notes',
                                    'value' => $user->notes,
                                ])

                                <!-- Update Submit Buttons -->
                                @include('components.elements.update-submit', ['models' => 'users'])
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
                                <div class="mb-2 font-semibold">{{ __('main.complete_profile') }}</div>
                                <div class="text-sm text-secondary-foreground">{{ __('main.complete_profile_desc') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-warning-light rounded-full p-2">
                                <i class="ki-filled ki-security-user text-warning"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.secure_password') }}</div>
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
