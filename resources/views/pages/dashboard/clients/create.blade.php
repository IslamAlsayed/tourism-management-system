@extends('layouts.master')

@section('title', __('main.add_type', ['type' => __('main.client')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_type', ['type' => __('main.client')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_type_description', ['type' => __('main.client')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('clients.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.clients')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-4 lg:gap-6">
            <!-- Client Information -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.client')]) }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <form class="space-y-6" method="POST" action="{{ route('clients.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo -->
                        @include('components.input-image', [
                            'column' => 'client',
                            'columnName' => 'photo',
                        ])

                        <!-- Client Type -->
                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <div class="">
                                <label for="client_type" class="kt-label required mb-2">{{ __('main.client_type') }}</label>
                                <select name="client_type" id="client_type" class="kt-input h-[45px]" required>
                                    <option value="">{{ __('main.select_client_type') }}</option>
                                    <option value="individual" {{ old('client_type') == 'individual' ? 'selected' : '' }}>
                                        {{ __('main.individual') }}
                                    </option>
                                    <option value="corporate" {{ old('client_type') == 'corporate' ? 'selected' : '' }}>
                                        {{ __('main.corporate') }}
                                    </option>
                                </select>
                                @error('client_type')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="client_status"
                                    class="kt-label required mb-2">{{ __('main.client_status') }}</label>
                                <select name="client_status" id="client_status" class="kt-input h-[45px]" required>
                                    <option value="">{{ __('main.select_client_status') }}</option>
                                    <option value="active"
                                        {{ old('client_status', 'active') == 'active' ? 'selected' : '' }}>
                                        {{ __('main.active') }}
                                    </option>
                                    <option value="inactive" {{ old('client_status') == 'inactive' ? 'selected' : '' }}>
                                        {{ __('main.inactive') }}
                                    </option>
                                    <option value="blacklisted"
                                        {{ old('client_status') == 'blacklisted' ? 'selected' : '' }}>
                                        {{ __('main.blacklisted') }}
                                    </option>
                                </select>
                                @error('client_status')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-3 gap-6 mb-4">
                            <!-- First Name -->
                            <div class="">
                                <label for="first_name" class="kt-label required mb-2">{{ __('main.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]"
                                    value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="">
                                <label for="last_name" class="kt-label required mb-2">{{ __('main.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="">
                                <label for="email" class="kt-label required mb-2">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Phone -->
                                    <div class="">
                                        <label for="phone" class="kt-label mb-2">{{ __('main.phone') }}</label>
                                        <input type="text" name="phone" id="phone" class="kt-input h-[45px]"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile -->
                                    <div class="">
                                        <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                        <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                            value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="">
                                        <label for="whatsapp" class="kt-label mb-2">{{ __('main.whatsapp') }}</label>
                                        <input type="text" name="whatsapp" id="whatsapp" class="kt-input h-[45px]"
                                            value="{{ old('whatsapp') }}">
                                        @error('whatsapp')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-3 gap-6">
                                    <!-- Address -->
                                    <div class="">
                                        <label for="address" class="kt-label mb-2">{{ __('main.address') }}</label>
                                        <input type="text" name="address" id="address" class="kt-input h-[45px]"
                                            value="{{ old('address') }}">
                                        @error('address')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="">
                                        <label for="city" class="kt-label mb-2">{{ __('main.city') }}</label>
                                        <input type="text" name="city" id="city" class="kt-input h-[45px]"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div class="">
                                        <label for="country" class="kt-label mb-2">{{ __('main.country') }}</label>
                                        <input type="text" name="country" id="country" class="kt-input h-[45px]"
                                            value="{{ old('country') }}">
                                        @error('country')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Company Information (for corporate clients) -->
                        <div class="kt-card mb-4" id="company-info" style="display: none;">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.company_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-2 gap-6 mb-4">
                                    <!-- Company Name -->
                                    <div class="">
                                        <label for="company_name"
                                            class="kt-label mb-2">{{ __('main.company_name') }}</label>
                                        <input type="text" name="company_name" id="company_name"
                                            class="kt-input h-[45px]" value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Company Email -->
                                    <div class="">
                                        <label for="company_email"
                                            class="kt-label mb-2">{{ __('main.company_email') }}</label>
                                        <input type="email" name="company_email" id="company_email"
                                            class="kt-input h-[45px]" value="{{ old('company_email') }}">
                                        @error('company_email')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-3 gap-6 mb-4">
                                    <!-- Tax Number -->
                                    <div class="">
                                        <label for="tax_number" class="kt-label mb-2">{{ __('main.tax_number') }}</label>
                                        <input type="text" name="tax_number" id="tax_number"
                                            class="kt-input h-[45px]" value="{{ old('tax_number') }}">
                                        @error('tax_number')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Commercial Registration -->
                                    <div class="">
                                        <label for="commercial_registration"
                                            class="kt-label mb-2">{{ __('main.commercial_registration') }}</label>
                                        <input type="text" name="commercial_registration" id="commercial_registration"
                                            class="kt-input h-[45px]" value="{{ old('commercial_registration') }}">
                                        @error('commercial_registration')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Company Phone -->
                                    <div class="">
                                        <label for="company_phone"
                                            class="kt-label mb-2">{{ __('main.company_phone') }}</label>
                                        <input type="text" name="company_phone" id="company_phone"
                                            class="kt-input h-[45px]" value="{{ old('company_phone') }}">
                                        @error('company_phone')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Company Address -->
                                <div class="">
                                    <label for="company_address"
                                        class="kt-label mb-2">{{ __('main.company_address') }}</label>
                                    <textarea name="company_address" id="company_address" class="kt-input" rows="2">{{ old('company_address') }}</textarea>
                                    @error('company_address')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information (for individual clients) -->
                        <div class="kt-card mb-4" id="personal-info">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.personal_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6">
                                    <!-- Nationality -->
                                    <div class="">
                                        <label for="nationality_id"
                                            class="kt-label mb-2">{{ __('main.nationality') }}</label>
                                        <select name="nationality_id" id="nationality_id" class="kt-input h-[45px]"
                                            special-search>
                                            <option value="">{{ __('main.select_nationality') }}</option>
                                            @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}"
                                                    {{ old('nationality_id') == $nationality->id ? 'selected' : '' }}>
                                                    {{ $nationality->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nationality_id')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Passport Number -->
                                    <div class="">
                                        <label for="passport_number"
                                            class="kt-label mb-2">{{ __('main.passport_number') }}</label>
                                        <input type="text" name="passport_number" id="passport_number"
                                            class="kt-input h-[45px]" value="{{ old('passport_number') }}">
                                        @error('passport_number')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- ID Number -->
                                    <div class="">
                                        <label for="id_number" class="kt-label mb-2">{{ __('main.id_number') }}</label>
                                        <input type="text" name="id_number" id="id_number" class="kt-input h-[45px]"
                                            value="{{ old('id_number') }}">
                                        @error('id_number')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-2 gap-6 mt-4">
                                    <!-- Birth Date -->
                                    <div class="">
                                        <label for="birth_date" class="kt-label mb-2">{{ __('main.birth_date') }}</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="kt-input h-[45px]" value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="">
                                        <label for="gender" class="kt-label mb-2">{{ __('main.gender') }}</label>
                                        <select name="gender" id="gender" class="kt-input h-[45px]">
                                            <option value="">{{ __('main.select_gender') }}</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                {{ __('main.male') }}
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                {{ __('main.female') }}
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.financial_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <div class="grid lg:grid-cols-3 gap-6">
                                    <!-- Credit Limit -->
                                    <div class="">
                                        <label for="credit_limit"
                                            class="kt-label mb-2">{{ __('main.credit_limit') }}</label>
                                        <input type="number" name="credit_limit" id="credit_limit"
                                            class="kt-input h-[45px]" value="{{ old('credit_limit', 0) }}"
                                            step="0.01" min="0">
                                        @error('credit_limit')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Payment Terms (days) -->
                                    <div class="">
                                        <label for="payment_terms"
                                            class="kt-label mb-2">{{ __('main.payment_terms') }}</label>
                                        <input type="number" name="payment_terms" id="payment_terms"
                                            class="kt-input h-[45px]" value="{{ old('payment_terms', 30) }}"
                                            min="0">
                                        @error('payment_terms')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Discount Rate -->
                                    <div class="">
                                        <label for="discount_rate"
                                            class="kt-label mb-2">{{ __('main.discount_rate') }}</label>
                                        <input type="number" name="discount_rate" id="discount_rate"
                                            class="kt-input h-[45px]" value="{{ old('discount_rate', 0) }}"
                                            step="0.01" min="0" max="100">
                                        @error('discount_rate')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="kt-card mb-4">
                            <div class="kt-card-header">
                                <h3 class="kt-card-title">{{ __('main.additional_information') }}</h3>
                            </div>
                            <div class="kt-card-body p-4">
                                <!-- Preferred Language -->
                                <div class="grid lg:grid-cols-2 gap-6 mb-4">
                                    <div class="">
                                        <label for="preferred_language"
                                            class="kt-label mb-2">{{ __('main.preferred_language') }}</label>
                                        <select name="preferred_language" id="preferred_language"
                                            class="kt-select h-[45px]" special-search>
                                            <option value="">{{ __('main.select_language') }}</option>
                                            <option value="en"
                                                {{ old('preferred_language') == 'en' ? 'selected' : '' }}>
                                                {{ __('main.english') }}
                                            </option>
                                            <option value="ar"
                                                {{ old('preferred_language') == 'ar' ? 'selected' : '' }}>
                                                {{ __('main.arabic') }}
                                            </option>
                                        </select>
                                        @error('preferred_language')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Client Flags -->
                                <div class="grid lg:grid-cols-2 gap-6 mb-4">
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" id="is_active" class="kt-checkbox"
                                            value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                        <label for="is_active" class="kt-label mb-0">{{ __('main.is_active') }}</label>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="is_verified" value="0">
                                        <input type="checkbox" name="is_verified" id="is_verified" class="kt-checkbox"
                                            value="1" {{ old('is_verified') ? 'checked' : '' }}>
                                        <label for="is_verified"
                                            class="kt-label mb-0">{{ __('main.is_verified') }}</label>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="mb-4">
                                    <label for="notes" class="kt-label mb-2">{{ __('main.notes') }}</label>
                                    <input id="notes" type="hidden" name="notes" value="{{ old('notes') }}">
                                    <trix-editor input="notes"></trix-editor>
                                    @error('notes')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex items-center gap-4 pt-4">
                                    <button type="submit" class="kt-btn kt-btn-primary">
                                        <i class="ki-filled ki-check text-sm me-2"></i>
                                        {{ __('main.save_type', ['type' => __('main.client')]) }}
                                    </button>
                                    <button type="submit" name="save_and_add" value="1"
                                        class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                        <i class="ki-filled ki-plus text-sm me-2"></i>
                                        {{ __('main.save_and_add_another') }}
                                    </button>
                                    <a href="{{ route('clients.index') }}" class="kt-btn kt-btn-outline">
                                        {{ __('main.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientTypeSelect = document.getElementById('client_type');
            const companyInfo = document.getElementById('company-info');
            const personalInfo = document.getElementById('personal-info');

            function toggleSections() {
                if (clientTypeSelect.value === 'corporate') {
                    companyInfo.style.display = 'block';
                } else {
                    companyInfo.style.display = 'none';
                }
            }

            clientTypeSelect.addEventListener('change', toggleSections);
            toggleSections(); // Initial call
        });
    </script>
    @endpush --}}
