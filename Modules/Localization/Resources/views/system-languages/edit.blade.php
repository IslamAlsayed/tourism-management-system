@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.language')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.language')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.language')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.localization.languages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.languages')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-6">
            <!-- Language Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_language_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('dashboard.localization.system-languages.update', $language->id) }}"
                        enctype="multipart/form-data" class="space-y-6 p-4">
                        @csrf
                        @method('PUT')

                        <!-- Languages Photo -->
                        @include('components.input-image', [
                            'modelKey' => $language->code ?? 'C',
                            'column' => 'languages',
                            'columnName' => 'photo',
                            'record' => $language,
                        ])

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Language Code -->
                            <div class="">
                                <label for="code" class="kt-label mb-2">{{ __('main.code') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" min="2"
                                    value="{{ $language->code }}">
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $language->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name -->
                            <div class="">
                                <label for="name" class="kt-label mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $language->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Native Name -->
                            <div class="">
                                <label for="native" class="kt-label mb-2">{{ __('main.native_name') }}</label>
                                <input type="text" name="native" id="native" class="kt-input h-[45px]" placeholder="e.g. العربية"
                                    value="{{ $language->native }}">
                                @error('native')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Direction -->
                            <div class="">
                                <label for="dir" class="kt-label required mb-2">{{ __('main.direction') }}</label>
                                <select name="dir" id="dir" class="kt-select h-[45px]" required>
                                    <option value="ltr" {{ $language->dir == 'ltr' ? 'selected' : '' }}>Left to Right (LTR)</option>
                                    <option value="rtl" {{ $language->dir == 'rtl' ? 'selected' : '' }}>Right to Left (RTL)</option>
                                </select>
                                @error('dir')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Update Submit Buttons -->
                        @include('components.elements.update-submit', [
                            'models' => 'system-languages',
                            'cancel_route' => route('dashboard.localization.system-languages.index'),
                        ])
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.important_information') }}</h3>
                </div>
                <div class="kt-card-body p-2">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary-light rounded-full p-2">
                                <i class="ki-filled ki-information text-primary"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.geographic_coordinates') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-success-light rounded-full p-2">
                                <i class="ki-filled ki-geolocation text-success"></i>
                            </div>
                            <div>
                                <div class="mb-2 font-semibold">{{ __('main.geographic_coordinates') }}</div>
                                <div class="text-sm text-secondary-foreground">
                                    {{ __('main.use_map_services') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
