<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead
    @routes
</head>
<body>
    @inertia
</body>
</html>
