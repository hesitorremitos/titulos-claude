<x-app-layout title="Dashboard">
    <x-slot name="header">
        <div class="flex items-center">
            <span class="icon-[mdi--view-dashboard] text-gray-500 dark:text-gray-400 w-6 h-6 mr-3" aria-hidden="true"></span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Card de Bienvenida -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg col-span-full">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--account-circle] text-primary-500 w-12 h-12" aria-hidden="true"></span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        ¡Bienvenido, {{ auth()->user()->name }}!
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Sistema de Gestión de Títulos Académicos - UATF
                    </p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <p class="text-gray-700 dark:text-gray-300">
                Desde este panel podrás gestionar las facultades y carreras de la Universidad Autónoma Tomás Frías.
            </p>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--school] text-blue-500 w-8 h-8" aria-hidden="true"></span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Facultades</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">12</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--book-education] text-green-500 w-8 h-8" aria-hidden="true"></span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Carreras</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">45</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--calendar-month] text-purple-500 w-8 h-8" aria-hidden="true"></span>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Este Mes</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">3</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="#" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-gray-700 group">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-4">
                <span class="icon-[mdi--school] w-6 h-6" aria-hidden="true"></span>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                    Gestionar Facultades
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ver y administrar facultades</p>
            </div>
        </div>
    </a>

    <a href="#" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 dark:border-gray-700 group">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 flex items-center justify-center mr-4">
                <span class="icon-[mdi--book-education] w-6 h-6" aria-hidden="true"></span>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                    Gestionar Carreras
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ver y administrar carreras</p>
            </div>
        </div>
    </a>
</div>
    </div>
</x-app-layout>