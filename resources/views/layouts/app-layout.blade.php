<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'Sistema de Títulos UATF') }}</title>
    
    <!-- Script anti-flash para tema oscuro - Se ejecuta ANTES del renderizado -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
            
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-full">
    <div class="min-h-screen">
        <div class="flex h-screen">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Contenido Principal -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Navbar -->
                @include('layouts.partials.navbar')

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                    @if(session('success'))
                        <div class="mx-6 mt-6">
                            @include('layouts.partials.alert', ['type' => 'success', 'message' => session('success')])
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mx-6 mt-6">
                            @include('layouts.partials.alert', ['type' => 'error', 'message' => session('error')])
                        </div>
                    @endif
                    
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
    
    <!-- Toast Component - Global para toda la aplicación -->
    <livewire:toast />
    
    @stack('scripts')
    @livewireScriptConfig
</body>
</html>