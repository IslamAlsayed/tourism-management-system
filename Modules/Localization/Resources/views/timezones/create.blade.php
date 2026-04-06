@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.timezone')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.timezone')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.timezone')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.timezones.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.timezones')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.localization.timezones.store') }}">
                    @csrf
                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            <!-- Timezone Name -->
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}" placeholder="e.g., Africa/Cairo">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Timezone Name Arabic -->
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ old('name_ar') }}" placeholder="مصر">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country Code -->
                            <div>
                                <label for="country_code" class="kt-label mb-2">{{ __('main.country_code') }}</label>
                                <input type="text" name="country_code" id="country_code" class="kt-input h-[45px]"
                                    maxlength="2" value="{{ old('country_code') }}" placeholder="EG">
                                @error('country_code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Abbreviation -->
                            <div>
                                <label for="abbreviation" class="kt-label mb-2">{{ __('main.abbreviation') }}</label>
                                <input type="text" name="abbreviation" id="abbreviation" class="kt-input h-[45px]"
                                    maxlength="10" value="{{ old('abbreviation') }}" placeholder="EET">
                                @error('abbreviation')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Abbreviation DST -->
                            <div>
                                <label for="abbreviation_dst"
                                    class="kt-label mb-2">{{ __('main.abbreviation_dst') }}</label>
                                <input type="text" name="abbreviation_dst" id="abbreviation_dst"
                                    class="kt-input h-[45px]" maxlength="10" value="{{ old('abbreviation_dst') }}"
                                    placeholder="EEST">
                                @error('abbreviation_dst')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GMT Offset Name -->
                            <div>
                                <label for="gmt_offset_name" class="kt-label mb-2">{{ __('main.gmt_offset_name') }}</label>
                                <input type="text" name="gmt_offset_name" id="gmt_offset_name" class="kt-input h-[45px]"
                                    value="{{ old('gmt_offset_name') }}" placeholder="GMT+2">
                                @error('gmt_offset_name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- GMT Offset Name DST -->
                            <div>
                                <label for="gmt_offset_name_dst" class="kt-label mb-2">{{ __('main.gmt_offset_name_dst') ?? 'GMT Offset Name (DST)' }}</label>
                                <input type="text" name="gmt_offset_name_dst" id="gmt_offset_name_dst" class="kt-input h-[45px]"
                                    value="{{ old('gmt_offset_name_dst') }}" placeholder="GMT+3">
                                @error('gmt_offset_name_dst')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Offset (in seconds) -->
                            <div>
                                <label for="offset" class="kt-label mb-2">{{ __('main.offset') }}</label>
                                <input type="number" name="offset" id="offset" class="kt-input h-[45px]"
                                    value="{{ old('offset', 7200) }}" placeholder="7200">
                                @error('offset')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Offset DST (in seconds) -->
                            <div>
                                <label for="offset_dst" class="kt-label mb-2">{{ __('main.offset_dst') }}</label>
                                <input type="number" name="offset_dst" id="offset_dst" class="kt-input h-[45px]"
                                    value="{{ old('offset_dst', 10800) }}" placeholder="10800">
                                @error('offset_dst')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="kt-label mb-2">{{ __('main.sort_order') }}</label>
                                <input type="number" name="sort_order" id="sort_order" class="kt-input h-[45px]"
                                    value="{{ old('sort_order', 0) }}">
                                @error('sort_order')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => old('description'),
                        ])

                        <!-- Notes -->
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => old('notes'),
                        ])

                        <hr class="my-6 border-dashed border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
                            <!-- Is Active -->
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="is_active" value="0">
                                <label class="switch switch-sm" for="is_active">
                                    <input class="switch-input" name="is_active" id="is_active" type="checkbox" value="1" {{ old('is_active', 1) ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.active') }}</span>
                                </label>
                            </div>

                            <!-- Supports DST -->
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="supports_dst" value="0">
                                <label class="switch switch-sm" for="supports_dst">
                                    <input class="switch-input" name="supports_dst" id="supports_dst" type="checkbox" value="1" {{ old('supports_dst', 0) ? 'checked' : '' }} />
                                    <span class="switch-label font-medium text-sm text-gray-700">{{ __('main.supports_dst') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Save Submit -->
                        @include('components.elements.save-submit', [
                            'models' => 'timezones',
                            'cancel_route' => route('dashboard.localization.timezones.index'),
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
