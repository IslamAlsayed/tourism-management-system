<button wire:key="{{ $id ? $id : '' }}-destroy" wire:click="{{ $id ? "destroy($id)" : '' }}"
    style="{{ isset($styles) ? $styles : '' }}" wire:loading.attr="disabled" wire:target="destroy"
    class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">

    @if (isset($button_display_mode) && $button_display_mode === 'text')
        {!! $text ?? __('main.delete') !!}
    @else
        <i class="fas fa-trash-can text-white"></i>
    @endif
</button>
