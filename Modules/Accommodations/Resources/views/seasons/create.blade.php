@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.season')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.season')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.season')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.accommodations.seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.seasons')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('dashboard.accommodations.seasons.store') }}">
                    @csrf
                    <input type="hidden" name="type" value="{{ request('type') }}">

                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- Polymorphic Model Select --}}
                            <livewire:polymorphic-model-select />

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label mb-1">
                                    {{ __('main.name') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Season From --}}
                            <div class="align-self-end">
                                <label for="season_from" class="kt-label mb-1">
                                    {{ __('main.season_from') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="date" name="season_from" id="season_from" class="kt-input h-[45px]" value="{{ old('season_from') }}">
                                @error('season_from')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Season To --}}
                            <div class="align-self-end">
                                <label for="season_to" class="kt-label mb-1">
                                    {{ __('main.season_to') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="date" name="season_to" id="season_to" class="kt-input h-[45px]" value="{{ old('season_to') }}">
                                @error('season_to')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'description',
                            'value' => old('description'),
                        ])

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => old('notes'),
                        ])

                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => 1,
                                'label' => __('main.active'),
                            ])
                        </div>

                        <!-- Save Submit -->
                        @include('components.elements.save-submit', [
                            'models' => 'dashboard.accommodations.seasons',
                            'model' => 'season',
                        ])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
