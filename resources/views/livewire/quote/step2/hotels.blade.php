<div class="kt-card p-4 mb-4">
    <h4 class="text-lg font-semibold mb-3">Hotels (optional)</h4>

    <div class="grid lg:grid-cols-4 gap-6">
        <!-- Guests Information -->
        <div>
            <label class="kt-label mb-2">Guests</label>
            <input type="text" class="kt-input mb-2"
                value="{{ $booking->adults }} adults, {{ $booking->children }} children, {{ $booking->infants }} infants"
                readonly />
        </div>

        <!-- Nights Information -->
        <div>
            <label class="kt-label mb-2">Nights</label>
            <input type="text" class="kt-input mb-2" name="nights" wire:model.live="nights" readonly />
        </div>

        <!-- Hotel Selection -->
        <div>
            <label class="kt-label mb-2">Hotel</label>
            <select class="kt-select mb-2" name="hotel_id" wire:model.live="hotel_id" value="{{ old('hotel_id') }}">
                <option value="">Select hotel</option>
                @foreach ($hotels as $hotel)
                    <option value="{{ $hotel->id }}">
                        {{ $hotel->name ?? ($hotel->name ?? 'Hotel #' . $hotel->id) }}
                    </option>
                @endforeach
            </select>

            @error('hotel_id')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Season Selection -->
        <div>
            <label class="kt-label mb-2">Season</label>
            <select class="kt-select mb-2" name="hotel_season_id" wire:model.live="hotel_season_id"
                value="{{ old('hotel_season_id') }}" @disabled(!$hotel_id)>
                <option value="">Select season</option>
                @foreach ($seasons as $season)
                    <option value="{{ $season->id }}">{{ $season->season_name }} ({{ $season->start_date }} -
                        {{ $season->end_date }})</option>
                @endforeach
            </select>
            @error('hotel_season_id')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="mt-6">
        <h5 class="text-lg font-semibold mb-3">Rooms & Quantities</h5>
        <div class="grid lg:grid-cols-3 gap-6">
            @forelse ($roomTypes as $type)
                <div>
                    <label class="kt-label mb-2">
                        {{ $type->name_en ?? $type->name }} (max {{ $type->max_occupancy }})
                    </label>
                    <input type="number" min="0" name="rooms[{{ $type->id }}]"
                        wire:model.live="rooms.{{ $type->id }}" class="kt-input mb-2" placeholder="0">
                </div>
            @empty
                <p class="text-sm text-gray-500">No room types available.</p>
            @endforelse
        </div>

        @unless ($this->checkOccupancy())
            <p class="text-red-600 text-sm">
                The number of people exceeds the total selected capacity. Please add additional rooms or change room
                types.
            </p>
        @endunless
    </div>

    <!-- Subtotal Section -->
    <div class="mt-2 flex items-center justify-between border-t pt-4">
        <div>
            <span class="font-semibold">Hotel Subtotal:</span>
            <span>{{ $currency_symbol }} {{ number_format($subtotal_hotels, 2) }}</span>
        </div>
    </div>
</div>
