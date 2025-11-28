@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.client')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.client')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.client')]) }}
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
        <div class="kt-card p-6">
            <form class="space-y-6" method="POST" action="{{ route('clients.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Personal Information --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.personal_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- First Name --}}
                            <div>
                                <label for="first_name" class="kt-label required mb-2">{{ __('main.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" class="kt-input h-[45px]"
                                    value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label for="last_name" class="kt-label required mb-2">{{ __('main.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" class="kt-input h-[45px]"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Client Code --}}
                            <div>
                                <label for="client_code"
                                    class="kt-label required mb-2">{{ __('main.client_code') }}</label>
                                <div class="relative">
                                    <input type="text" name="client_code" id="client_code"
                                        class="kt-input h-[45px] pr-10"
                                        value="{{ old('client_code', fake()->numerify('C-#####')) }}" required readonly>

                                    <button type="button" onclick="generateNewClientCode()" toggle-button
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-primary cursor-pointer hover:text-gray-700">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('client_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Gender --}}
                            <div>
                                <label for="gender" class="kt-label mb-2">{{ __('main.gender') }}</label>
                                <select name="gender" id="gender" class="kt-input h-[45px]" special-search>
                                    <option value="">--</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                        {{ __('main.male') }}
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                        {{ __('main.female') }}
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nationality --}}
                            <div>
                                <label for="nationality_id" class="kt-label mb-2">{{ __('main.nationality') }}</label>
                                <select name="nationality_id" id="nationality_id" class="kt-input h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}"
                                            {{ old('nationality_id') == $nationality->id ? 'selected' : '' }}>
                                            {{ getCurrentLocale() == 'ar' ? $nationality->name_ar : $nationality->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nationality_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Birth Date --}}
                            <div>
                                <label for="birth_date" class="kt-label mb-2">{{ __('main.birth_date') }}</label>
                                <input type="date" name="birth_date" id="birth_date" class="kt-input h-[45px]"
                                    value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Passport Information --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.passport_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Passport Number --}}
                            <div>
                                <label for="passport_number" class="kt-label mb-2">{{ __('main.passport_number') }}</label>
                                <input type="text" name="passport_number" id="passport_number" class="kt-input h-[45px]"
                                    value="{{ old('passport_number') }}">
                                @error('passport_number')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Passport Issue Date --}}
                            <div>
                                <label for="passport_issue_date"
                                    class="kt-label mb-2">{{ __('main.passport_issue_date') }}</label>
                                <input type="date" name="passport_issue_date" id="passport_issue_date"
                                    class="kt-input h-[45px]" value="{{ old('passport_issue_date') }}">
                                @error('passport_issue_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Passport Expiry Date --}}
                            <div>
                                <label for="passport_expiry_date"
                                    class="kt-label mb-2">{{ __('main.passport_expiry_date') }}</label>
                                <input type="date" name="passport_expiry_date" id="passport_expiry_date"
                                    class="kt-input h-[45px]" value="{{ old('passport_expiry_date') }}">
                                @error('passport_expiry_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.contact_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Email Addresses --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Primary Email --}}
                            <div>
                                <label for="email_primary"
                                    class="kt-label required mb-2">{{ __('main.email_primary') }}</label>
                                <input type="email" name="email_primary" id="email_primary" class="kt-input h-[45px]"
                                    value="{{ old('email_primary') }}" required>
                                @error('email_primary')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Personal Email --}}
                            <div>
                                <label for="personal_email" class="kt-label mb-2">{{ __('main.personal_email') }}</label>
                                <input type="email" name="personal_email" id="personal_email"
                                    class="kt-input h-[45px]" value="{{ old('personal_email') }}">
                                @error('personal_email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Work Email --}}
                            <div>
                                <label for="work_email" class="kt-label mb-2">{{ __('main.work_email') }}</label>
                                <input type="email" name="work_email" id="work_email" class="kt-input h-[45px]"
                                    value="{{ old('work_email') }}">
                                @error('work_email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Secondary Email --}}
                            <div>
                                <label for="secondary_email"
                                    class="kt-label mb-2">{{ __('main.secondary_email') }}</label>
                                <input type="email" name="secondary_email" id="secondary_email"
                                    class="kt-input h-[45px]" value="{{ old('secondary_email') }}">
                                @error('secondary_email')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone Numbers --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Primary Phone --}}
                            <div>
                                <label for="primary_phone"
                                    class="kt-label required mb-2">{{ __('main.primary_phone') }}</label>
                                <input type="text" name="primary_phone" id="primary_phone" class="kt-input h-[45px]"
                                    maxLength="14" value="{{ old('primary_phone') }}" required>
                                @error('primary_phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Secondary Phone --}}
                            <div>
                                <label for="secondary_phone"
                                    class="kt-label mb-2">{{ __('main.secondary_phone') }}</label>
                                <input type="text" name="secondary_phone" id="secondary_phone"
                                    class="kt-input h-[45px]" maxLength="14" value="{{ old('secondary_phone') }}">
                                @error('secondary_phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Mobile --}}
                            <div>
                                <label for="mobile" class="kt-label mb-2">{{ __('main.mobile') }}</label>
                                <input type="text" name="mobile" id="mobile" class="kt-input h-[45px]"
                                    maxLength="14" value="{{ old('mobile') }}">
                                @error('mobile')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Home Phone --}}
                            <div>
                                <label for="home_phone" class="kt-label mb-2">{{ __('main.home_phone') }}</label>
                                <input type="text" name="home_phone" id="home_phone" class="kt-input h-[45px]"
                                    maxLength="14" value="{{ old('home_phone') }}">
                                @error('home_phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Work Phone --}}
                            <div>
                                <label for="work_phone" class="kt-label mb-2">{{ __('main.work_phone') }}</label>
                                <input type="text" name="work_phone" id="work_phone" class="kt-input h-[45px]"
                                    maxLength="14" value="{{ old('work_phone') }}">
                                @error('work_phone')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Work Phone Extension --}}
                            <div>
                                <label for="work_phone_ext" class="kt-label mb-2">{{ __('main.work_phone_ext') }}</label>
                                <input type="text" name="work_phone_ext" id="work_phone_ext" maxLength="14"
                                    class="kt-input h-[45px]" value="{{ old('work_phone_ext') }}">
                                @error('work_phone_ext')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fax Number --}}
                            <div>
                                <label for="fax_number" class="kt-label mb-2">{{ __('main.fax_number') }}</label>
                                <input type="text" name="fax_number" id="fax_number" class="kt-input h-[45px]"
                                    maxLength="14" value="{{ old('fax_number') }}">
                                @error('fax_number')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Location Information --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.location_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Regions [region, subregion, country, state, city] --}}
                            @include('components.regions.create', [
                                'levels' => ['region', 'subregion', 'country', 'state', 'city'],
                                'multiple' => false,
                            ])
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Box --}}
                            <div>
                                <label for="box" class="kt-label mb-2">{{ __('main.box') }}</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]"
                                    value="{{ old('box') }}">
                                @error('box')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Postal Code --}}
                            <div>
                                <label for="postal_code" class="kt-label mb-2">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]"
                                    value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-4">
                            {{-- Street Address --}}
                            @include('components.elements.input-text-editor', [
                                'column' => 'street_address',
                                'value' => old('street_address'),
                            ])

                            {{-- Address Line 2 --}}
                            @include('components.elements.input-text-editor', [
                                'column' => 'address_line_2',
                                'value' => old('address_line_2'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Company/Business Information --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.company_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Company Name --}}
                            <div>
                                <label for="company_name" class="kt-label mb-2">{{ __('main.company_name') }}</label>
                                <input type="text" name="company_name" id="company_name" class="kt-input h-[45px]"
                                    value="{{ old('company_name') }}">
                                @error('company_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Job Title --}}
                            <div>
                                <label for="job_title" class="kt-label mb-2">{{ __('main.job_title') }}</label>
                                <input type="text" name="job_title" id="job_title" class="kt-input h-[45px]"
                                    value="{{ old('job_title') }}">
                                @error('job_title')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sector --}}
                            <div>
                                <label for="sector" class="kt-label mb-2">{{ __('main.sector') }}</label>
                                <input type="text" name="sector" id="sector" class="kt-input h-[45px]"
                                    value="{{ old('sector') }}">
                                @error('sector')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div>
                                <label for="department" class="kt-label mb-2">{{ __('main.department') }}</label>
                                <input type="text" name="department" id="department" class="kt-input h-[45px]"
                                    value="{{ old('department') }}">
                                @error('department')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Business Type --}}
                            <div>
                                <label for="business_type" class="kt-label mb-2">{{ __('main.business_type') }}</label>
                                <input type="text" name="business_type" id="business_type" class="kt-input h-[45px]"
                                    value="{{ old('business_type') }}">
                                @error('business_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Business Registration Number --}}
                            <div>
                                <label for="business_registration_number"
                                    class="kt-label mb-2">{{ __('main.business_registration_number') }}</label>
                                <input type="text" name="business_registration_number"
                                    id="business_registration_number" class="kt-input h-[45px]"
                                    value="{{ old('business_registration_number') }}">
                                @error('business_registration_number')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tax ID --}}
                            <div>
                                <label for="tax_id" class="kt-label mb-2">{{ __('main.tax_id') }}</label>
                                <input type="text" name="tax_id" id="tax_id" class="kt-input h-[45px]"
                                    value="{{ old('tax_id') }}">
                                @error('tax_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Online Presence --}}
                <div class="kt-card mb-6">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.online_presence') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Website URL --}}
                            <div>
                                <label for="website_url" class="kt-label mb-2">{{ __('main.website_url') }}</label>
                                <input type="url" name="website_url" id="website_url" class="kt-input h-[45px]"
                                    value="{{ old('website_url') }}">
                                @error('website_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LinkedIn URL --}}
                            <div>
                                <label for="linkedin_url" class="kt-label mb-2">{{ __('main.linkedin_url') }}</label>
                                <input type="url" name="linkedin_url" id="linkedin_url" class="kt-input h-[45px]"
                                    value="{{ old('linkedin_url') }}">
                                @error('linkedin_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Settings --}}
                <div class="kt-card mb-4">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.additional_settings') }}</h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            {{-- Status --}}
                            <div>
                                <label for="status" class="kt-label mb-2">{{ __('main.status') }}</label>
                                <select name="status" id="status" class="kt-input h-[45px]">
                                    <option value="">--</option>
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        {{ __('main.active') }}
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        {{ __('main.inactive') }}
                                    </option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                        {{ __('main.pending') }}
                                    </option>
                                    <option value="blacklisted" {{ old('status') == 'blacklisted' ? 'selected' : '' }}>
                                        {{ __('main.blacklisted') }}
                                    </option>
                                </select>
                                @error('status')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div class="">
                                <label for="timezone_id" class="kt-label mb-2">{{ __('main.timezone') }}</label>
                                <select name="timezone_id" id="timezone_id" class="kt-select h-[45px]" special-search>
                                    <option value="">--</option>
                                    @foreach ($timezones as $zone)
                                        <option value="{{ $zone['id'] }}"
                                            {{ old('timezone_id') == $zone['id'] ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? ($zone['name_ar'] ? $zone['name_ar'] . ' ' : '') : ($zone['name'] ? $zone['name'] . ' ' : '') }}({{ $zone['abbreviation'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            {{-- Notes --}}
                            @include('components.elements.input-text-editor', [
                                'column' => 'notes',
                                'value' => old('notes'),
                            ])
                        </div>
                    </div>
                </div>

                <!-- Save Submit Buttons -->
                @include('components.elements.save-submit', ['models' => 'clients'])
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                filterByForeignId("region_id", "subregion", "subregion_id");
                filterByForeignId("subregion_id", "country", "country_id");
                filterByForeignId("country_id", "state", "state_id");
                filterByForeignId("state_id", "city", "city_id");
            }, 500);
        });

        function generateNewClientCode() {
            function getRandomCode() {
                const randomNum = Math.floor(Math.random() * 99999) + 1;
                const paddedNum = String(randomNum).padStart(5, '0');
                return 'C-' + paddedNum;
            }
            document.getElementById('client_code').value = getRandomCode();
        }

        document.getElementById('passport_expiry_date').addEventListener('change', function() {
            const issueDate = document.getElementById('passport_issue_date').value;
            const expiryDate = this.value;

            if (issueDate && expiryDate && new Date(expiryDate) <= new Date(issueDate)) {
                this.value = '';
            }
        });
    </script>
@endpush

@include('components.regions.script-cascading')
