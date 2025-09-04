@extends('pages.dashboard.quote.layout', ['step' => 2])

@section('form-content')
    <form method="POST" action="{{ route('dashboard.quote.postStep2', ['id' => $booking->id]) }}" class="space-y-8">
        @csrf

        <livewire:quote.step2.hotels :id="$booking->id" />

        <livewire:quote.step2.transportation :id="$booking->id" />

        <livewire:quote.step2.otherServices :id="$booking->id" />

        <div class="flex justify-between">
            <a href="{{ route('dashboard.quote.step1') }}" class="kt-btn kt-btn-light">Back</a>
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
@endsection

{{-- @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll(".transport-row");

            rows.forEach(row => {
                const busTypeSelect = row.querySelector(".bus-type-select");
                const rateSelect = row.querySelector(".rate-select");
                const daysInput = row.querySelector(".days-input");
                const totalPriceInput = row.querySelector(".total-price-input");

                // تحديث الأسعار عند تغيير الباص
                busTypeSelect.addEventListener("change", function() {
                    const busTypeId = this.value;

                    // فلترة الأسعار تبع الباص
                    Array.from(rateSelect.options).forEach(opt => {
                        if (!opt.value) return; // skip default option
                        opt.style.display = (opt.dataset.bus == busTypeId) ? "block" :
                            "none";
                    });

                    rateSelect.value = ""; // reset
                    totalPriceInput.value = ""; // reset
                });

                // تحديث السعر عند تغيير rate أو الأيام
                function updatePrice() {
                    const selectedRate = rateSelect.options[rateSelect.selectedIndex];
                    const days = parseInt(daysInput.value) || 0;

                    if (selectedRate && selectedRate.dataset.price && days > 0) {
                        const pricePerDay = parseFloat(selectedRate.dataset.price);
                        totalPriceInput.value = (pricePerDay * days).toFixed(2);
                    } else {
                        totalPriceInput.value = "";
                    }
                }

                rateSelect.addEventListener("change", updatePrice);
                daysInput.addEventListener("input", updatePrice);
            });
        });
    </script>
@endpush --}}


{{-- @section('form-content')
    <livewire:quote.booking-step2 />
@endsection --}}

{{-- @push('scripts_2')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomInputs = document.querySelectorAll('.room-input');
            const transportInputs = document.querySelectorAll('.transport-input');
            const transportCheckboxes = document.querySelectorAll('.transport-checkbox');
            const serviceInputs = document.querySelectorAll('.service-input');
            const serviceCheckboxes = document.querySelectorAll('.service-checkbox');

            function calculateTotals() {
                let hotelSubtotal = 0;
                roomInputs.forEach(input => {
                    const val = parseInt(input.value) || 0;
                    const max = parseInt(input.dataset.max) || 1;
                    const warning = input.closest('div').querySelector('.room-warning');
                    if (val > max) warning.style.display = 'block';
                    else warning.style.display = 'none';

                    hotelSubtotal += val * 100; // مؤقتاً rate ثابت، يمكن تعويضه بالقيمة الفعلية لكل غرفة
                });
                document.getElementById('hotel-subtotal').textContent = hotelSubtotal.toFixed(2);

                let transportSubtotal = 0;
                transportCheckboxes.forEach((chk, idx) => {
                    if (!chk.checked) return;
                    const days = parseInt(transportInputs[idx * 2].value) || 0;
                    const price = parseFloat(transportInputs[idx * 2 + 1].value) || 0;
                    transportSubtotal += days * price;
                });
                document.getElementById('transport-subtotal').textContent = transportSubtotal.toFixed(2);

                let servicesSubtotal = 0;
                serviceCheckboxes.forEach((chk, idx) => {
                    if (!chk.checked) return;
                    const qty = parseInt(serviceInputs[idx * 2].value) || 0;
                    const unit = parseFloat(serviceInputs[idx * 2 + 1].value) || 0;
                    servicesSubtotal += qty * unit;
                });
                document.getElementById('services-subtotal').textContent = servicesSubtotal.toFixed(2);

                const grandTotal = hotelSubtotal + transportSubtotal + servicesSubtotal;
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }

            [...roomInputs, ...transportInputs, ...serviceInputs, ...transportCheckboxes, ...serviceCheckboxes]
            .forEach(el => {
                el.addEventListener('input', calculateTotals);
                el.addEventListener('change', calculateTotals);
            });

            calculateTotals(); // initial calculation
        });
    </script>
@endpush
 --}}


