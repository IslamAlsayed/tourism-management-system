@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.visa-requirement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.visa-requirement')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.visa-requirement')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.traveldocuments.visa-requirements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.visa-requirements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.traveldocuments.visa-requirements.store') }}" method="POST">
            @csrf

            <div class="grid gap-4 lg:gap-6">
                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.basic_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Nationality -->
                            @include('components.selects.nationality', [
                                'name' => 'nationality_id',
                            ])

                            <!-- Destination Country -->
                            @include('components.selects.country', [
                                'name' => 'destination_country_id',
                            ])

                            <!-- Crossing Port -->
                            @include('components.selects.crossing-port', [
                                'name' => 'crossing_port_id',
                            ])

                            <!-- Visa Type -->
                            <div class="">
                                <label for="visa_type" class="kt-label required mb-2">{{ __('main.visa_type') }}</label>
                                <select name="visa_type" id="visa_type" class="kt-select basic-single" required>
                                    <option value="none_required" {{ old('visa_type') == 'none_required' ? 'selected' : '' }}>{{ __('main.none_required') }}
                                    </option>
                                    <option value="on_arrival" {{ old('visa_type') == 'on_arrival' ? 'selected' : '' }}>{{ __('main.on_arrival') }}</option>
                                    <option value="e_visa" {{ old('visa_type') == 'e_visa' ? 'selected' : '' }}>{{ __('main.e_visa') }}</option>
                                    <option value="embassy_required" {{ old('visa_type') == 'embassy_required' ? 'selected' : '' }}>
                                        {{ __('main.embassy_required') }}</option>
                                    <option value="transit" {{ old('visa_type') == 'transit' ? 'selected' : '' }}>{{ __('main.transit') }}</option>
                                    <option value="restricted" {{ old('visa_type') == 'restricted' ? 'selected' : '' }}>{{ __('main.restricted') }}</option>
                                </select>
                                @error('visa_type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Visa Category -->
                            <div class="">
                                <label for="visa_category" class="kt-label required mb-2">{{ __('main.visa_category') }}</label>
                                <select name="visa_category" id="visa_category" class="kt-select basic-single" required>
                                    <option value="tourist" {{ old('visa_category') == 'tourist' ? 'selected' : '' }}>{{ __('main.tourist') }}</option>
                                    <option value="business" {{ old('visa_category') == 'business' ? 'selected' : '' }}>{{ __('main.business') }}</option>
                                    <option value="medical" {{ old('visa_category') == 'medical' ? 'selected' : '' }}>{{ __('main.medical') }}</option>
                                    <option value="student" {{ old('visa_category') == 'student' ? 'selected' : '' }}>{{ __('main.student') }}</option>
                                    <option value="work" {{ old('visa_category') == 'work' ? 'selected' : '' }}>{{ __('main.work') }}</option>
                                    <option value="transit" {{ old('visa_category') == 'transit' ? 'selected' : '' }}>{{ __('main.transit') }}</option>
                                </select>
                                @error('visa_category')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fees and Duration -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.fees_and_duration') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Visa Fee -->
                            <div class="">
                                <label for="visa_fee" class="kt-label mb-2">{{ __('main.visa_fee') }}</label>
                                <input type="number" step="0.01" min="0" name="visa_fee" id="visa_fee" class="kt-input h-[45px]"
                                    value="{{ old('visa_fee', 0) }}">
                                @error('visa_fee')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Visa Fee Currency -->
                            @include('components.selects.currency', [
                                'name' => 'visa_fee_currency_id',
                            ])

                            <!-- Max Stay Days -->
                            <div class="">
                                <label for="max_stay_days" class="kt-label mb-2">{{ __('main.max_stay_days') }}</label>
                                <input type="number" min="0" name="max_stay_days" id="max_stay_days" class="kt-input h-[45px]"
                                    value="{{ old('max_stay_days', 30) }}">
                                @error('max_stay_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Visa Validity Days -->
                            <div class="">
                                <label for="visa_validity_days" class="kt-label mb-2">{{ __('main.visa_validity_days') }}</label>
                                <input type="number" min="0" name="visa_validity_days" id="visa_validity_days" class="kt-input h-[45px]"
                                    value="{{ old('visa_validity_days', 30) }}">
                                @error('visa_validity_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Departure Tax -->
                            <div class="">
                                <label for="departure_tax" class="kt-label mb-2">{{ __('main.departure_tax') }}</label>
                                <input type="number" step="0.01" min="0" name="departure_tax" id="departure_tax" class="kt-input h-[45px]"
                                    value="{{ old('departure_tax', 0) }}">
                                @error('departure_tax')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Departure Tax Currency -->
                            @include('components.selects.currency', [
                                'name' => 'departure_tax_currency_id',
                            ])

                            <!-- Processing Time Days -->
                            <div class="">
                                <label for="processing_time_days" class="kt-label mb-2">{{ __('main.processing_time_days') }}</label>
                                <input type="number" min="0" name="processing_time_days" id="processing_time_days" class="kt-input h-[45px]"
                                    value="{{ old('processing_time_days', 0) }}">
                                @error('processing_time_days')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Links and URLs -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.links') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Application URL -->
                            <div class="">
                                <label for="application_url" class="kt-label mb-2">{{ __('main.application_url') }}</label>
                                <input type="url" name="application_url" id="application_url" class="kt-input h-[45px]"
                                    value="{{ old('application_url') }}" placeholder="https://...">
                                @error('application_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Official Source URL -->
                            <div class="">
                                <label for="official_source_url" class="kt-label mb-2">{{ __('main.official_source_url') }}</label>
                                <input type="url" name="official_source_url" id="official_source_url" class="kt-input h-[45px]"
                                    value="{{ old('official_source_url') }}" placeholder="https://...">
                                @error('official_source_url')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validity Period -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.validity_period') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Effective From -->
                            <div class="">
                                <label for="effective_from" class="kt-label mb-2">{{ __('main.effective_from') }}</label>
                                <input type="date" name="effective_from" id="effective_from" class="kt-input h-[45px]" value="{{ old('effective_from') }}">
                                @error('effective_from')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Effective Until -->
                            <div class="">
                                <label for="effective_until" class="kt-label mb-2">{{ __('main.effective_until') }}</label>
                                <input type="date" name="effective_until" id="effective_until" class="kt-input h-[45px]"
                                    value="{{ old('effective_until') }}">
                                @error('effective_until')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => old('description'),
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => old('notes'),
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
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
                        <input type="hidden" name="is_restricted" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_restricted',
                            'id' => 'is_restricted',
                            'value' => '1',
                            'label' => __('main.is_restricted'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="can_issue_at_port" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'can_issue_at_port',
                            'id' => 'can_issue_at_port',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.can_issue_at_port'),
                        ])
                    </div>
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', [
                    'models' => 'dashboard.traveldocuments.visa-requirements',
                    'model' => 'visa-requirement',
                ])
            </div>
        </form>
    </div>
@endsection
