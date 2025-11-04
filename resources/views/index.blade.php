<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/all.min.css') }}">
    <!-- Toasts Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
    <!-- Toasts Scripts -->
    <script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>
</head>

<body>
    <div class="toasts">
        <div class="toast toast-error {{ config('toasts.move') != 'enable' ? 'no_move' : '' }}">
            <i class="toast-icon fas fa-circle-xmark"></i>

            <div class="toast-text">
                <div class="text">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="toast-closed toast-action">
                <i class="fas fa-xmark"></i>
            </div>
        </div>
    </div>
</body>

</html>
