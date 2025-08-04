<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Sistema de Títulos UATF') }}</title>
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased">
    <!-- Overlay para móvil -->
    <div id="mobile-overlay" class="fixed inset-0 z-20 bg-black bg-opacity-50 hidden md:hidden"></div>

    <!-- Contenedor principal -->
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        @include('layouts.partials.navbar')
        
        <div class="flex flex-1">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')
            
            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden bg-gray-50 dark:bg-gray-900">
                <!-- Page Header -->
                @if(isset($header) || View::hasSection('header'))
                <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                    <div class="py-6 px-6">
                        @yield('header', $header ?? '')
                    </div>
                </header>
                @endif
                
                <!-- Page Content -->
                <div class="p-6">
                    @if(session('success'))
                        @include('layouts.partials.alert', ['type' => 'success', 'message' => session('success')])
                    @endif
                    
                    @if(session('error'))
                        @include('layouts.partials.alert', ['type' => 'error', 'message' => session('error')])
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Livewire Script Configuration for custom bundle -->
    @livewireScriptConfig
</body>
</html>
