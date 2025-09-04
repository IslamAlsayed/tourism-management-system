<div>
    <div class="kt-card p-4">
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Review & Submit Booking</h2>
                <div class="text-gray-500">Step 4 of 4</div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <form wire:submit.prevent="submitBooking" class="space-y-6">
            <!-- Booking Summary -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">Booking Summary</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-medium">Reference:</span> {{ $booking_name }}</p>
                        <p><span class="font-medium">Client:</span> {{ $client_name }}</p>
                        <p><span class="font-medium">Email:</span> {{ $client_email }}</p>
                        <p><span class="font-medium">Phone:</span> {{ $client_phone ?: 'Not provided' }}</p>
                        <p><span class="font-medium">Country:</span> {{ $client_country ?: 'Not provided' }}</p>
                    </div>
                    <div>
                        <p><span class="font-medium">Duration:</span> {{ $numberOfDays }} days</p>
                        <p><span class="font-medium">Dates:</span> {{ $arrival_date }} to {{ $departure_date }}</p>
                        <p><span class="font-medium">Adults:</span> {{ $adults }}</p>
                        <p><span class="font-medium">Children:</span> {{ $children }}</p>
                        <p><span class="font-medium">Currency:</span> {{ $currencyCode }}</p>
                    </div>
                </div>
            </div>

            <!-- Accommodations Summary -->
            @if (count($accommodationSelections) > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Accommodations</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Accommodation</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Room Type</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check-in</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Check-out</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rooms</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nights</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($accommodationSelections as $index => $selection)
                                    <tr>
                                        <td class="px-4 py-3">
                                            {{ $accommodationNames[$selection['accommodation_id']] ?? 'Unknown' }}</td>
                                        <td class="px-4 py-3">
                                            {{ $roomTypeNames[$selection['room_type_id']] ?? 'Unknown' }}</td>
                                        <td class="px-4 py-3">{{ $selection['check_in_date'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['check_out_date'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['rooms'] }}</td>
                                        <td class="px-4 py-3">{{ $accommodationNights[$index] ?? 0 }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $currencySymbol }}
                                            {{ number_format($accommodationTotals[$index] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="6" class="px-4 py-3 text-right font-semibold">Accommodations
                                        Subtotal:</td>
                                    <td class="px-4 py-3 font-semibold">{{ $currencySymbol }}
                                        {{ number_format($accommodationsTotal, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Transportation Summary -->
            @if (count($transportationSelections) > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Transportation</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Vehicle</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        From</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        To</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transportationSelections as $selection)
                                    <tr>
                                        <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $selection['type'])) }}
                                        </td>
                                        <td class="px-4 py-3">{{ ucfirst($selection['vehicle_type']) }}</td>
                                        <td class="px-4 py-3">{{ $selection['from_location'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['to_location'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['date'] }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $currencySymbol }}
                                            {{ number_format($selection['price'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="5" class="px-4 py-3 text-right font-semibold">Transportation
                                        Subtotal:</td>
                                    <td class="px-4 py-3 font-semibold">{{ $currencySymbol }}
                                        {{ number_format($transportationTotal, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Additional Services Summary -->
            @if (count($serviceSelections) > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Additional Services</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($serviceSelections as $selection)
                                    <tr>
                                        <td class="px-4 py-3">{{ $selection['name'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['date'] }}</td>
                                        <td class="px-4 py-3">{{ $selection['description'] }}</td>
                                        <td class="px-4 py-3 font-medium">{{ $currencySymbol }}
                                            {{ number_format($selection['price'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-4 py-3 text-right font-semibold">Services Subtotal:
                                    </td>
                                    <td class="px-4 py-3 font-semibold">{{ $currencySymbol }}
                                        {{ number_format($servicesTotal, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Itinerary Summary -->
            @if (count($itineraryDays) > 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Itinerary Summary</h3>
                    <div class="space-y-4">
                        @foreach ($itineraryDays as $dayIndex => $day)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-bold mb-2">Day {{ $dayIndex + 1 }}: {{ $day['title'] }}
                                    ({{ date('l, F j, Y', strtotime($day['date'])) }})</h4>
                                <p class="mb-2"><span class="font-medium">City:</span>
                                    {{ $cityNames[$day['city_id']] ?? 'Not specified' }}</p>
                                <p class="mb-2"><span class="font-medium">Description:</span>
                                    {{ $day['description'] }}</p>

                                @if (count($day['activities']) > 0)
                                    <div class="mt-3">
                                        <h5 class="font-medium mb-2">Activities:</h5>
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($day['activities'] as $activity)
                                                <li>{{ $activity['time'] }} - {{ $activity['name'] }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <h5 class="font-medium mb-2">Meals:</h5>
                                    <p>
                                        @if ($day['meals']['breakfast'])
                                            <span
                                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">Breakfast</span>
                                        @endif
                                        @if ($day['meals']['lunch'])
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">Lunch</span>
                                        @endif
                                        @if ($day['meals']['dinner'])
                                            <span
                                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2">Dinner</span>
                                        @endif
                                        @if (!$day['meals']['breakfast'] && !$day['meals']['lunch'] && !$day['meals']['dinner'])
                                            <span class="text-gray-500">No meals included</span>
                                        @endif
                                    </p>
                                    @if ($day['meals']['notes'])
                                        <p class="mt-1 text-sm text-gray-600">{{ $day['meals']['notes'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Final Calculations -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Final Calculations</h3>

                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="discount_amount" class="kt-label mb-2">Discount Amount</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">{{ $currencySymbol }}</span>
                            <input type="number" id="discount_amount" wire:model="discount_amount" step="0.01"
                                min="0"
                                class="kt-input pl-8 @error('discount_amount') border-red-500 @enderror">
                        </div>
                        @error('discount_amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="discount_percent" class="kt-label mb-2">Discount Percentage</label>
                        <div class="relative">
                            <input type="number" id="discount_percent" wire:model="discount_percent" step="0.01"
                                min="0" max="100"
                                class="kt-input pr-8 @error('discount_percent') border-red-500 @enderror">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                        </div>
                        @error('discount_percent')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="tax_amount" class="kt-label mb-2">Tax Amount</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">{{ $currencySymbol }}</span>
                            <input type="number" id="tax_amount" wire:model="tax_amount" step="0.01"
                                min="0" class="kt-input pl-8 @error('tax_amount') border-red-500 @enderror">
                        </div>
                        @error('tax_amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="tax_percent" class="kt-label mb-2">Tax Percentage</label>
                        <div class="relative">
                            <input type="number" id="tax_percent" wire:model="tax_percent" step="0.01"
                                min="0" max="100"
                                class="kt-input pr-8 @error('tax_percent') border-red-500 @enderror">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">%</span>
                        </div>
                        @error('tax_percent')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2 mt-6">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>{{ $currencySymbol }} {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-green-600">
                        <span>Discount:</span>
                        <span>- {{ $currencySymbol }} {{ number_format($totalDiscount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-orange-600">
                        <span>Tax:</span>
                        <span>+ {{ $currencySymbol }} {{ number_format($totalTax, 2) }}</span>
                    </div>
                    <div class="border-t pt-2 flex justify-between font-bold text-lg">
                        <span>Final Total:</span>
                        <span>{{ $currencySymbol }} {{ number_format($finalTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Email Options -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Email Options</h3>

                <div class="flex items-center mb-4">
                    <input type="checkbox" id="send_email" wire:model="send_email"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="send_email" class="ml-2">Send booking summary to client</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="send_copy_to_me" wire:model="send_copy_to_me"
                        class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="send_copy_to_me" class="ml-2">Send a copy to me</label>
                </div>
            </div>

            <!-- Submission -->
            <div class="flex justify-between">
                <a href="{{ route('bookings.step3') }}" class="kt-btn kt-btn-secondary">Back</a>
                <button type="submit" class="kt-btn kt-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Complete Booking
                </button>
            </div>
        </form>
    </div>
</div>
