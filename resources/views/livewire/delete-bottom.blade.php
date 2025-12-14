<button wire:key="{{ isset($modelId) && $modelId ? $modelId : '' }}-destroy" wire:loading.class="opacity-50" wire:ignore
    style="{{ isset($styles) ? $styles : '' }}" wire:click="deleteBottom" wire:loading.attr="disabled"
    class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">

    @if (isset($settings->button_display_mode) && $settings->button_display_mode === 'text')
        {!! $text ?? __('main.delete') !!}
    @else
        <i class="fas fa-trash-can text-white"></i>
    @endif
</button>
