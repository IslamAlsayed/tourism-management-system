@extends('layouts.master')

@section('title', __('main.add_new_type', ['type' => __('main.language')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.add_type', ['type' => __('main.language')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.add_type_description', ['type' => __('main.language')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('languages.index') }}" class="kt-btn kt-btn-outline">
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
                    <form method="POST" action="{{ route('languages.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <!-- Language Photo -->
                        @include('components.input-image', [
                            'column' => 'language',
                            'columnName' => 'flag',
                        ])

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
                            <!-- Language Code -->
                            <div class="">
                                <label for="code" class="kt-label required mb-2">{{ __('main.code') }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" min="2"
                                    required value="{{ old('code') }}">
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.save_type', ['type' => __('main.language')]) }}
                            </button>
                            <button type="submit" name="save_and_add" value="1"
                                class="kt-btn kt-btn-outline kt-btn-outline-primary">
                                <i class="ki-filled ki-plus text-sm me-2"></i>
                                {{ __('main.save_and_add_another') ?? 'Save and Add Another' }}
                            </button>
                            <a href="{{ route('languages.index') }}" class="kt-btn kt-btn-outline">
                                {{ __('main.cancel') }}
                            </a>
                        </div>
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
                                <div class="font-semibold">{{ __('main.ensure_data_accuracy') }}</div>
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
                                <div class="font-semibold">{{ __('main.geographic_coordinates') }}</div>
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
