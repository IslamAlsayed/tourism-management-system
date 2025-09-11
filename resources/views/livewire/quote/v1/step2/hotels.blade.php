<div class="kt-card p-4 mb-4">
    <h4 class="text-lg font-semibold mb-3">Hotels (optional)</h4>

    <div class="grid lg:grid-cols-1 gap-6">
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
            <input type="text" class="kt-input mb-2" name="nights" wire:model="nights" readonly />
        </div>

        <div>
            <label class="kt-label mb-2">counties</label>
            <p>multi select</p>
        </div>

        <div>
            <label class="kt-label mb-2">cities</label>
            <p>multi select</p>
        </div>

        <div>
            <label class="kt-label mb-2">stars</label>

            {{-- <div> --}}
            <div class="flex  gap-2">
                <div><input type="checkbox" name="stars[]" id="star-1" value="1">
                    <label for="star-1">1 star</label>
                </div>
                <div> <input type="checkbox" name="stars[]" id="star-2" value="2">
                    <label for="star-2">2 stars</label>
                </div>
                <div> <input type="checkbox" name="stars[]" id="star-3" value="3">
                    <label for="star-3">3 stars</label>
                </div>
                <div> <input type="checkbox" name="stars[]" id="star-4" value="4">
                    <label for="star-4">4 stars</label>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-4 gap-4">
            <!-- Hotel Selection -->
            <div>
                <label class="kt-label mb-2">Hotel 3 stars</label>
                <select class="kt-select mb-2" wire:model.live="hotel_id">
                    <option value="">Select hotel</option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                    @endforeach
                </select>

                @error('hotel_id')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hotel Selection -->
            <div>
                <label class="kt-label mb-2">Hotel 4 stars</label>
                <select class="kt-select mb-2" wire:model.live="hotel_id">
                    <option value="">Select hotel</option>
                    @foreach ($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                    @endforeach
                </select>

                @error('hotel_id')
                    <span class="text-red-600 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Season Selection -->

        <div>
            <label class="kt-label mb-2">seasons</label>
            <div class="flex  gap-2">
                <div><input type="checkbox" name="seasons[]" id="season-1" value="1">
                    <label for="season-1">1 season</label>
                </div>
                <div> <input type="checkbox" name="seasons[]" id="season-2" value="2">
                    <label for="season-2">2 seasons</label>
                </div>
                <div> <input type="checkbox" name="seasons[]" id="season-3" value="3">
                    <label for="season-3">3 seasons</label>
                </div>
                <div> <input type="checkbox" name="seasons[]" id="season-4" value="4">
                    <label for="season-4">4 seasons</label>
                </div>
            </div>
        </div>
        {{-- <div>
            <label class="kt-label mb-2">Season</label>
            <select class="kt-select mb-2" wire:model.live="hotel_season_id" @disabled(!$hotel_id)>
                <option value="">Select season</option>
                @if ($seasons && $seasons->count())
                    @foreach ($seasons as $season)
                        <option value="{{ $season->id }}">
                            {{ $season->season_name }} ({{ $season->start_date }} - {{ $season->end_date }})
                        </option>
                    @endforeach
                @endif
            </select>

            @error('hotel_season_id')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror
        </div> --}}
    </div>

    <div class="mt-6">
        <h5 class="text-lg font-semibold mb-3">Rooms & Quantities</h5>
        <div class="grid lg:grid-cols-3 gap-6">
            @forelse ($roomTypes as $type)
                <div>
                    <label for="room-{{ $type->id }}" class="kt-label mb-2">
                        {{ $type->name_en ?? $type->name }} (max {{ $type->max_occupancy }})
                    </label>

                    <input type="checkbox" min="0" wire:model.live="rooms.{{ $type->id }}"
                        class="kt-input mb-2" id="room-{{ $type->id }}" placeholder="0">
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
            <span>{{ $currency_symbol }} {{ number_format($subtotal, 2) }}</span>
        </div>
    </div>
</div>
