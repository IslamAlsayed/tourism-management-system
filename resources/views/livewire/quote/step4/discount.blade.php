<div>
    <div class="grid lg:grid-cols-3 gap-4">
        <div>
            <label class="kt-label mb-2">Discount</label>
            <input type="number" step="0.01" name="discount" wire:model.live="discount" class="kt-input"
                value="{{ old('discount', 0) }}">
        </div>
        <div>
            <label class="kt-label mb-2">Tax</label>
            <input type="number" step="0.01" name="tax" wire:model.live="tax" class="kt-input"
                value="{{ old('tax', 0) }}">
        </div>
    </div>
</div>
