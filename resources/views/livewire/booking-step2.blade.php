<div>
    <div class="kt-card p-4">
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Create New Booking</h2>
                <div class="text-gray-500">Step 2 of 4: Accommodation Details</div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <form wire:submit.prevent="submitStep2" class="space-y-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="booking.accommodation_id" class="kt-label mb-2">Select Accommodation *</label>
                <select id="booking.accommodation_id" wire:model="booking.accommodation_id"
                    class="kt-select @error('booking.accommodation_id') border-red-500 @enderror">
                    <option value="">Select an accommodation</option>
                    @foreach ($accommodations as $accommodation)
                        <option value="{{ $accommodation->id }}">{{ $accommodation->name }} -
                            {{ $accommodation->location }}</option>
                    @endforeach
                </select>
                @error('booking.accommodation_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="booking.check_in" class="kt-label mb-2">Check-in Date *</label>
                    <input type="date" id="booking.check_in" wire:model="booking.check_in"
                        class="kt-input @error('booking.check_in') border-red-500 @enderror">
                    @error('booking.check_in')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="booking.check_out" class="kt-label mb-2">Check-out Date *</label>
                    <input type="date" id="booking.check_out" wire:model="booking.check_out"
                        class="kt-input @error('booking.check_out') border-red-500 @enderror">
                    @error('booking.check_out')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="booking.adults" class="kt-label mb-2">Number of Adults *</label>
                    <input type="number" id="booking.adults" wire:model="booking.adults"
                        class="kt-input @error('booking.adults') border-red-500 @enderror" min="1"
                        max="20">
                    @error('booking.adults')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="booking.children" class="kt-label mb-2">Number of Children</label>
                    <input type="number" id="booking.children" wire:model="booking.children"
                        class="kt-input @error('booking.children') border-red-500 @enderror" min="0"
                        max="10">
                    @error('booking.children')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($totalNights > 0 && $totalPrice > 0)
                <div class="bg-gray-100 p-4 rounded-md mt-4">
                    <h3 class="text-lg font-medium mb-3">Booking Summary</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div class="font-medium">Total Nights:</div>
                        <div>{{ $totalNights }}</div>

                        <div class="font-medium">Adults:</div>
                        <div>{{ $booking['adults'] }}</div>

                        <div class="font-medium">Children:</div>
                        <div>{{ $booking['children'] }}</div>

                        <div class="font-medium">Check-in:</div>
                        <div>{{ \Carbon\Carbon::parse($booking['check_in'])->format('M d, Y') }}</div>

                        <div class="font-medium">Check-out:</div>
                        <div>{{ \Carbon\Carbon::parse($booking['check_out'])->format('M d, Y') }}</div>

                        <div class="font-medium text-lg border-t pt-2 mt-2">Total Price:</div>
                        <div class="text-lg font-bold border-t pt-2 mt-2">${{ number_format($totalPrice, 2) }}</div>
                    </div>
                </div>
            @endif

            <div class="flex justify-between space-x-3">
                <button type="button" wire:click="goBack" class="kt-btn kt-btn-secondary">
                    Back to Customer Details
                </button>
                <button type="submit" class="kt-btn kt-btn-primary">
                    Continue to Payment
                </button>
            </div>
        </form>
    </div>
</div>
