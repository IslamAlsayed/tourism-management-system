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
                <a href="{{ route('rooms.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.rooms')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed">
        <div class="kt-card p-4">
            <div class="kt-card-body">
                <form class="space-y-6" method="POST" action="{{ route('rooms.update', $room->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 lg:gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- accommodations-restaurants --}}
                            <livewire:accommodations-restaurants-selects :record="$room" />

                            {{-- Currency --}}
                            <div class="align-self-end">
                                <label for="currency_id" class="kt-label mb-2">{{ __('main.currency') }}</label>
                                <select name="currency_id" id="currency_id" class="kt-select basic-single">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ $room->currency_id == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->name }} - {{ $currency->code }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (English) --}}
                            <div class="align-self-end">
                                <label for="name" class="kt-label mb-1">{{ __('main.name') }}</label>
                                <input type="text" name="name" id="name" class="kt-input h-[45px]"
                                    value="{{ $room->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Name (Arabic) --}}
                            <div>
                                <label for="name_ar" class="kt-label mb-2">{{ __('main.name_ar') }}</label>
                                <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]"
                                    value="{{ $room->name_ar }}">
                                @error('name_ar')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Max Occupancy --}}
                            <div class="align-self-end">
                                <label for="max_occupancy" class="kt-label mb-2">
                                    {{ __('main.max_occupancy') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" name="max_occupancy" id="max_occupancy" class="kt-input h-[45px]"
                                    value="{{ $room->max_occupancy }}" minLength="1">
                                @error('max_occupancy')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Occupancy Details --}}
                            <div class="align-self-end">
                                <label for="occupancy_details" class="kt-label mb-2">
                                    {{ __('main.occupancy_details') }}
                                </label>
                                <input type="text" name="occupancy_details" id="occupancy_details"
                                    class="kt-input h-[45px]" value="{{ $room->occupancy_details }}">
                                @error('occupancy_details')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pricing Information --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-end gap-6">
                            {{-- Price Per Person Double --}}
                            <div class="align-self-end">
                                <label for="price_per_person_double" class="kt-label mb-1">
                                    {{ __('main.price_per_person_double') }}
                                    <span class="text-red-600 text-2xl">*</span>
                                </label>
                                <input type="number" step="0.01" name="price_per_person_double"
                                    id="price_per_person_double" class="kt-input h-[45px]"
                                    value="{{ $room->price_per_person_double }}" minLength="0">
                                @error('price_per_person_double')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Single Room Supplement --}}
                            <div class="align-self-end">
                                <label for="single_room_supplement" class="kt-label mb-1">
                                    {{ __('main.single_room_supplement') }}
                                </label>
                                <input type="number" step="0.01" name="single_room_supplement"
                                    id="single_room_supplement" class="kt-input h-[45px]"
                                    value="{{ $room->single_room_supplement }}" minLength="0">
                                @error('single_room_supplement')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Triple Room Discount --}}
                            <div class="align-self-end">
                                <label for="triple_room_discount" class="kt-label mb-1">
                                    {{ __('main.triple_room_discount') }}
                                </label>
                                <input type="number" step="0.01" name="triple_room_discount" id="triple_room_discount"
                                    class="kt-input h-[45px]" value="{{ $room->triple_room_discount }}" minLength="0">
                                @error('triple_room_discount')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Third Person Price --}}
                            <div class="align-self-end">
                                <label for="third_person_price" class="kt-label mb-1">
                                    {{ __('main.third_person_price') }}
                                </label>
                                <input type="number" step="0.01" name="third_person_price" id="third_person_price"
                                    class="kt-input h-[45px]" value="{{ $room->third_person_price }}" minLength="0">
                                @error('third_person_price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Extra Bed Price --}}
                            <div class="align-self-end">
                                <label for="extra_bed_price" class="kt-label mb-1">
                                    {{ __('main.extra_bed_price') }}
                                </label>
                                <input type="number" step="0.01" name="extra_bed_price" id="extra_bed_price"
                                    class="kt-input h-[45px]" value="{{ $room->extra_bed_price }}" minLength="0">
                                @error('extra_bed_price')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sea View Supplement --}}
                            <div class="align-self-end">
                                <label for="sea_view_supplement" class="kt-label mb-1">
                                    {{ __('main.sea_view_supplement') }}
                                </label>
                                <input type="number" step="0.01" name="sea_view_supplement" id="sea_view_supplement"
                                    class="kt-input h-[45px]" value="{{ $room->sea_view_supplement }}" minLength="0">
                                @error('sea_view_supplement')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Notes --}}
                        @include('components.elements.input-text-editor', [
                            'name' => 'notes',
                            'value' => $room->notes,
                        ])

                        {{-- Additional Settings --}}
                        <div class="flex gap-6">
                            <div class="flex items-center gap-3">
                                <input type="hidden" name="is_active" value="0">
                                @include('components.elements.checkbox-button', [
                                    'name' => 'is_active',
                                    'id' => 'is_active',
                                    'value' => '1',
                                    'checked' => $room->is_active,
                                    'label' => __('main.is_active'),
                                ])
                            </div>
                        </div>

                        {{-- Update Submit --}}
                        @include('components.elements.update-submit', ['models' => 'rooms'])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
