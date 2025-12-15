<div wire:key="toggle-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
    class="toggle-hold mt-1" wire:loading.class="opacity-50" wire:ignore>
    <input type="checkbox"
        id="toggle-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
        class="toggle-input" {{ isset($value) && $value ? 'checked' : '' }} wire:click="toggleHold"
        wire:loading.class="loading">

    <label for="toggle-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
        wire:loading.class="loading"><span></span></label>
</div>
