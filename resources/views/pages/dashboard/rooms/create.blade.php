@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.room')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.room')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.room')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="align-self-end">
                            <label for="name" class="kt-label required">
                                {{ __('main.name') }}
                                <span class="text-red-600 text-2xl">*</span>
                            </label>
                            <input type="text" class="kt-input h-[45px]" id="name" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="align-self-end">
                            <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                            <input type="text" class="kt-input h-[45px]" id="name_ar" name="name_ar"
                                value="{{ old('name_ar') }}">
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 align-self-end">
                            <label for="max_occupancy" class="kt-label required">
                                {{ __('main.max_occupancy') }}
                                <span class="text-red-600 text-2xl">*</span>
                            </label>
                            <input type="number" class="kt-input h-[45px]" id="max_occupancy" name="max_occupancy"
                                value="{{ old('max_occupancy', 2) }}" minLength="1" required>
                            @error('max_occupancy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    @include('components.elements.input-text-editor', [
                        'name' => 'description',
                        'value' => old('description'),
                    ])

                    <div class="mb-4">
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
                    </div>

                    {{-- Save Submit --}}
                    @include('components.elements.save-submit', ['models' => 'rooms'])
                </form>
            </div>
        </div>
    </div>
@endsection
