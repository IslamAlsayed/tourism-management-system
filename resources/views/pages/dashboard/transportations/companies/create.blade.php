@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.transportations-company')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.transportations-company')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.transportations-company')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportations.companies.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.companies')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \App\Models\Region::count() > 0,
                    'route' => route('regions.index'),
                    'label' => __('main.regions'),
                ],
                [
                    'condition' => \App\Models\Subregion::count() > 0,
                    'route' => route('subregions.index'),
                    'label' => __('main.subregions'),
                ],
                [
                    'condition' => \App\Models\Country::count() > 0,
                    'route' => route('countries.index'),
                    'label' => __('main.countries'),
                ],
                [
                    'condition' => \App\Models\State::count() > 0,
                    'route' => route('states.index'),
                    'label' => __('main.states'),
                ],
                [
                    'condition' => \App\Models\City::count() > 0,
                    'route' => route('cities.index'),
                    'label' => __('main.cities'),
                ],
            ],
        ])
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('transportations.companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                {{-- Transportation Company Photo --}}
                @include('components.input-image', [
                    'column' => 'transportations-company',
                    'columnName' => 'photo',
                ])

                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        {{-- Regions [region, subregion, country, state, city] --}}
                        <livewire:regions.location-select-base />

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            {{-- Currency --}}
                            @include('components.selects.currency')

                            <!-- Street -->
                            <div class="align-self-end">
                                <label for="street" class="kt-label">{{ __('main.street') }}</label>
                                <input type="text" name="street" id="street" class="kt-input h-[45px]" value="{{ old('street') }}" placeholder="Enter street">
                                @error('street')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Box -->
                            <div class="align-self-end">
                                <label for="box" class="kt-label">{{ __('main.box') }}</label>
                                <input type="text" name="box" id="box" class="kt-input h-[45px]" value="{{ old('box') }}" placeholder="Enter box">
                                @error('box')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Postal Code --}}
                            <div>
                                <label for="postal_code" class="kt-label mb-2">{{ __('main.postal_code') }}</label>
                                <input type="text" name="postal_code" id="postal_code" class="kt-input h-[45px]" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Latitude -->
                            <div class="align-self-end">
                                <label for="latitude" class="kt-label">{{ __('main.latitude') }}</label>
                                <input type="number" name="latitude" id="latitude" step="0.0000001" class="kt-input h-[45px]" value="{{ old('latitude') }}" placeholder="e.g., 31.2001">
                                @error('latitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="align-self-end">
                                <label for="longitude" class="kt-label">{{ __('main.longitude') }}</label>
                                <input type="number" name="longitude" id="longitude" step="0.0000001" class="kt-input h-[45px]" value="{{ old('longitude') }}" placeholder="e.g., 29.9187">
                                @error('longitude')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transportation Company Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.transportations-company')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label required">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Code --}}
                            <div>
                                <label for="code" class="kt-label required mb-2">{{ __('main.code') }}</label>
                                <div class="relative">
                                    <input type="text" name="code" id="code" class="kt-input h-[45px] pr-10" value="{{ old('code', fake()->numerify('TC-#####')) }}" required readonly>
                                    <button type="button" toggle-button onclick="window.generateCode('code', 'TC-',5)"
                                        class="absolute top-1/2 -translate-y-1/2 text-primary cursor-pointer refresh-code refresh-code">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="align-self-end">
                                <label for="rating" class="kt-label mb-2">{{ __('main.rating') }}</label>
                                <select name="rating" id="rating" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                            {{ $i . ' ' . ($i > 1 ? __('main.rating') : __('main.star')) }}</option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => old('description'),
                            'classes' => 'mb-4',
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => old('notes'),
                        ])
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.contact')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid lg:grid-cols-2 gap-6 items-end">
                            <!-- Email -->
                            <div class="align-self-end">
                                <label for="email" class="kt-label">{{ __('main.email') }}</label>
                                <input type="email" name="email" id="email" class="kt-input h-[45px]" value="{{ old('email') }}" placeholder="info@accommodation.com">
                                @error('email')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="align-self-end">
                                <label for="phone" class="kt-label">{{ __('main.phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="kt-input h-[45px]" value="{{ old('phone') }}" placeholder="+1234567890">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="align-self-end">
                                <label for="mobile" class="kt-label">{{ __('main.mobile') }}</label>
                                <input type="tel" name="mobile" id="mobile" class="kt-input h-[45px]" value="{{ old('mobile') }}" placeholder="+1234567890">
                                @error('mobile')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- fax -->
                            <div class="align-self-end">
                                <label for="fax" class="kt-label">{{ __('main.fax') }}</label>
                                <input type="tel" name="fax" id="fax" class="kt-input h-[45px]" value="{{ old('fax') }}" placeholder="+1234567890">
                                @error('fax')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="align-self-end">
                                <label for="website" class="kt-label">{{ __('main.website') }}</label>
                                <input type="url" name="website" id="website" class="kt-input h-[45px]" value="{{ old('website') }}" placeholder="https://www.transportation.com">
                                @error('website')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.active'),
                        ])
                    </div>
                </div>

                {{-- Vehicles Type Information --}}
                <livewire:morphic-forms.vehicle-type-form />

                {{-- Seasons Information --}}
                <livewire:morphic-forms.season-form />

                {{-- Supplements Information --}}
                <livewire:morphic-forms.supplement-form />

                {{-- Save Buttons --}}
                @include('components.elements.save-submit', [
                    'models' => 'transportations.companies',
                    'model' => 'company',
                ])
            </div>
        </form>
    </div>
@endsection
