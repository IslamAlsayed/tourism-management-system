<div>
    <div class="kt-card p-4">
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Create Itinerary</h2>
                <div class="text-gray-500">Step 3 of 4</div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <form wire:submit.prevent="submitStep3" class="space-y-6">
            <!-- Booking Summary -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-2">Booking Summary</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-medium">Reference:</span> {{ $booking_name }}</p>
                        <p><span class="font-medium">Client:</span> {{ $client_name }}</p>
                        <p><span class="font-medium">Duration:</span> {{ $numberOfDays }} days ({{ $arrival_date }} -
                            {{ $departure_date }})</p>
                    </div>
                    <div>
                        <p><span class="font-medium">Adults:</span> {{ $adults }}</p>
                        <p><span class="font-medium">Children:</span> {{ $children }}</p>
                        <p><span class="font-medium">Total Services:</span> {{ $totalServices }}</p>
                    </div>
                </div>
            </div>

            <!-- Itinerary Builder -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Itinerary Builder</h3>

                @foreach ($itineraryDays as $dayIndex => $day)
                    <div class="border rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-bold">Day {{ $dayIndex + 1 }}:
                                {{ date('l, F j, Y', strtotime($day['date'])) }}</h4>
                            @if (count($itineraryDays) > 1)
                                <button type="button" wire:click="removeDay({{ $dayIndex }})"
                                    class="text-red-500 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="kt-label mb-2">City</label>
                            <select wire:model="itineraryDays.{{ $dayIndex }}.city_id"
                                class="kt-select @error('itineraryDays.' . $dayIndex . '.city_id') border-red-500 @enderror">
                                <option value="">Select city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('itineraryDays.' . $dayIndex . '.city_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="kt-label mb-2">Title</label>
                            <input type="text" wire:model="itineraryDays.{{ $dayIndex }}.title"
                                class="kt-input @error('itineraryDays.' . $dayIndex . '.title') border-red-500 @enderror"
                                placeholder="Day title (e.g., Arrival Day, City Tour)">
                            @error('itineraryDays.' . $dayIndex . '.title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="kt-label mb-2">Description</label>
                            <textarea wire:model="itineraryDays.{{ $dayIndex }}.description"
                                class="kt-input @error('itineraryDays.' . $dayIndex . '.description') border-red-500 @enderror" rows="4"
                                placeholder="Detailed description of the day's activities"></textarea>
                            @error('itineraryDays.' . $dayIndex . '.description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Activities for this day -->
                        <div class="mt-6">
                            <h5 class="text-md font-semibold mb-3">Activities</h5>

                            @foreach ($day['activities'] as $activityIndex => $activity)
                                <div class="border-t pt-4 pb-2">
                                    <div class="flex justify-between items-center mb-3">
                                        <h6 class="font-medium">Activity {{ $activityIndex + 1 }}</h6>
                                        <button type="button"
                                            wire:click="removeActivity({{ $dayIndex }}, {{ $activityIndex }})"
                                            class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <label class="kt-label mb-2">Time</label>
                                            <input type="time"
                                                wire:model="itineraryDays.{{ $dayIndex }}.activities.{{ $activityIndex }}.time"
                                                class="kt-input @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex . '.time') border-red-500 @enderror">
                                            @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex .
                                                '.time')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="kt-label mb-2">Activity Name</label>
                                            <input type="text"
                                                wire:model="itineraryDays.{{ $dayIndex }}.activities.{{ $activityIndex }}.name"
                                                class="kt-input @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex . '.name') border-red-500 @enderror"
                                                placeholder="Activity name">
                                            @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex .
                                                '.name')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="kt-label mb-2">Details</label>
                                        <textarea wire:model="itineraryDays.{{ $dayIndex }}.activities.{{ $activityIndex }}.details"
                                            class="kt-input @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex . '.details') border-red-500 @enderror"
                                            rows="2" placeholder="Activity details"></textarea>
                                        @error('itineraryDays.' . $dayIndex . '.activities.' . $activityIndex .
                                            '.details')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-3">
                                <button type="button" wire:click="addActivity({{ $dayIndex }})"
                                    class="kt-btn kt-btn-sm kt-btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 inline" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Activity
                                </button>
                            </div>
                        </div>

                        <!-- Meals for this day -->
                        <div class="mt-6">
                            <h5 class="text-md font-semibold mb-3">Meals</h5>

                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox"
                                            wire:model="itineraryDays.{{ $dayIndex }}.meals.breakfast"
                                            class="form-checkbox h-5 w-5 text-blue-600">
                                        <span class="ml-2">Breakfast</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox"
                                            wire:model="itineraryDays.{{ $dayIndex }}.meals.lunch"
                                            class="form-checkbox h-5 w-5 text-blue-600">
                                        <span class="ml-2">Lunch</span>
                                    </label>
                                </div>

                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox"
                                            wire:model="itineraryDays.{{ $dayIndex }}.meals.dinner"
                                            class="form-checkbox h-5 w-5 text-blue-600">
                                        <span class="ml-2">Dinner</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="kt-label mb-2">Meal Notes (Optional)</label>
                                <textarea wire:model="itineraryDays.{{ $dayIndex }}.meals.notes" class="kt-input" rows="2"
                                    placeholder="Special meal arrangements, restaurant recommendations, etc."></textarea>
                            </div>
                        </div>

                        <!-- Notes for this day -->
                        <div class="mt-6">
                            <label class="kt-label mb-2">Additional Notes (Optional)</label>
                            <textarea wire:model="itineraryDays.{{ $dayIndex }}.notes" class="kt-input" rows="2"
                                placeholder="Any additional notes for this day"></textarea>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-center mt-4">
                    <button type="button" wire:click="addDay" class="kt-btn kt-btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Add Day
                    </button>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('bookings.step2') }}" class="kt-btn kt-btn-secondary">Back</a>
                <button type="submit" class="kt-btn kt-btn-primary">Next</button>
            </div>
        </form>
    </div>
</div>
