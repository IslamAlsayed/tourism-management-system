@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.meal_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.meal_type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.meal_type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('accommodations.meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meal_types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('accommodations.meals.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label for="name" class="kt-label required">{{ __('main.name') }}</label>
                            <input type="text" class="kt-input h-[45px] @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="name_ar" class="kt-label required">{{ __('main.name_ar') }}</label>
                            <input type="text" class="kt-input h-[45px] @error('name_ar') is-invalid @enderror"
                                id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required>
                            @error('name_ar')
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
                        <div class="flex items-center gap-3 mb-2">
                            <input type="hidden" name="is_included" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_included',
                                'id' => 'is_included',
                                'value' => '1',
                                'label' => __('main.is_included'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    {{-- Save Submit --}}
                    @include('components.elements.save-submit', ['models' => 'accommodations.meals'])
                </form>
            </div>
        </div>
    </div>
@endsection
