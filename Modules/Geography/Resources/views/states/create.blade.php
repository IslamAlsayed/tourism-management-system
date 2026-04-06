@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.state')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.state')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.state')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.states.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.states')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Geography\Entities\Country::count() > 0,
                    'route' => route('dashboard.geography.countries.create'),
                    'label' => __('main.countries_'),
                ],
            ],
        ])
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.geography.states.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Location Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.location')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {{-- Regions [country, city] --}}
                            @livewire('geography::livewire.regions.location-to-state')

                            <!-- Latitude -->
                            @include('components.inputs.latitude')

                            <!-- Longitude -->
                            @include('components.inputs.longitude')
                        </div>
                    </div>
                </div>

                <!-- State Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.state')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- State Name (English) -->
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Name (Arabic) -->
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- FIPS Code -->
                            <div>
                                <label for="fips_code" class="kt-label mb-2">{{ __('main.fips_code') }}</label>
                                <input type="text" name="fips_code" id="fips_code" class="kt-input h-[45px]" maxLength="2" value="{{ old('fips_code') }}">
                                @error('fips_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 2) -->
                            <div>
                                <label for="iso2" class="kt-label required mb-2">{{ __('main.iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" minlength="2" maxlength="2" class="kt-input h-[45px]" required
                                    value="{{ old('iso2') }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 3) -->
                            <div>
                                <label for="iso3" class="kt-label required mb-2">{{ __('main.iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" minlength="3" maxlength="3" class="kt-input h-[45px]" required
                                    value="{{ old('iso3') }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" value="{{ old('type') }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Level -->
                            <div>
                                <label for="level" class="kt-label mb-2">{{ __('main.level') }}</label>
                                <input type="number" name="level" id="level" class="kt-input h-[45px]" minLength="1" value="{{ old('level') }}">
                                @error('level')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.media')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Photo -->
                            <div>
                                <label for="photo" class="kt-label">{{ __('main.photo') }}</label>
                                <div class="dropzone mt-2 border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-primary transition-colors cursor-pointer"
                                    data-input="photo">
                                    <i class="far fa-cloud-arrow-up text-5xl text-gray-600"></i>
                                    <p class="mt-4">{{ __('main.click_or_drag_image_here') }}</p>
                                </div>
                                <input type="file" id="photo" name="photo" accept="image/*" hidden>
                                <div id="preview-photo" class="hidden flex flex-wrap gap-4 mt-6"></div>
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

                <!-- Is active -->
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
                        <input type="hidden" name="is_independent" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_independent',
                            'id' => 'is_independent',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.is_independent'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_developed" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_developed',
                            'id' => 'is_developed',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.is_developed'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_landlocked" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_landlocked',
                            'id' => 'is_landlocked',
                            'value' => '1',
                            'checked' => 1,
                            'label' => __('main.is_landlocked'),
                        ])
                    </div>
                </div>

                <!-- Save Submit -->
                @include('components.elements.save-submit', ['models' => 'dashboard.geography.states', 'model' => 'state'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('components.scripts.drag-drop-images')
@endpush
