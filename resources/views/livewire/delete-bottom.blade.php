<button wire:key="{{ isset($modelId) && $modelId ? $modelId : '' }}-destroy" wire:loading.class="opacity-50" wire:ignore
    style="{{ isset($styles) ? $styles : '' }}" wire:click="deleteBottom" wire:loading.attr="disabled"
    class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">

    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.delete') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-trash-can text-white"></i>
    @else
        <i class="fas fa-trash-can text-white"></i>
        {!! $text ?? __('main.delete') !!}
    @endif
</button>
