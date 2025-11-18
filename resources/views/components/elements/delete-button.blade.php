<button wire:key="{{ $id ? $id : '' }}-destroy" wire:click="{{ $id ? "destroy($id)" : '' }}"
    style="{{ isset($styles) ? $styles : '' }}" wire:loading.attr="disabled" wire:target="destroy"
    class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
    {!! $text ?? __('main.delete') !!}
</button>
