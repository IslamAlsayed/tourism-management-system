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
                <a href="{{ route('accommodations-rates.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', replace: ['types' => __('main.rates')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('accommodations-rates.update-meal', $mealRate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="accommodation_id" class="kt-label mb-2 flex items-center justify-between">
                                {{ __('main.accommodations') }}
                                <a href="{{ route('accommodations.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="accommodation_id" id="accommodation_id" class="kt-select basic-single">
                                @foreach ($accommodations as $accommodation)
                                    <option value="{{ $accommodation->id }}"
                                        {{ $mealRate->accommodation_id == $accommodation->id ? 'selected' : '' }}>
                                        {{ $accommodation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accommodation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="season_id" class="kt-label mb-2 flex items-center justify-between">
                                {{ __('main.seasons') }}
                                <a href="{{ route('seasons.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="season_id" id="season_id" class="kt-select basic-single">
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}"
                                        {{ $mealRate->season_id == $season->id ? 'selected' : '' }}>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="meal_id" class="kt-label mb-2 flex items-center justify-between">
                                {{ __('main.meals') }}
                                <a href="{{ route('meals.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select id="meal_id" name="meal_id" class="kt-select basic-single">
                                @foreach ($meals as $meal)
                                    <option value="{{ $meal->id }}"
                                        {{ $mealRate->meal_id == $meal->id ? 'selected' : '' }}>
                                        {{ $meal->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('meal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="price" class="kt-label">{{ __('main.price') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="price" name="price"
                                value="{{ $mealRate->price }}" min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="currency_id" class="kt-label mb-2 flex items-center justify-between">
                                {{ __('main.currencies') }}
                                <a href="{{ route('currencies.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="currency_id" class="kt-select basic-single" id="currency_id">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}"
                                        {{ $mealRate->currency_id == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @include('components.elements.input-text-editor', [
                        'name' => 'notes',
                        'value' => $mealRate->notes,
                    ])

                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_supplement" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_supplement',
                                'id' => 'is_supplement',
                                'value' => '1',
                                'checked' => $mealRate->is_supplement,
                                'label' => __('main.is_supplement'),
                            ])
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $mealRate->is_active,
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    {{-- Update Submit --}}
                    @include('components.elements.update-submit', ['models' => 'accommodations-rates'])
                </form>
            </div>
        </div>
    </div>
@endsection
