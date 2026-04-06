@php
    $cancelRoute = '#';
    if (isset($cancel_route)) {
        $cancelRoute = $cancel_route;
    } elseif (isset($models)) {
        if (Route::has($models . '.index')) {
            $cancelRoute = route($models . '.index');
        } else {
            $currentRoute = Route::currentRouteName();
            if ($currentRoute) {
                $segments = explode('.', $currentRoute);
                array_pop($segments);
                $derivedRoute = implode('.', $segments) . '.index';
                if (Route::has($derivedRoute)) {
                    $cancelRoute = route($derivedRoute);
                }
            }
        }
    }
@endphp
<div class="flex items-center gap-4">
    <button type="submit" class="kt-btn kt-btn-primary">
        <i class="fa-duotone fa-solid fa-check text-sm me-2"></i>
        {{ __('main.update_type', ['type' => __('main.' . (isset($model) ? $model : singularLowerCaseName($models)))]) }}
    </button>
    <a href="{{ $cancelRoute }}" class="kt-btn kt-btn-outline">
        {{ __('main.cancel') }}
    </a>
</div>

