<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'UATF Títulos'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-red-50 via-white to-blue-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <span class="icon-[mdi--school] text-white text-3xl"></span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">UATF Títulos</h1>
            <p class="text-gray-600">Digitalización de Títulos Académicos</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                Universidad Autónoma Tomás Frías - Potosí, Bolivia
            </p>
        </div>
    </div>

    @stack('scripts')
</body>
</html>