<button wire:key="{{ $id ? $id : '' }}-destroy" wire:click="{{ $id ? "destroy($id)" : '' }}"
    style="{{ isset($styles) ? $styles : '' }}" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white"
    wire:loading.attr="disabled" wire:target="destroy" wire:ignore>

    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.delete') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-trash-can text-white"></i>
    @else
        <i class="fas fa-trash-can text-white"></i>
        {!! $text ?? __('main.delete') !!}
    @endif
</button>
