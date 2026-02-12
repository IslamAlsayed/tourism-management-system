<div class="align-self-end">
    <label for="latitude" class="kt-label mb-2">{{ __('main.latitude') }}</label>
    <input type="number" step="0.00000001" name="latitude" id="latitude" minlength="-90" maxlength="90" class="kt-input h-[45px]"
        value="{{ old('latitude', $record->latitude ?? '') }}">
    @error('latitude')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
