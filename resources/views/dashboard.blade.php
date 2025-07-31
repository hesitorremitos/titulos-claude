<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-900 font-sans antialiased">
    <div class="min-h-screen">
        <header class="bg-primary-600 dark:bg-primary-700 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="icon-[mdi--school] inline-block mr-3 text-white w-6 h-6" aria-hidden="true"></span>
                        <h1 class="text-xl font-semibold text-white">
                            Sistema de Títulos UATF
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white flex items-center">
                            <span class="icon-[mdi--account-circle] inline-block mr-2 w-5 h-5" aria-hidden="true"></span>
                            Bienvenido, {{ auth()->user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:text-primary-200 transition-colors flex items-center">
                                <span class="icon-[mdi--logout] inline-block mr-1 w-4 h-4" aria-hidden="true"></span>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 dark:border-gray-700 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <span class="icon-[mdi--view-dashboard] inline-block text-gray-400 dark:text-gray-500 w-16 h-16 mb-4" aria-hidden="true"></span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            Dashboard
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            ¡Bienvenido al Sistema de Títulos de la UATF!
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>