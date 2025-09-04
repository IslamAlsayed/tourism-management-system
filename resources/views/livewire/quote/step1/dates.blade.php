<div>
    <div class="grid lg:grid-cols-2 gap-6">
        <div>
            <label class="kt-label mb-2">Arrival Date</label>
            <input type="date" name="arrival_date" wire:model.live="arrival_date" class="kt-input">
        </div>

        <div>
            <label class="kt-label mb-2">Departure Date</label>
            <input type="date" name="departure_date" wire:model.live="departure_date" class="kt-input">
        </div>
    </div>

    @if ($invalidDates)
        <p class="text-red-600 text-sm mt-1">
            Departure date must be after arrival date.
        </p>
    @endif
</div>
