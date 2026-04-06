@php
    $editRoute = null;
    $routeParams = [];
    if (isset($id)) {
        $routeParams[] = $id;
    }
    if (request()->has('type')) {
        $routeParams['type'] = request()->query('type');
    }

    if (isset($models)) {
        // 1. Try direct route name (e.g., 'countries.edit')
        if (Route::has("{$models}.edit")) {
            $editRoute = route("{$models}.edit", $routeParams);
        } else {
            // 2. Derive from current route: 'dashboard.geography.countries.show' → 'dashboard.geography.countries.edit'
            $currentRoute = Route::currentRouteName();
            if ($currentRoute) {
                $segments = explode('.', $currentRoute);
                array_pop($segments);
                $derivedRoute = implode('.', $segments) . '.edit';
                if (Route::has($derivedRoute)) {
                    $editRoute = route($derivedRoute, $routeParams);
                }
            }
        }
    }
@endphp

@if ($editRoute)
    <a href="{{ $editRoute }}"
        class="kt-btn kt-btn-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-150 px-3 py-1.5 gap-2 rounded-full font-semibold"
        title="{{ $text ?? __('main.edit') }}" style="{{ $styles ?? '' }}" wire:ignore>
        <i class="fa-duotone fa-solid fa-pen-to-square text-base"></i>
        <span>{{ $text ?? __('main.edit') }}</span>
    </a>
@endif
