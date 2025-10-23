<title>@yield('title', 'MixJo Tourism') - World's Largest Geographic Database</title>
<base href="../../">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta content="Sign in page using Tailwind CSS" name="description" />

<meta content="@mixjo" name="twitter:site" />
<meta content="@mixjo" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="Metronic - Tailwind CSS" name="twitter:title" />
<meta content="Sign in page using Tailwind CSS" name="twitter:description" />
<meta content="{{ asset('metronic/media/app/og-image.png') }}" name="twitter:image" />

<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="en_US" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="@mixjo" property="og:site_name" />
<meta content="Metronic - Tailwind CSS" property="og:title" />
<meta content="Sign in page using Tailwind CSS" property="og:description" />
<meta content="{{ asset('metronic/media/app/og-image.png') }}" property="og:image" />

<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="apple-touch-icon" sizes="180x180" />
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="icon" sizes="32x32" type="image/png" />
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="icon" sizes="16x16" type="image/png" />
{{-- <link href="{{ asset('metronic/media/app/favicon.ico') }}" rel="shortcut icon" /> --}}
<link
    href="{{ $settings->app_mini_photo ? asset('storage/' . $settings->app_mini_photo) : asset('metronic/media/app/favicon.ico') }}"
    rel="shortcut icon" />

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />

{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet" /> --}}
<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" />

<link href="{{ asset('metronic/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
<link href="{{ asset('metronic/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/checkbox-input.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/toggle-input.css') }}" rel="stylesheet" />

{{-- Multi Select CSS --}}
<link href="{{ asset('assets/css/multi-select.css') }}" rel="stylesheet">

<link href="{{ asset('metronic/css/styles.css') }}" rel="stylesheet" />

{{-- Text editor --}}
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

@yield('styles')
@stack('styles')
