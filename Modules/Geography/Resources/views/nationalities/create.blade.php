@extends('layouts.master')

@section('title', __('main.create_type', ['type' => __('main.nationality')]))

@section('content')
    <div class="container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.create_type', ['type' => __('main.nationality')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.create_type_description', ['type' => __('main.nationality')]) }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.geography.nationalities.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.nationalities')]) }}
                </a>
            </div>
        </div>

        @include('components.must-add-first', [
            'requirements' => [
                [
                    'condition' => \Modules\Geography\Entities\Country::count() > 0,
                    'route' => route('dashboard.geography.countries.index'),
                    'label' => __('main.countries_'),
                ],
            ],
        ])
    </div>

    <div class="container-fixed">
        <form action="{{ route('dashboard.geography.nationalities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <!-- Nationality Information -->
                <div class="kt-card">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">
                            {{ __('main.type_information', ['type' => __('main.nationality')]) }}
                        </h3>
                    </div>
                    <div class="kt-card-body p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <!-- Country -->
                            <div class="">
                                <label for="country_id" class="kt-label required mb-2">
                                    <div>
                                        {{ __('main.country') }}
                                        <strong class="dataLength text-primary">
                                            ({{ count($countries) ?: 0 }})
                                        </strong>
                                    </div>
                                    <span class="text-red-600">*</span>
                                </label>
                                <select name="country_id" id="country_id" class="kt-input basic-single" required>
                                    <option value="" selected>--</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name (English) -->
                            <div class="">
                                <label for="name" class="kt-label required mb-2">
                                    {{ __('main.name') }}
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name (Arabic) -->
                            <div class="">
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar') }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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

                <!-- Is active -->
                <div class="flex flex-wrap gap-10">
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

                <!-- Save Submit -->
                @include('components.elements.save-submit', ['models' => 'dashboard.geography.nationalities', 'model' => 'nationality'])
            </div>
        </form>
    </div>
@endsection
