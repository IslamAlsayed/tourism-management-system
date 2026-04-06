@php
    $showRoute = null;
    $routeParams = [];
    if (isset($id)) $routeParams[] = $id;
    if (request()->has('type')) $routeParams['type'] = request()->query('type');

    if (isset($models)) {
        if (Route::has("{$models}.show")) {
            $showRoute = route("{$models}.show", $routeParams);
        } else {
            $currentRoute = Route::currentRouteName();
            if ($currentRoute) {
                $segments = explode('.', $currentRoute);
                array_pop($segments);
                $derivedRoute = implode('.', $segments) . '.show';
                if (Route::has($derivedRoute)) {
                    $showRoute = route($derivedRoute, $routeParams);
                }
            }
        }
    }
@endphp

@if ($showRoute)
    <a href="{{ $showRoute }}"
       class="kt-btn kt-btn-sm text-white bg-yellow-500 hover:bg-yellow-600 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 px-3 py-1.5 gap-2 rounded-full font-semibold"
       title="{{ $text ?? __('main.show') }}"
       style="{{ $styles ?? '' }}"
       wire:ignore>
        <i class="fa-duotone fa-solid fa-eye text-base"></i>
        <span>{{ $text ?? __('main.show') }}</span>
    </a>
@endif
