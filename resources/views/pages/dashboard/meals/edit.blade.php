@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.meal')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.meal')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.meal')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('meals.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.meals')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('meals.update', $meal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label for="name" class="kt-label">{{ __('main.name') }}</label>
                            <input type="text" class="kt-input h-[45px] @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ $meal->name }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="name_ar" class="kt-label">{{ __('main.name_ar') }}</label>
                            <input type="text" class="kt-input h-[45px] @error('name_ar') is-invalid @enderror"
                                id="name_ar" name="name_ar" value="{{ $meal->name_ar }}">
                            @error('name_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    @include('components.elements.input-text-editor', [
                        'name' => 'description',
                        'value' => $meal->description,
                    ])

                    <div class="mb-4">
                        <div class="flex items-center gap-3 mb-2">
                            <input type="hidden" name="is_included" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_included',
                                'id' => 'is_included',
                                'value' => '1',
                                'checked' => $meal->is_included == 1,
                                'label' => __('main.is_included'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $meal->is_active == 1,
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    {{-- Update Submit --}}
                    @include('components.elements.update-submit', ['models' => 'meals'])
                </form>
            </div>
        </div>
    </div>
@endsection
