<button wire:key="{{ $id ? $id : '' }}-forceDelete" wire:click="{{ $id ? "forceDelete($id)" : '' }}" style="{{ isset($styles) ? $styles : '' }}"
    class="kt-btn kt-btn-sm kt-btn-outline text-white bg-red-800" wire:loading.attr="disabled" wire:target="forceDelete" wire:ignore>

    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.force_delete') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-trash text-white"></i>
    @else
        <i class="fas fa-trash text-white"></i>
        {!! $text ?? __('main.force_delete') !!}
    @endif
</button>
