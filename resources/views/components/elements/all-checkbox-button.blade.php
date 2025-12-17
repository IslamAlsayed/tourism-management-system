<div class="custom-input cursor-pointer" wire:ignore>
    <input type="checkbox" name="{{ isset($name) ? $name : '' }}" id="{{ isset($id) ? $id : '' }}"
        wire:model.live="selectPage" value="{{ isset($value) ? $value : '' }}"
        @isset($slot){{ $slot }}@endisset>
    <label for="{{ isset($id) ? $id : '' }}">{{ isset($label) ? $label : '' }}</label>
</div>
