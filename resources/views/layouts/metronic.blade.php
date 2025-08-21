<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body id="kt_app_body" class="app-default">
    @yield('content')

    @include('layouts.partials.scripts')
    @stack('scripts')
</body>

</html>
