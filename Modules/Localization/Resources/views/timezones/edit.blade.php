@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.timezone')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.timezone')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.timezone')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.timezones.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.timezones')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.localization.timezones.update', $timezone->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Timezone Name -->
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required value="{{ $timezone->name }}"
                                    placeholder="e.g., Africa/Cairo">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone Name Arabic -->
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ $timezone->name_ar }}" placeholder="مصر">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code -->
                            <div>
                                <label for="country_code" class="kt-label mb-2">{{ __('main.country_code') }}</label>
                                <input type="text" name="country_code" id="country_code" class="kt-input h-[45px]" maxlength="2"
                                    value="{{ $timezone->country_code }}" placeholder="EG">
                                @error('country_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Abbreviation -->
                            <div>
                                <label for="abbreviation" class="kt-label mb-2">{{ __('main.abbreviation') }}</label>
                                <input type="text" name="abbreviation" id="abbreviation" class="kt-input h-[45px]" maxlength="10"
                                    value="{{ $timezone->abbreviation }}" placeholder="EET">
                                @error('abbreviation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Abbreviation DST -->
                            <div>
                                <label for="abbreviation_dst" class="kt-label mb-2">{{ __('main.abbreviation_dst') }}</label>
                                <input type="text" name="abbreviation_dst" id="abbreviation_dst" class="kt-input h-[45px]" maxlength="10"
                                    value="{{ $timezone->abbreviation_dst }}" placeholder="EEST">
                                @error('abbreviation_dst')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GMT Offset Name -->
                            <div>
                                <label for="gmt_offset_name" class="kt-label mb-2">{{ __('main.gmt_offset_name') }}</label>
                                <input type="text" name="gmt_offset_name" id="gmt_offset_name" class="kt-input h-[45px]"
                                    value="{{ $timezone->gmt_offset_name }}" placeholder="GMT+2">
                                @error('gmt_offset_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Offset (in seconds) -->
                            <div>
                                <label for="offset" class="kt-label mb-2">{{ __('main.offset') }}</label>
                                <input type="number" name="offset" id="offset" class="kt-input h-[45px]" value="{{ $timezone->offset }}" placeholder="7200">
                                @error('offset')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Offset DST (in seconds) -->
                            <div>
                                <label for="offset_dst" class="kt-label mb-2">{{ __('main.offset_dst') }}</label>
                                <input type="number" name="offset_dst" id="offset_dst" class="kt-input h-[45px]" value="{{ $timezone->offset_dst }}"
                                    placeholder="10800">
                                @error('offset_dst')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]" value="{{ $timezone->sort_order }}">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => $timezone->description,
                        ])

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $timezone->notes,
                        ])

                        <div class="flex flex-wrap" style="gap: 10px 40px;">
                            <!-- Is Active -->
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $timezone->is_active,
                                    'label' => __('main.active'),
                                ])
                            </div>

                            <!-- Supports DST -->
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="supports_dst" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'supports_dst',
                                    'id' => 'supports_dst',
                                    'value' => '1',
                                    'checked' => $timezone->supports_dst,
                                    'label' => __('main.supports_dst'),
                                ])
                            </div>
                        </div>

                        <!-- Update Submit -->
                        @include('components.elements.update-submit', [
                            'models' => 'dashboard.localization.timezones',
                            'model' => 'timezone',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
