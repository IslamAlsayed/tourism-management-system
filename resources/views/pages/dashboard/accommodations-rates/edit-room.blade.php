@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.room')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.room')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.room')]) }}
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
                <form action="{{ route('accommodations-rates.update-room', $roomRate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="accommodation_id" class="kt-label required">{{ __('main.accommodation') }}</label>
                            <select class="kt-select @error('accommodation_id') is-invalid @enderror" id="accommodation_id"
                                name="accommodation_id" special-search required>
                                <option value="">--</option>
                                @foreach ($accommodations as $accommodation)
                                    <option value="{{ $accommodation->id }}"
                                        {{ $roomRate->accommodation_id == $accommodation->id ? 'selected' : '' }}>
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
                                name="season_id" special-search required>
                                <option value="">--</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id }}"
                                        {{ $roomRate->season_id == $season->id ? 'selected' : '' }}>
                                        {{ $season->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="room_id" class="kt-label required">{{ __('main.room') }}</label>
                            <select class="kt-select @error('room_id') is-invalid @enderror" id="room_id" name="room_id"
                                special-search required>
                                <option value="">--</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $roomRate->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="currency_id" class="kt-label required">{{ __('main.currency') }}</label>
                            <select class="kt-select @error('currency_id') is-invalid @enderror" id="currency_id"
                                name="currency_id" special-search required>
                                <option value="">--</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}"
                                        {{ $roomRate->currency_id == $currency->id ? 'selected' : '' }}>
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p class="mb-2 font-semibold text-2xl">{{ __('main.rates') }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label for="price_per_person_double"
                                class="kt-label required">{{ __('main.price_per_person_double') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('price_per_person_double') is-invalid @enderror"
                                id="price_per_person_double" name="price_per_person_double"
                                value="{{ $roomRate->price_per_person_double }}" min="0" required>
                            @error('price_per_person_double')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="single_room_supplement"
                                class="kt-label">{{ __('main.single_room_supplement') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('single_room_supplement') is-invalid @enderror"
                                id="single_room_supplement" name="single_room_supplement"
                                value="{{ $roomRate->single_room_supplement }}" min="0">
                            @error('single_room_supplement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="triple_room_discount"
                                class="kt-label">{{ __('main.triple_room_discount') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('triple_room_discount') is-invalid @enderror"
                                id="triple_room_discount" name="triple_room_discount"
                                value="{{ $roomRate->triple_room_discount }}" min="0">
                            @error('triple_room_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="third_person_price" class="kt-label">{{ __('main.third_person_price') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('third_person_price') is-invalid @enderror"
                                id="third_person_price" name="third_person_price"
                                value="{{ $roomRate->third_person_price }}" min="0">
                            @error('third_person_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="extra_bed_price" class="kt-label">{{ __('main.extra_bed_price') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('extra_bed_price') is-invalid @enderror"
                                id="extra_bed_price" name="extra_bed_price" value="{{ $roomRate->extra_bed_price }}"
                                min="0">
                            @error('extra_bed_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="sea_view_supplement"
                                class="kt-label">{{ __('main.sea_view_supplement') }}</label>
                            <input type="number" step="0.01"
                                class="kt-input h-[45px] @error('sea_view_supplement') is-invalid @enderror"
                                id="sea_view_supplement" name="sea_view_supplement"
                                value="{{ $roomRate->sea_view_supplement }}" min="0">
                            @error('sea_view_supplement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @include('components.elements.input-text-editor', [
                        'name' => 'notes',
                        'value' => old('notes', $roomRate->notes),
                    ])

                    <div class="mb-4">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('components.elements.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $roomRate->is_active,
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
