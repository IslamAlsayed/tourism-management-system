<!DOCTYPE html>
<html>
<head>
    <title>Language Test</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Language Test Page</h1>

    @php
        $testText = [
            'en' => 'Dashboard',
            'ar' => 'لوحة التحكم'
        ];
    @endphp

    <p><strong>App Locale:</strong> {{ app()->getLocale() }}</p>
    <p><strong>Session Locale:</strong> {{ session('locale', 'not set') }}</p>
    <p><strong>getCurrentLocale():</strong> {{ getCurrentLocale() }}</p>
    <p><strong>getLocalizedText(test):</strong> {{ getLocalizedText($testText) }}</p>

    <hr>
    <p><a href="{{ route('language.switch', 'en') }}">Switch to English</a></p>
    <p><a href="{{ route('language.switch', 'ar') }}">Switch to Arabic</a></p>
    <p><a href="{{ route('dashboard') }}">Back to Dashboard</a></p>
</body>
</html>
