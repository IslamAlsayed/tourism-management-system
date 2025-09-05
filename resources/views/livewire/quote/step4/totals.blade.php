<div class="space-y-4">
    {{-- Inputs --}}
    <div class="grid lg:grid-cols-3 gap-4">
        <div>
            <label class="kt-label mb-2">Discount</label>
            <input type="number" step="0.01" name="discount" wire:model.live="discount" class="kt-input">
        </div>
        <div>
            <label class="kt-label mb-2">Tax (%)</label>
            <input type="number" step="0.01" name="tax" wire:model.live="tax" class="kt-input">
        </div>
    </div>

    {{-- Totals --}}
    <div class="mt-4">
        <div>
            <span>Subtotal Hotels:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_hotels, 2) }}
            </strong>
        </div>

        <div>
            <span>Subtotal Transport:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_transport, 2) }}
            </strong>
        </div>

        <div>
            <span>Subtotal Services:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_services, 2) }}
            </strong>
        </div>

        <div>
            <span>Discount:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $discount, 2) }}
            </strong>
        </div>

        <div>
            <span>Tax:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $calculatedTax, 2) }}
            </strong>
        </div>

        @if ($discount > 0 || $tax > 0)
            <div class="text-lg mt-2">
                <strong>Before Grand Total:</strong>
                <strong class="text-lg mt-2">
                    {{ $booking->currency->symbol }}
                    {{ number_format(round((float) $beforeGrandTotal, 2), 2) }}
                </strong>
            </div>
        @endif

        <div class="text-lg mt-2">
            <strong>Grand Total:</strong>
            <strong class="text-lg mt-2">
                {{ $booking->currency->symbol }}
                {{ number_format((float) $grandTotal, 2) }}
            </strong>
        </div>
    </div>
</div>
