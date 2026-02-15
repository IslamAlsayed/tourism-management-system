@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.user')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.user')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.user')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.core.users.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.users')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.core.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 lg:gap-6">
                        <!-- User Information -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.user')]) }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- First Name -->
                                    <div class="">
                                        <label for="first_name" class="kt-label required mb-2">{{ __('main.first_name') }}</label>
                                        <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="">
                                        <label for="last_name" class="kt-label required mb-2">{{ __('main.last_name') }}</label>
                                        <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="">
                                        <label for="password" class="kt-label required mb-2">{{ __('main.password') }}</label>
                                        <input type="password" name="password" id="password" class="kt-input h-[45px]" required autocomplete="off">
                                        @error('password')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirmation Password -->
                                    <div class="">
                                        <label for="password_confirmation" class="kt-label required mb-2">{{ __('main.confirm_password') }}</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="kt-input h-[45px]" required
                                            autocomplete="off">
                                        @error('password_confirmation')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="">
                                        <label for="role" class="kt-label required mb-2">
                                            {{ __('main.role') }}
                                            <span class="text-red-600">*</span>
                                        </label>
                                        <select name="role" id="role" class="kt-input basic-single" required>
                                            <option value="" selected>--</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bio -->
                                @include('components.elements.input-text-editor', [
                                    'column' => 'bio',
                                    'value' => old('bio'),
                                ])
                            </div>
                        </div>

                        <!-- Media Information -->
                        @include('components.inputs.photo')

                        <!-- Contact Information -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.contact')]) }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Email -->
                                    <div class="">
                                        <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                        <input type="email" name="email" id="email" class="kt-input h-[45px]" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="">
                                        <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="kt-input h-[45px]" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="">
                                        <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                        <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]" value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                @include('components.elements.input-text-editor', [
                                    'column' => 'address',
                                    'value' => old('address'),
                                ])
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.employment_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Employee ID -->
                                    <div class="">
                                        <label for="employee_id" class="kt-label mb-2">{{ __('main.employee_id') }}</label>
                                        <input type="text" name="employee_id" id="employee_id" class="kt-input h-[45px]" value="{{ old('employee_id') }}">
                                        @error('employee_id')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Birth Date -->
                                    <div class="">
                                        <label for="birth_date" class="kt-label mb-2">{{ __('main.birth_date') }}</label>
                                        <input type="date" name="birth_date" id="birth_date" class="kt-input h-[45px]" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Hire Date -->
                                    <div class="">
                                        <label for="hire_date" class="kt-label mb-2">{{ __('main.hire_date') }}</label>
                                        <input type="date" name="hire_date" id="hire_date" class="kt-input h-[45px]" value="{{ old('hire_date') }}">
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
                                                <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>
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
                                                <option value="{{ $key }}" {{ old('position') == $key ? 'selected' : '' }}>{{ ucfirst($value) }}
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
                        <div class="kt-card">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.system_settings') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Preferred Language -->
                                    <div class="">
                                        <label for="preferred_language" class="kt-label mb-2">{{ __('main.preferred_language') }}</label>
                                        <select name="preferred_language" id="preferred_language" class="kt-select basic-single">
                                            <option value="" selected>--</option>
                                            <option value="en" {{ old('preferred_language') == 'en' ? 'selected' : '' }}>
                                                {{ __('main.english') }}</option>
                                            <option value="ar" {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>
                                                {{ __('main.arabic') }}</option>
                                        </select>
                                        @error('preferred_language')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Timezone --}}
                                    @include('components.selects.timezone')

                                    <!-- Button Display Mode -->
                                    <div class="">
                                        <label for="button_display_mode" class="kt-label mb-2">{{ __('main.button_display_mode') }}</label>
                                        <select name="button_display_mode" id="button_display_mode" class="kt-select basic-single">
                                            <option value="" disabled selected></option>
                                            <option value="icon" {{ old('button_display_mode') == 'icon' ? 'selected' : '' }}>
                                                {{ __('main.icon') }}
                                            </option>
                                            <option value="text" {{ old('button_display_mode') == 'text' ? 'selected' : '' }}>
                                                {{ __('main.text') }}
                                            </option>
                                            <option value="both" {{ old('button_display_mode') == 'both' ? 'selected' : '' }}>
                                                {{ __('main.both') }}
                                            </option>
                                        </select>
                                        @error('button_display_mode')
                                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- User Flags -->
                                <div class="flex flex-wrap gap-10 mb-4">
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_active" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'is_active',
                                            'id' => 'is_active',
                                            'value' => '1',
                                            'checked' => 1,
                                            'label' => __('main.is_active'),
                                        ])
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_verified" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'is_verified',
                                            'id' => 'is_verified',
                                            'value' => '1',
                                            'label' => __('main.is_verified'),
                                        ])
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="force_password_change" value="0">
                                        @include('components.elements.checkbox-button', [
                                            'name' => 'force_password_change',
                                            'id' => 'force_password_change',
                                            'value' => '1',
                                            'label' => __('main.force_password_change'),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preferences -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'preferences',
                            'value' => old('preferences'),
                        ])

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'column' => 'notes',
                            'value' => old('notes'),
                        ])

                        <!-- Save Submit Buttons -->
                        @include('components.elements.save-submit', ['models' => 'dashboard.core.users', 'model' => 'user'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
