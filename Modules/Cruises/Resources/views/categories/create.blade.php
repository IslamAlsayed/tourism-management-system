@extends('layouts.master')

@section('title', __('main.create_cabin_category') /* Or whatever localization exists */)

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.cabin_categories') ?? 'Cabin Category']) }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.categories.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('dashboard.cruises.categories.store') }}">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.general_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name EN --}}
                            <div>
                                <label for="name" class="kt-label required mb-2">{{ __('main.name_en') ?? 'Name (EN)' }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name AR --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') ?? 'Name (AR)' }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar') }}" dir="rtl">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Code --}}
                            <div class="md:col-span-2">
                                <label for="code" class="kt-label required mb-2">{{ __('main.code') ?? 'Code' }}</label>
                                <input type="text" name="code" id="code" class="kt-input h-[45px]" value="{{ old('code') }}" placeholder="E.g. I1, O2, B3..." required>
                                @error('code')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="kt-label mb-2">{{ __('main.description') }}</label>
                                <textarea name="description" id="description" class="kt-input h-32 py-3" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="kt-card">
                    <div class="kt-card-body p-6 flex gap-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => old('is_active', 1),
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 mt-4">
                    <a href="{{ route('dashboard.cruises.categories.index') }}" class="kt-btn kt-btn-outline">{{ __('main.cancel') }}</a>
                    <button type="submit" class="kt-btn kt-btn-primary">{{ __('main.save_and_continue') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
