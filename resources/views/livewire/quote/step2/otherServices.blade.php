<div class="kt-card p-4 mb-4">
    <h4 class="text-lg font-semibold mb-3">Other Services</h4>

    <div class="space-y-3">
        <div class="grid lg:grid-cols-4 gap-4 font-semibold text-sm text-gray-500">
            <div>Service</div>
            <div>Quantity</div>
            <div>Unit Price</div>
            <div>Total Price</div>
        </div>

        @foreach ($otherServices as $service)
            <div class="grid lg:grid-cols-4 gap-4 items-center">
                {{-- اختيار الخدمة --}}
                <div class="flex items-center gap-2">
                    <label>
                        <input type="checkbox" name="services[{{ $service->id }}][selected]"
                            wire:model="services.{{ $service->id }}.selected" class="kt-checkbox" />
                        {{ $service->name_en ?? $service->name }}
                    </label>
                </div>

                {{-- الكمية --}}
                <input type="number" min="0" wire:model.live="services.{{ $service->id }}.quantity"
                    class="kt-input" placeholder="Quantity" />

                {{-- السعر --}}
                <input type="number" readonly wire:model="services.{{ $service->id }}.price"
                    class="kt-input bg-gray-100 cursor-not-allowed" />

                {{-- السعر الإجمالي --}}
                <input type="number" name="services[{{ $service->id }}][total_price]" readonly
                    value="{{ $services[$service->id]['total_price'] ?? 0 }}"
                    class="kt-input bg-gray-100 cursor-not-allowed" />
            </div>
        @endforeach
    </div>

    <div class="mt-4 font-semibold">
        Subtotal: {{ $currency_symbol }} {{ number_format($subtotal_services, 2) }}
    </div>
</div>
