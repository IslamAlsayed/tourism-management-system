@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.transportation-vehicle-type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.transportation-vehicle-type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.transportation-vehicle-type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('transportation.vehicle-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.transportation-vehicle-types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('transportation.vehicle-types.update', $vehicleType->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <!-- Transportation Vehicle Type Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.vehicle-type')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Transportation Company -->
                            <div class="align-self-end">
                                <label for="company_id" class="kt-label">{{ __('main.company') }}</label>
                                <select name="company_id" id="company_id" class="kt-select basic-single">
                                    <option value="" disabled selected>--</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $vehicleType->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }} ({{ $company->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $vehicleType->name }}">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $vehicleType->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Min Capacity -->
                            <div class="">
                                <label for="min_capacity" class="kt-label mb-2">{{ __('main.min_capacity') }}</label>
                                <input type="number" name="min_capacity" id="min_capacity" class="kt-input h-[45px]"
                                    value="{{ $vehicleType->min_capacity }}">
                                @error('min_capacity')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Max Capacity -->
                            <div class="">
                                <label for="max_capacity" class="kt-label mb-2">{{ __('main.max_capacity') }}</label>
                                <input type="number" name="max_capacity" id="max_capacity" class="kt-input h-[45px]"
                                    value="{{ $vehicleType->max_capacity }}">
                                @error('max_capacity')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'description',
                    'value' => $vehicleType->description,
                ])

                {{-- Notes --}}
                @include('components.elements.input-text-editor', [
                    'name' => 'notes',
                    'value' => $vehicleType->notes,
                ])

                <div class="flex flex-wrap" style="gap: 10px 40px;">
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_active',
                            'id' => 'is_active',
                            'value' => '1',
                            'checked' => $vehicleType->is_active,
                            'label' => __('main.active'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="has_luggage" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'has_luggage',
                            'id' => 'has_luggage',
                            'value' => '1',
                            'checked' => $vehicleType->has_luggage,
                            'label' => __('main.has_luggage'),
                        ])
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_air_conditioning" value="0">
                        @include('components.elements.checkbox-button', [
                            'name' => 'is_air_conditioning',
                            'id' => 'is_air_conditioning',
                            'value' => '1',
                            'checked' => $vehicleType->is_air_conditioning,
                            'label' => __('main.is_air_conditioning'),
                        ])
                    </div>
                </div>

                {{-- Update Buttons --}}
                @include('components.elements.update-submit', [
                    'models' => 'transportation.vehicle-types',
                    'model' => 'vehicle-type',
                ])
            </div>
        </form>
    </div>
@endsection
