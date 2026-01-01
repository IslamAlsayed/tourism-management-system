<a href="{{ route("$models.create") }}" class="kt-btn bg-primary text-white" toggle-button>
    @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
        {!! $text ?? __('main.create') !!}
    @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
        <i class="fas fa-plus text-white"></i>
    @else
        <i class="fas fa-plus text-white"></i>
        {!! $text ?? __('main.create') !!}
    @endif

    {{ __("main.$model") }}
</a>
