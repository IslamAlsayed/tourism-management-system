<div>
    <div class="kt-card p-4">
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Create New Booking</h2>
                <div class="text-gray-500">Step 1 of 4: Customer Details</div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <form wire:submit.prevent="submitStep1" class="space-y-6">
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
                <label for="customer.name" class="kt-label mb-2">Full Name *</label>
                <input type="text" id="customer.name" wire:model="customer.name"
                    class="kt-input @error('customer.name') border-red-500 @enderror"
                    placeholder="Enter your full name">
                @error('customer.name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="customer.email" class="kt-label mb-2">Email Address *</label>
                    <input type="email" id="customer.email" wire:model="customer.email"
                        class="kt-input @error('customer.email') border-red-500 @enderror"
                        placeholder="Enter your email address">
                    @error('customer.email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="customer.phone" class="kt-label mb-2">Phone Number *</label>
                    <input type="text" id="customer.phone" wire:model="customer.phone"
                        class="kt-input @error('customer.phone') border-red-500 @enderror"
                        placeholder="Enter your phone number">
                    @error('customer.phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="customer.nationality" class="kt-label mb-2">Nationality *</label>
                <select id="customer.nationality" wire:model="customer.nationality"
                    class="kt-select @error('customer.nationality') border-red-500 @enderror">
                    <option value="">Select your nationality</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
                @error('customer.nationality')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="customer.address" class="kt-label mb-2">Address *</label>
                <textarea id="customer.address" wire:model="customer.address" rows="3"
                    class="kt-input @error('customer.address') border-red-500 @enderror" placeholder="Enter your address"></textarea>
                @error('customer.address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="submit" class="kt-btn kt-btn-primary">
                    Continue to Accommodation
                </button>
            </div>
        </form>
    </div>
</div>
