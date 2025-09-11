<div class="mb-4">
    <label class="kt-label mb-4">Main Program Details:</label>
    <div class="grid lg:grid-cols-4 gap-4">
        @foreach ($programDetails as $key => $detail)
            <div class="custom-input">
                <input type="checkbox" name="programDetailIds[]" wire:mode.live="programDetail"
                    class="mb-0 programDetailIds" id="{{ str_replace(' ', '-', $key) }}" value="{{ $key }}">
                <label for="{{ str_replace(' ', '-', $key) }}">
                    {{ $detail }}
                </label>
            </div>
        @endforeach
    </div>
    @error('program_detail_ids')
        <div class="text-red-600 text-sm">{{ $message }}</div>
    @enderror
</div>
