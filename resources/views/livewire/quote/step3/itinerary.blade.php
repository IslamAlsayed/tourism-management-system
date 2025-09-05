<div class="kt-card p-4 mb-4">
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="space-y-4">
            <div class="kt-card p-4 mb-4">
                <h4 class="text-lg font-semibold mb-3">Itinerary</h4>

                <div class="space-y-4">
                    <div class="grid lg:grid-cols-3 gap-4 font-semibold text-sm text-gray-500">
                        <div>Day #</div>
                        <div>City</div>
                        <div>Description</div>
                    </div>

                    <div class="space-y-3">
                        @foreach ($itinerary as $i => $row)
                            <div class="grid lg:grid-cols-3 gap-4">
                                {{-- Day number --}}
                                <input type="number" class="kt-input"
                                    wire:model.live="itinerary.{{ $i }}.day_number" disabled>

                                {{-- City --}}
                                <select class="kt-select" wire:model.live="itinerary.{{ $i }}.city_id">
                                    <option value="">-- Select City --</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>

                                {{-- Description --}}
                                <textarea class="kt-input" wire:model.live="itinerary.{{ $i }}.description"
                                    placeholder="Visits, activities, notes..."></textarea>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('dashboard.quote.step2', $booking) }}" class="kt-btn kt-btn-light">Back</a>
            <button type="submit" class="kt-btn kt-btn-primary">Next</button>
        </div>
    </form>
</div>
