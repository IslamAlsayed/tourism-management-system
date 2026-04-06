@php
    $destroyRoute = '#';
    if (isset($model) && isset($id)) {
        // 1. Try direct route name (e.g., 'countries.destroy')
        if (Route::has("$model.destroy")) {
            $destroyRoute = route("$model.destroy", $id);
        } else {
            // 2. Derive from current route: 'dashboard.geography.countries.show' → 'dashboard.geography.countries.destroy'
            $currentRoute = Route::currentRouteName();
            if ($currentRoute) {
                $segments = explode('.', $currentRoute);
                array_pop($segments); // remove 'show'
                $derivedRoute = implode('.', $segments) . '.destroy';
                if (Route::has($derivedRoute)) {
                    $destroyRoute = route($derivedRoute, $id);
                }
            }
        }
    }
@endphp
@if ($destroyRoute !== '#')
<form action="{{ $destroyRoute }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline bg-danger text-white">
        @if (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'text')
            {{ __('main.delete') }}
        @elseif (isset(getActiveUser()->button_display_mode) && getActiveUser()->button_display_mode === 'icon')
            <i class="fa-duotone fa-solid fa-trash-can text-white"></i>
        @else
            <i class="fa-duotone fa-solid fa-trash-can text-white"></i>
            {{ __('main.delete') }}
        @endif
    </button>
</form>
@endif
