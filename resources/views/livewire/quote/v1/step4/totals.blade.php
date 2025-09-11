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
            <span style="width: 220px; display: inline-block;">Subtotal Hotels:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_hotels, 2) }}
            </strong>
        </div>

        <div>
            <span style="width: 220px; display: inline-block;">Subtotal Transport:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_transport, 2) }}
            </strong>
        </div>

        <div>
            <span style="width: 220px; display: inline-block;">Subtotal Services:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $booking->subtotal_services, 2) }}
            </strong>
        </div>

        <div>
            <span style="width: 220px; display: inline-block;">Discount:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $discount, 2) }}
            </strong>
        </div>

        <div>
            <span style="width: 220px; display: inline-block;">Tax:</span>
            <strong>
                {{ $booking->currency->symbol }}
                {{ number_format((float) $calculatedTax, 2) }}
            </strong>
        </div>

        {{-- @if ($discount > 0 || $tax > 0)
            <div class="text-lg mt-2">
                <span style="width: 220px; display: inline-block;text-decoration: line-through;">Before Grand
                    Total:</span>
                <span class="text-lg mt-2" style="text-decoration: line-through;">
                    {{ $booking->currency->symbol }}
                    {{ number_format(round((float) $beforeGrandTotal, 2), 2) }}
                </span>
            </div>
        @endif --}}

        <div class="text-lg mt-2">
            <strong style="width: 220px; display: inline-block;">Grand Total:</strong>

            <strong class="text-lg mt-2">
                {{ $booking->currency->symbol }}
                {{ number_format((float) $grandTotal, 2) }}
            </strong>

            @if ($discount > 0 || $tax > 0)
                <span class="text-red-600" style="text-decoration: line-through;">
                    {{ $booking->currency->symbol }}
                    {{ number_format(round((float) $beforeGrandTotal, 2), 2) }}
                </span>
            @endif
        </div>
    </div>
</div>
