<div class="align-self-end">
    <label for="longitude" class="kt-label mb-2">{{ __('main.longitude') }}</label>
    <input type="number" step="0.00000001" name="longitude" id="longitude" minlength="-90" maxlength="90" class="kt-input h-[45px]"
        value="{{ old('longitude', $record->longitude ?? '') }}">
    @error('longitude')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