{{-- <form method="POST" action="{{ route('dashboard.quote.postStep2', $booking) }}" class="space-y-8" id="step2-form">
        @csrf

        Hotels
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-3">Hotels (optional)</h4>

            <div class="grid lg:grid-cols-2 gap-6">
                <div>
                    <label class="kt-label mb-2">Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="kt-select mb-2">
                        <option value="">Select hotel</option>
                        @foreach ($hotels as $h)
                            <option value="{{ $h->id }}" @selected($booking->hotel_id == $h->id)>
                                {{ $h->name ?? ($h->accommodation->name_en ?? 'Hotel #' . $h->id) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="kt-label mb-2">Season</label>
                    <select name="hotel_season_id" id="hotel_season_id" class="kt-select mb-2">
                        <option value="">Select season</option>
                        @foreach ($seasons as $s)
                            <option value="{{ $s->id }}" data-start="{{ $s->start_date }}"
                                data-end="{{ $s->end_date }}" @selected($booking->hotel_season_id == $s->id)>
                                {{ $s->season_name ?? $s->name }} ({{ $s->start_date }} - {{ $s->end_date }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6 mt-4">
                @foreach ($roomTypes as $rt)
                    <div>
                        <label class="kt-label mb-2">{{ $rt->name_en ?? $rt->name }} (Number of Rooms)</label>
                        <input type="number" name="rooms[{{ $rt->id }}]" min="0"
                            value="{{ $booking->rooms[$rt->id] ?? 0 }}" class="kt-input room-input"
                            data-max="{{ $rt->max_occupancy ?? 1 }}">
                        <div class="text-red-500 text-sm mt-1 room-warning" style="display:none;">
                            Exceeds max occupancy!
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3 font-semibold">
                Hotel Subtotal: $<span id="hotel-subtotal">0.00</span>
            </div>
        </div>

        Transportation
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-3">Transportation</h4>
            <div class="grid lg:grid-cols-3 gap-4 font-semibold text-sm text-gray-500">
                <div>Company</div>
                <div>Days</div>
                <div>Price / Day</div>
            </div>
            <div id="transport-rows" class="space-y-3">
                @foreach ($transportCompanies as $i => $t)
                    <div class="grid lg:grid-cols-3 gap-4 items-center">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="transportation_company_ids[]" value="{{ $t->id }}"
                                class="kt-checkbox transport-checkbox">
                            <span>{{ $t->name ?? ($t->name_en ?? 'Company #' . $t->id) }}</span>
                        </div>
                        <input type="number" min="1" name="transport_days[]" class="kt-input transport-input"
                            placeholder="Days">
                        <input type="number" min="0" step="0.01" name="transport_price_per_day[]"
                            class="kt-input transport-input" placeholder="Price per day">
                    </div>
                @endforeach
            </div>
            <div class="mt-3 font-semibold">Transport Subtotal: $<span id="transport-subtotal">0.00</span></div>
        </div>

        Other Services
        <div class="kt-card p-4 mb-4">
            <h4 class="text-lg font-semibold mb-3">Other Services</h4>
            <div class="grid lg:grid-cols-3 gap-4 font-semibold text-sm text-gray-500">
                <div>Service</div>
                <div>Qty</div>
                <div>Unit Price</div>
            </div>
            @foreach ($otherServices as $srv)
                <div class="grid lg:grid-cols-3 gap-4 items-center">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="other_service_ids[]" value="{{ $srv->id }}"
                            class="kt-checkbox service-checkbox">
                        <span>{{ $srv->name_en ?? $srv->name }} @if ($srv->price)
                                ({{ number_format($srv->price, 2) }})
                            @endif
                        </span>
                    </div>
                    <input type="number" min="1" name="service_qty[]" class="kt-input service-input"
                        placeholder="Qty">
                    <input type="number" min="0" step="0.01" name="service_unit_price[]"
                        class="kt-input service-input" placeholder="Unit price">
                </div>
            @endforeach
            <div class="mt-3 font-semibold">Services Subtotal: $<span id="services-subtotal">0.00</span></div>
        </div>

        <div class="mt-4 font-bold text-lg">
            Grand Total: $<span id="grand-total">0.00</span>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('dashboard.quote.step1') }}" class="kt-btn kt-btn-light">Back</a>
            <button class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form> --}}

{{-- @section('form-content')
    <form action="{{ route('dashboard.quote.step3') }}" method="POST" class="form" id="kt_form_2">
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
                <a href="{{ route('dashboard.quote.step1') }}" class="btn btn-light">
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
@endsection --}}

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
