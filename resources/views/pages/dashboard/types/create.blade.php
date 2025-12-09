@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.type')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('types.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.types')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('types.store') }}">
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'label' => __('main.active'),
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Submit -->
            @include('components.elements.save-submit', ['models' => 'types'])
        </form>
    </div>
@endsection
