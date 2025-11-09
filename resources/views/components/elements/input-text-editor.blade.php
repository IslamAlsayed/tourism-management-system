<div class="mb-4">
    <label for="{{ lcfirst($column) ?: '' }}" class="kt-label mb-2">{{ __('main.' . lcfirst($column) ?: '') }}</label>
    <input id="{{ lcfirst($column) ?: '' }}" type="hidden" name="{{ lcfirst($column) ?: '' }}"
        value="{{ $value ? lcfirst($column) : old(lcfirst($column) ?: '') }}">
    <trix-editor input="{{ lcfirst($column) ?: '' }}"></trix-editor>
    @error(lcfirst($column) ?: '')
        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
