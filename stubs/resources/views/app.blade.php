<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" sizes="96x96" href="/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @routes
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
