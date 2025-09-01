@extends('pages.dashboard.multi-step-form.layout', ['step' => 2])

@section('form-content')
    <form action="{{ route('dashboard.multi-step-form.step3') }}" method="POST" class="form" id="kt_form_2">
        @csrf

        <div class="mb-6">
            <h4 class="text-dark text-xl font-semibold mb-2">{{ __('step :number', ['number' => 2]) }}:
                {{ __('Hotel, Room Type & Season') }}</h4>
            <p class="text-gray-600">{{ __('Select hotel, room type and season for your booking') }}</p>
        </div>

        <!-- Hidden field to carry over the currency_id -->
        <input type="hidden" name="currency_id" value="{{ request('currency_id') }}">
        <div>
            <div class="grid lg:grid-cols-3 gap-6">
                <div class="mb-4">
                    <!-- Hotel -->
                    <label for="hotel_id" class="kt-label mb-2">{{ __('main.hotel') }}</label>
                    <select name="hotel_id" id="hotel_id" class="kt-select">
                        <option value="">{{ __('main.select_hotel') }}</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->accommodation->name_en }}
                            </option>
                        @endforeach
                    </select>
                    <div class="fv-plugins-message-container invalid-feedback">
                        Please select a hotel.
                    </div>
                </div>

                <div class="mb-4">
                    <!-- Room Type -->
                    <label for="room_type_id" class="kt-label mb-2">{{ __('main.room_type') }}</label>
                    <select name="room_type_id" id="room_type_id" class="kt-select">
                        <option value="">{{ __('main.select_room_type') }}</option>
                        @foreach ($hotelRoomTypes as $roomType)
                            <option value="{{ $roomType->id }}"
                                {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name_en }}
                            </option>
                        @endforeach
                    </select>
                    <div class="fv-plugins-message-container invalid-feedback">
                        Please select a room type.
                    </div>
                </div>

                <div class="mb-4">
                    <!-- Room Type -->
                    <label for="hotel_season_id" class="kt-label mb-2">{{ __('main.season_type') }}</label>
                    <select name="hotel_season_id" id="hotel_season_id" class="kt-select">
                        <option value="">{{ __('main.select_season') }}</option>
                        @foreach ($hotelSeasons as $season)
                            <option value="{{ $season->id }}"
                                {{ old('hotel_season_id') == $season->id ? 'selected' : '' }}>
                                {{ $season->season_name }} ({{ $season->start_date }} - {{ $season->end_date }})
                            </option>
                        @endforeach
                    </select>
                    <div class="fv-plugins-message-container invalid-feedback">
                        Please select a season.
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('dashboard.multi-step-form.step1') }}" class="btn btn-light">
                    <i class="ki-duotone ki-arrow-left me-2"><span class="path1"></span><span class="path2"></span></i>
                    Previous Step
                </a>
                <button type="submit" class="btn btn-primary next-step">
                    Next Step <i class="ki-duotone ki-arrow-right ms-2"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    {{-- <script>
        $(document).ready(function() {
            // Filter room types based on selected hotel
            $('#hotel_id').on('change', function() {
                const hotelId = $(this).val();
                if (hotelId) {
                    // In a real application, you would make an AJAX call to get room types for this hotel
                    // For simplicity, we're just filtering the existing options here
                }
            });
        });
    </script> --}}
@endpush
