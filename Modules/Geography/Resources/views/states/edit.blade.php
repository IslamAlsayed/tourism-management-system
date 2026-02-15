@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.state')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.state')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.state')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.states.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.states')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('dashboard.geography.states.update', $state->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                            @livewire('geography::livewire.regions.location-to-state', ['record' => $state])

                            <!-- Latitude -->
                            @include('components.inputs.latitude', ['record' => $state])

                            <!-- Longitude -->
                            @include('components.inputs.longitude', ['record' => $state])
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
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ $state->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $state->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- FIPS Code -->
                            <div class="">
                                <label for="fips_code" class="kt-label mb-2">{{ __('main.fips_code') }}</label>
                                <input type="text" name="fips_code" id="fips_code" class="kt-input h-[45px]" maxLength="2" value="{{ $state->fips_code }}">
                                @error('fips_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 2) -->
                            <div class="">
                                <label for="iso2" class="kt-label mb-2">{{ __('main.iso2') }}</label>
                                <input type="text" name="iso2" id="iso2" class="kt-input h-[45px]" value="{{ $state->iso2 }}">
                                @error('iso2')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State Code (ISO 3) -->
                            <div class="">
                                <label for="iso3" class="kt-label mb-2">{{ __('main.iso3') }}</label>
                                <input type="text" name="iso3" id="iso3" class="kt-input h-[45px]" value="{{ $state->iso3 }}">
                                @error('iso3')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="">
                                <label for="type" class="kt-label mb-2">{{ __('main.type') }}</label>
                                <input type="text" name="type" id="type" class="kt-input h-[45px]" value="{{ $state->type }}">
                                @error('type')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Level -->
                            <div class="">
                                <label for="level" class="kt-label mb-2">{{ __('main.level') }}</label>
                                <input type="number" name="level" id="level" class="kt-input h-[45px]" minLength="1" value="{{ $state->level }}">
                                @error('level')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Information -->
                @include('components.inputs.photo', ['record' => $state])

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $state->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $state->notes,
                ])

                <!-- Is active -->
                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $state->is_active,
                            'label' => __('main.is_active'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_independent" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_independent',
                            'id' => 'is_independent',
                            'value' => '1',
                            'checked' => $state->is_independent,
                            'label' => __('main.is_independent'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_developed" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_developed',
                            'id' => 'is_developed',
                            'value' => '1',
                            'checked' => $state->is_developed,
                            'label' => __('main.is_developed'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_landlocked" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_landlocked',
                            'id' => 'is_landlocked',
                            'value' => '1',
                            'checked' => $state->is_landlocked,
                            'label' => __('main.is_landlocked'),
                        ])
                    </div>
                </div>

                <!-- Update Submit -->
                @include('components.elements.update-submit', ['models' => 'dashboard.geography.states', 'model' => 'state'])
            </div>
        </form>
    </div>
@endsection
