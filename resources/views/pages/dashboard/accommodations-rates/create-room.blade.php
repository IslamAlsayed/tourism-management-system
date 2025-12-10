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
                <a href="{{ route('accommodations-rates.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rates')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form action="{{ route('accommodations-rates.store-room') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="accommodation_id" class="kt-label mb-2 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span>{{ __('main.accommodations') }}</span>
                                    <span class="text-red-600 pt-2 text-2xl">*</span>
                                </span>
                                <a href="{{ route('accommodations.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="accommodation_id" id="accommodation_id" class="kt-select basic-single" required>
                                @foreach ($accommodations as $accommodation)
                                    <option value="{{ $accommodation->id }}"
                                        {{ old('accommodation_id') == $accommodation->id ? 'selected' : '' }}>
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
                                <span class="flex items-center gap-2">
                                    <span>{{ __('main.seasons') }}</span>
                                    <span class="text-red-600 pt-2 text-2xl">*</span>
                                </span>
                                <a href="{{ route('seasons.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="season_id" id="season_id" class="kt-select basic-single" required>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}"
                                        {{ old('season_id') == $season->id ? 'selected' : '' }}>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="room_id" class="kt-label mb-2 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span>{{ __('main.rooms') }}</span>
                                    <span class="text-red-600 pt-2 text-2xl">*</span>
                                </span>
                                <a href="{{ route('rooms.create') }}" class="text-blue-600 text-2sm">
                                    {{ __('main.add') }}
                                </a>
                            </label>
                            <select name="room_id" id="room_id" class="kt-select basic-single" required>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
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
                            <select name="currency_id" id="currency_id" class="kt-select basic-single">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}"
                                        {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label for="price_per_person_double" class="kt-label required">
                                {{ __('main.price_per_person_double') }}
                                <span class="text-red-600 pt-2 text-2xl">*</span>
                            </label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="price_per_person_double"
                                name="price_per_person_double" value="{{ old('price_per_person_double', 0) }}"
                                min="0" required>
                            @error('price_per_person_double')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="single_room_supplement"
                                class="kt-label">{{ __('main.single_room_supplement') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="single_room_supplement"
                                name="single_room_supplement" value="{{ old('single_room_supplement', 0) }}"
                                min="0">
                            @error('single_room_supplement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="triple_room_discount"
                                class="kt-label">{{ __('main.triple_room_discount') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="triple_room_discount"
                                name="triple_room_discount" value="{{ old('triple_room_discount', 0) }}" min="0">
                            @error('triple_room_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="third_person_price" class="kt-label">{{ __('main.third_person_price') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="third_person_price"
                                name="third_person_price" value="{{ old('third_person_price', 0) }}" min="0">
                            @error('third_person_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="extra_bed_price" class="kt-label">{{ __('main.extra_bed_price') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="extra_bed_price"
                                name="extra_bed_price" value="{{ old('extra_bed_price', 0) }}" min="0">
                            @error('extra_bed_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="sea_view_supplement"
                                class="kt-label">{{ __('main.sea_view_supplement') }}</label>
                            <input type="number" step="0.01" class="kt-input h-[45px]" id="sea_view_supplement"
                                name="sea_view_supplement" value="{{ old('sea_view_supplement', 0) }}" min="0">
                            @error('sea_view_supplement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @include('components.elements.input-text-editor', [
                        'name' => 'notes',
                        'value' => old('notes'),
                    ])

                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => old('is_active', true),
                                'label' => __('main.is_active'),
                            ])
                        </div>
                    </div>

                    {{-- Save Submit --}}
                    @include('components.elements.save-submit', ['models' => 'accommodations-rates'])
                </form>
            </div>
        </div>
    </div>
@endsection
