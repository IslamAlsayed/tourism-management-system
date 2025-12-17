@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.supplement')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.supplement')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.supplement')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations-supplements.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.supplements')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form action="{{ route('accommodations-supplements.update', $accommodationSupplement->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">

                <!-- Basic Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                    </div>
                    <div class="kt-card-body p-4 pb-0">
                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Accommodation -->
                            <div class="align-self-end">
                                <label for="accommodation_id" class="kt-label">{{ __('main.accommodation') }}</label>
                                <select name="accommodation_id" id="accommodation_id" class="kt-select basic-single">
                                    <option value="">{{ __('main.select') }}</option>
                                    @foreach ($accommodations as $accommodation)
                                        <option value="{{ $accommodation->id }}"
                                            {{ $accommodationSupplement->accommodation_id == $accommodation->id ? 'selected' : '' }}>
                                            {{ $accommodation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('accommodation_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="align-self-end">
                                <label for="price" class="kt-label">{{ __('main.price') }}</label>
                                <input type="number" name="price" id="price" class="kt-input h-[45px]" step="0.01"
                                    value="{{ $accommodationSupplement->price }}" placeholder="0.00">
                                @error('price')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Type -->
                            <div class="align-self-end">
                                <label for="price_type" class="kt-label">
                                    {{ __('main.price_type') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <select name="price_type" id="price_type" class="kt-select basic-single">
                                    <option value="" disabled selected></option>
                                    <option value="per_person"
                                        {{ $accommodationSupplement->price_type == 'per_person' ? 'selected' : '' }}>
                                        {{ __('main.per_person') }}</option>
                                    <option value="per_room"
                                        {{ $accommodationSupplement->price_type == 'per_room' ? 'selected' : '' }}>
                                        {{ __('main.per_room') }}</option>
                                    <option value="per_night"
                                        {{ $accommodationSupplement->price_type == 'per_night' ? 'selected' : '' }}>
                                        {{ __('main.per_night') }}</option>
                                    <option value="one_time"
                                        {{ $accommodationSupplement->price_type == 'one_time' ? 'selected' : '' }}>
                                        {{ __('main.one_time') }}</option>
                                </select>
                                @error('price_type')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Name -->
                            <div class="align-self-end">
                                <label for="name" class="kt-label">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $accommodationSupplement->name }}" placeholder="Enter supplement name">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Arabic -->
                            <div class="align-self-end">
                                <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $accommodationSupplement->name_ar }}" placeholder="أدخل اسم الإضافة">
                                @error('name_ar')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6 mb-4">
                            <!-- Applicable Date -->
                            <div class="align-self-end">
                                <label for="applicable_date" class="kt-label">
                                    {{ __('main.applicable_date') }}
                                </label>
                                <input type="date" name="applicable_date" id="applicable_date" class="kt-input h-[45px]"
                                    value="{{ $accommodationSupplement->applicable_date?->format('Y-m-d') }}">
                                @error('applicable_date')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="flex gap-6 mb-4">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $accommodationSupplement->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_mandatory" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_mandatory',
                                    'id' => 'is_mandatory',
                                    'value' => '1',
                                    'checked' => $accommodationSupplement->is_mandatory,
                                    'label' => __('main.is_mandatory'),
                                ])
                            </div>
                        </div>

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $accommodationSupplement->notes,
                        ])
                    </div>
                </div>

                <!-- Update Submit Buttons -->
                @include('components.elements.update-submit', ['models' => 'accommodations-supplements'])
            </div>
        </form>
    </div>
@endsection
