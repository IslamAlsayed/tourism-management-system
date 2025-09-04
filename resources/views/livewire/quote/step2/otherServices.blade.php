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
                        <input type="checkbox" name="rows[{{ $service->id }}][selected]"
                            wire:model.live="rows.{{ $service->id }}.selected" class="kt-checkbox" />
                        {{ $service->name_en ?? $service->name }}
                    </label>
                </div>

                {{-- الكمية --}}
                <input type="number" min="1" name="rows[{{ $service->id }}][quantity]"
                    wire:model.live="rows.{{ $service->id }}.quantity" class="kt-input" placeholder="Quantity">

                {{-- السعر للوحدة --}}
                <input type="number" min="0" step="0.01" name="rows[{{ $service->id }}][unit_price]"
                    class="kt-input bg-gray-100 cursor-not-allowed" value="{{ $rows[$service->id]['unit_price'] ?? 0 }}"
                    readonly>

                {{-- السعر الإجمالي --}}
                <input type="number" name="rows[{{ $service->id }}][total_price]"
                    class="kt-input bg-gray-100 cursor-not-allowed"
                    value="{{ $rows[$service->id]['total_price'] ?? 0 }}" readonly>
            </div>
        @endforeach
    </div>
    <div class="mt-4 font-semibold">
        Subtotal: {{ $currency_symbol }}{{ number_format($subtotal_other_services, 2) }}
    </div>
</div>
