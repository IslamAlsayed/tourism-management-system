<form wire:submit.prevent="submit" class="space-y-6">
    <div class="grid lg:grid-cols-3 gap-6">
        <div>
            <label class="kt-label mb-2">First Name</label>
            <input type="text" wire:model.live="first_name" class="kt-input">
            @error('first_name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="kt-label mb-2">Last Name</label>
            <input type="text" wire:model.live="last_name" class="kt-input">
            @error('last_name')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="kt-label mb-2">Email</label>
            <input type="email" wire:model.live="email" class="kt-input">
            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="kt-label mb-2">Phone</label>
            <input type="text" wire:model.live="phone" class="kt-input">
            @error('phone')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="kt-label mb-2">Nationality</label>
            <input type="text" wire:model.live="nationality" class="kt-input">
        </div>

        <div>
            <label class="kt-label mb-2">Currency</label>
            <select wire:model.live="currency_id" class="kt-select">
                <option value="">Select currency</option>
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->code }})</option>
                @endforeach
            </select>
            @error('currency_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="grid lg:grid-cols-2 gap-6 col-span-3">
            <div>
                <label class="kt-label mb-2">Arrival Date</label>
                <input type="date" wire:model.live="arrival_date" class="kt-input">
                @error('arrival_date')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="kt-label mb-2">Departure Date</label>
                <input type="date" wire:model.live="departure_date" class="kt-input">
                @error('departure_date')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div>
            <label class="kt-label mb-2">Adults</label>
            <input type="number" min="1" wire:model.live="adults" class="kt-input">
            @error('adults')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="kt-label mb-2">Children</label>
            <input type="number" min="0" wire:model.live="children" class="kt-input">
        </div>

        <div>
            <label class="kt-label mb-2">Infants</label>
            <input type="number" min="0" wire:model.live="infants" class="kt-input">
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="kt-btn kt-btn-primary">Next</button>
    </div>

    @if (session()->has('success'))
        <div class="text-green-600 mt-3">
            {{ session('success') }}
        </div>
    @endif
</form>
