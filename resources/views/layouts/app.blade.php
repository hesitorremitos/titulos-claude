<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Sistema de Títulos UATF') }}</title>
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-full">
    <div class="min-h-screen">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex-shrink-0">
                <!-- Logo/Header del Sidebar -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <span class="icon-[mdi--school] w-5 h-5 text-white"></span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">UATF Títulos</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Universidad</p>
                        </div>
                    </div>
                </div>

                <!-- Navegación del Sidebar -->
                <nav class="p-4 space-y-2" x-data="{ mainOpen: true, adminOpen: true }">
                    <!-- Grupo: Menú Principal -->
                    <div class="mb-4">
                        <button @click="mainOpen = !mainOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !mainOpen }"></span>
                            Menú Principal
                        </button>
                        
                        <div x-show="mainOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                <span class="icon-[mdi--view-dashboard] w-5 h-5"></span>
                                <span class="text-sm {{ request()->routeIs('dashboard') ? 'font-medium' : '' }}">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('diplomas.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md {{ request()->routeIs('diplomas.*') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                <span class="icon-[mdi--school] w-5 h-5"></span>
                                <span class="text-sm {{ request()->routeIs('diplomas.*') ? 'font-medium' : '' }}">Diplomas Académicos</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--certificate] w-5 h-5"></span>
                                <span class="text-sm">Títulos Profesionales</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--account-school] w-5 h-5"></span>
                                <span class="text-sm">Bachiller</span>
                            </a>
                        </div>
                    </div>

                    <!-- Grupo: Administración -->
                    <div class="mb-4">
                        <button @click="adminOpen = !adminOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !adminOpen }"></span>
                            Administración
                        </button>
                        
                        <div x-show="adminOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                            <a href="{{ route('usuarios.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md {{ request()->routeIs('usuarios.*') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                                <span class="icon-[mdi--account-multiple] w-5 h-5"></span>
                                <span class="text-sm {{ request()->routeIs('usuarios.*') ? 'font-medium' : '' }}">Usuarios</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--cog] w-5 h-5"></span>
                                <span class="text-sm">Configuración</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Contenido Principal -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- Top Navigation Bar -->
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <!-- Page Title and Description -->
                            <div class="flex-1 min-w-0">
                                @yield('header')
                                {{ $header ?? '' }}
                            </div>

                            <!-- User Actions -->
                            <div class="flex items-center space-x-4">
                                <!-- Notificaciones -->
                                <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="icon-[mdi--bell] w-5 h-5"></span>
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full"></span>
                                </button>
                                
                                <!-- Usuario Profile Dropdown -->
                                <div x-data="{ menuIsOpen: false }" x-on:keydown.esc.window="menuIsOpen = false" class="relative">
                                    <button type="button" class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors hover:bg-gray-50 dark:hover:bg-gray-700" :class="menuIsOpen ? 'bg-primary-50 dark:bg-primary-900/20' : ''" aria-haspopup="true" x-on:click="menuIsOpen = ! menuIsOpen" :aria-expanded="menuIsOpen">
                                        <div class="w-8 h-8 bg-secondary-500 rounded-full flex items-center justify-center">
                                            <span class="icon-[mdi--account] w-5 h-5 text-white"></span>
                                        </div>
                                        <div class="text-sm text-left">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                            <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                                        </div>
                                        <span class="icon-[mdi--chevron-down] w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': menuIsOpen }"></span>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div x-cloak x-show="menuIsOpen" x-on:click.outside="menuIsOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-trap="menuIsOpen" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 z-50">
                                        <!-- Profile Section -->
                                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                            <a href="{{ route('profile.index') }}" class="flex items-center space-x-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 py-2 rounded-md transition-colors" role="menuitem">
                                                <span class="icon-[mdi--account] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Mi Perfil</span>
                                            </a>
                                        </div>
                                        
                                        <!-- Settings Section -->
                                        <div class="py-1">
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--cog] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span>Configuración</span>
                                            </a>
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--help-circle] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span>Ayuda</span>
                                            </a>
                                        </div>
                                        
                                        <!-- Sign Out Section -->
                                        <div class="py-1 border-t border-gray-200 dark:border-gray-700">
                                            <form method="POST" action="{{ route('logout') }}" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center space-x-3 px-6 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left" role="menuitem">
                                                    <span class="icon-[mdi--logout] w-5 h-5"></span>
                                                    <span>Cerrar Sesión</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

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
                    
                    @yield('content')
                    {{ $slot ?? '' }}
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
