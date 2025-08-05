@props(['sectionTitle' => 'Diplomas Académicos', 'headerExtra' => null, 'breadcrumbs' => []])

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ 'Diplomas Académicos' . ($sectionTitle && $sectionTitle !== 'Diplomas Académicos' ? ' - ' . $sectionTitle : '') }}
                </h1>
            </div>
        </div>
    </x-slot>

    <!-- Sub Navigation Tabs -->
    <div class="px-6 py-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Sub Navigation">
            <a href="{{ route('diplomas.index') }}" class="{{ request()->routeIs('diplomas.index') ? 'border-b-2 border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600' }} whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                <span class="icon-[mdi--format-list-bulleted] w-4 h-4 mr-2"></span>
                Lista
            </a>
            
            <a href="{{ route('diplomas.create') }}" class="{{ request()->routeIs('diplomas.create') ? 'border-b-2 border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600' }} whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                <span class="icon-[mdi--file-document-plus] w-4 h-4 mr-2"></span>
                Formulario
            </a>
            
            <a href="{{ route('diplomas.menciones.index') }}" class="{{ request()->routeIs('diplomas.menciones.*') ? 'border-b-2 border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600' }} whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                <span class="icon-[mdi--medal] w-4 h-4 mr-2"></span>
                Menciones
            </a>
            
            <a href="{{ route('diplomas.mod_grad.index') }}" class="{{ request()->routeIs('diplomas.mod_grad.*') ? 'border-b-2 border-primary-500 text-primary-600 dark:text-primary-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600' }} whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                <span class="icon-[mdi--school] w-4 h-4 mr-2"></span>
                Modalidades
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </div>
</x-app-layout>
