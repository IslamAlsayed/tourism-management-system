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
                <a href="{{ route('accommodations.rates.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rates')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('accommodations.rates.update-meal', $meal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="accommodation_id" class="kt-label required">{{ __('main.accommodation') }}</label>
                            <select class="kt-select @error('accommodation_id') is-invalid @enderror" id="accommodation_id"
                                name="accommodation_id" required>
                                <option value="">--</option>
                                @foreach ($accommodations as $accommodation)
                                    <option value="{{ $accommodation->id }}"
                                        {{ $meal->accommodation_id == $accommodation->id ? 'selected' : '' }}>
                                        {{ $accommodation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accommodation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="season_id" class="kt-label required">{{ __('main.season') }}</label>
                            <select class="kt-select @error('season_id') is-invalid @enderror" id="season_id"
                                name="season_id" required>
                                <option value="">--</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}"
                                        {{ $meal->season_id == $season->id ? 'selected' : '' }}>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="meal_id" class="kt-label required">{{ __('main.meal') }}</label>
                            <select class="kt-select @error('meal_id') is-invalid @enderror" id="meal_id" name="meal_id"
                                required>
                                <option value="">--</option>
                                @foreach ($meals as $meal)
                                    <option value="{{ $meal->id }}"
                                        {{ $meal->meal_id == $meal->id ? 'selected' : '' }}>
                                        {{ $meal->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('meal_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p class="mb-2 font-semibold text-2xl">{{ __('main.rates') }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="price" class="kt-label required">{{ __('main.price') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('price') is-invalid @enderror" id="price" name="price"
                                value="{{ $meal->price }}" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="currency" class="kt-label">{{ __('main.currency') }}</label>
                            <input type="text" maxlength="3"
                                class="kt-input h-[45px] @error('currency') is-invalid @enderror" id="currency"
                                name="currency" value="{{ $meal->currency }}" placeholder="USD">
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="kt-label">{{ __('main.notes') }}</label>
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $meal->notes,
                        ])
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_supplement" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_supplement',
                                'id' => 'is_supplement',
                                'value' => '1',
                                'checked' => $meal->is_supplement,
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
                                'checked' => $meal->is_active,
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    {{-- Update Submit --}}
                    @include('components.elements.update-submit', ['models' => 'accommodations.rates'])
                </form>
            </div>
        </div>
    </div>
@endsection
