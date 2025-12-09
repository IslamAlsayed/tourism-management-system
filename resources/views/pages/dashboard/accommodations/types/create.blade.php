@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.accommodation_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.accommodation_type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.accommodation_type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations-types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.accommodation_types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('accommodations-types.store') }}">
            @csrf

            {{-- Basic Information --}}
            <div class="kt-card mb-6">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.basic_information') }}</h3>
                </div>
                <div class="kt-card-body p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        {{-- Name (English) --}}
                        <div>
                            <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                            <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Name (Arabic) --}}
                        <div>
                            <label for="name_ar" class="kt-label required mb-2">{{ __('main.name_ar') }}</label>
                            <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                value="{{ old('name_ar') }}" required>
                            @error('name_ar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    @include('components.elements.input-text-editor', [
                        'name' => 'description',
                        'value' => old('description'),
                    ])

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="kt-checkbox"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="kt-label">{{ __('main.active') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Save Submit -->
            @include('components.elements.save-submit', ['models' => 'accommodations-types'])
        </form>
    </div>
@endsection
