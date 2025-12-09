@extends('layouts.master')

@section('title', __('main.edit_type', ['type' => __('main.room_type')]))

@section('content')
    <div class="kt-container-fixed">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-4">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ __('main.edit_type', ['type' => __('main.room_type')]) }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ __('main.edit_type_description', ['type' => __('main.room_type')]) }}
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
                <form action="{{ route('accommodations.rates.update-room', $roomRate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="accommodation_id" class="kt-label">{{ __('main.accommodation') }}</label>
                            <select class="kt-select @error('accommodation_id') is-invalid @enderror" id="accommodation_id"
                                name="accommodation_id">
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
                            <label for="season_id" class="kt-label">{{ __('main.season') }}</label>
                            <select class="kt-select @error('season_id') is-invalid @enderror" id="season_id"
                                name="season_id">
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
                            <label for="room_type_id" class="kt-label">{{ __('main.room_type') }}</label>
                            <select class="kt-select @error('room_type_id') is-invalid @enderror" id="room_type_id"
                                name="room_type_id">
                                <option value="">--</option>
                                @foreach ($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}"
                                        {{ $roomRate->room_type_id == $roomType->id ? 'selected' : '' }}>
                                        {{ $roomType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p class="mb-2 font-semibold text-2xl">{{ __('main.rates') }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4">
                        <div class="">
                            <label for="single_rate" class="kt-label">{{ __('main.single_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('single_rate') is-invalid @enderror"
                                id="single_rate" name="price_per_person_double" value="{{ $roomType->single_rate }}"
                                minLength="1">
                            @error('single_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="double_rate" class="kt-label">{{ __('main.double_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('double_rate') is-invalid @enderror"
                                id="double_rate" name="single_room_supplement" value="{{ $roomType->double_rate }}"
                                minLength="1">
                            @error('double_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="triple_rate" class="kt-label">{{ __('main.triple_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('triple_rate') is-invalid @enderror"
                                id="triple_rate" name="triple_room_discount" value="{{ $roomType->triple_rate }}"
                                minLength="1">
                            @error('triple_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="quad_rate" class="kt-label">{{ __('main.quad_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('quad_rate') is-invalid @enderror"
                                id="quad_rate" name="third_person_price" value="{{ $roomType->quad_rate }}" minLength="1">
                            @error('quad_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="child_rate" class="kt-label">{{ __('main.child_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('child_rate') is-invalid @enderror"
                                id="child_rate" name="extra_bed_price" value="{{ $roomType->child_rate }}" minLength="1">
                            @error('child_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="infant_rate" class="kt-label">{{ __('main.infant_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('infant_rate') is-invalid @enderror"
                                id="infant_rate" name="sea_view_supplement" value="{{ $roomType->infant_rate }}"
                                minLength="1">
                            @error('infant_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="">
                            <label for="extra_bed_rate" class="kt-label">{{ __('main.extra_bed_rate') }}</label>
                            <input type="number" class="kt-input h-[45px] @error('extra_bed_rate') is-invalid @enderror"
                                id="extra_bed_rate" name="currency" value="{{ $roomType->extra_bed_rate }}"
                                minLength="1">
                            @error('extra_bed_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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

                    {{-- Update Submit --}}
                    @include('components.elements.update-submit', ['models' => 'accommodations.rates'])
                </form>
            </div>
        </div>
    </div>
@endsection
