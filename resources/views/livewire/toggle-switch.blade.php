<div wire:key="toggle-{{ isset($table) && $table ? $table : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
    class="toggle-hold mt-1" wire:loading.class="opacity-50">
    <input type="checkbox"
        id="toggle-{{ isset($table) && $table ? $table : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
        class="toggle-input" {{ isset($value) && $value ? 'checked' : '' }} wire:click="toggleHold"
        wire:loading.class="loading">

    <label
        for="toggle-{{ isset($table) && $table ? $table : '' }}-{{ isset($modelId) && $modelId ? $modelId : '' }}-{{ isset($field) && $field ? $field : '' }}"
        wire:loading.class="loading"><span></span></label>
</div>
