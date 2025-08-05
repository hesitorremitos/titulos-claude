<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guía de Estilos - Sistema de Títulos UATF</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- No external PDF library needed - using native browser viewer -->
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-full">
    <div class="min-h-screen">
        <!-- Header -->
        @include('style-guide.partials.header')

        <!-- Navigation -->
        @include('style-guide.partials.navigation')

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Paleta de Colores -->
            @include('style-guide.sections.colors')

            <!-- Tipografía -->
            @include('style-guide.sections.typography')

            <!-- Botones -->
            @include('style-guide.sections.buttons')

            <!-- Formularios -->
            @include('style-guide.sections.forms')

            <!-- Dashboard Simulation -->
            @include('style-guide.sections.dashboard')

            <!-- Formulario Completo -->
            @include('style-guide.sections.complete-form')

            <!-- Cards -->
            @include('style-guide.sections.cards')

            <!-- Navegación -->
            @include('style-guide.sections.navigation')

            <!-- Iconos -->
            @include('style-guide.sections.icons')

            <!-- Select Buscable -->
            @include('style-guide.sections.searchable-select')

            <!-- Visor PDF -->
            @include('style-guide.sections.pdf-viewer')

            <!-- Notificaciones Toast -->
            @include('style-guide.sections.toasts')

            <!-- Feedback -->
            @include('style-guide.sections.feedback')

            <!-- Footer -->
            @include('style-guide.partials.footer')
        </main>
    </div>

    <!-- Toast Manager Component -->
    @php

    @endphp

    <!-- Scripts -->
    @include('style-guide.partials.scripts')
    
    <!-- Toast Component - Global para el style guide -->
    <livewire:toast />
    
    @livewireScriptConfig
</body>
</html>
