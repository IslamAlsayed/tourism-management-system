@extends('layouts.master')

@section('title', __('main.create_new_language'))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_new_language') }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_new_language_description') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('languages.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_languages') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="grid gap-5 lg:gap-7.5">
            <!-- Language Form -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_language_info') }}</h3>
                </div>
                <div class="kt-card-body">
                    <form method="POST" action="{{ route('languages.store') }}" enctype="multipart/form-data"
                        class="space-y-6 p-4">
                        @csrf

                        <div class="grid lg:grid-cols-4 gap-6">
                            <!-- Language Code -->
                            <div class="mb-4">
                                <label for="code" class="kt-label required mb-2">{{ __('main.code') }}</label>
                                <input type="text" name="code" id="code" class="kt-input"
                                    placeholder="ar, en and fr" min="2" required value="{{ old('code') }}">
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Name -->
                            <div class="mb-4">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input"
                                    placeholder="arabic, english and french" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Language Flag -->
                            <div class="mb-4">
                                <label for="photo" class="kt-label required mb-2">{{ __('main.flag') }}</label>
                                <input type="file" name="photo" id="photo" class="kt-input"
                                    accept=".png, .jpg, .jpeg">
                                @error('flag')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="kt-btn kt-btn-primary">
                                <i class="ki-filled ki-check text-sm me-2"></i>
                                {{ __('main.create_language') ?? 'Create Language' }}
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
        </div>
    </div>
@endsection
