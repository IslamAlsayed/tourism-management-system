@extends('layouts.master')

@section('title', __('main.create_season') /* Can be mapped to main.create */)

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.seasons')]) }}
                </h1>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.cruises.seasons.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back') }}
                </a>
            </div>
        </div>
    </div>

    <div class="container-fixed">
        <form class="space-y-6" method="POST" action="{{ route('dashboard.cruises.seasons.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">

                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.general_information') }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div class="md:col-span-2">
                                <label for="name" class="kt-label required mb-2">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Start Date --}}
                            <div>
                                <label for="start_date" class="kt-label required mb-2">{{ __('main.start_date') }}</label>
                                <input type="date" name="start_date" id="start_date" class="kt-input h-[45px]" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div>
                                <label for="end_date" class="kt-label required mb-2">{{ __('main.end_date') }}</label>
                                <input type="date" name="end_date" id="end_date" class="kt-input h-[45px]" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="kt-card">
                    <div class="kt-card-body p-4 flex gap-6">
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
                    <a href="{{ route('dashboard.cruises.seasons.index') }}" class="kt-btn kt-btn-outline">{{ __('main.cancel') }}</a>
                    <button type="submit" class="kt-btn kt-btn-primary">{{ __('main.save_and_continue') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
