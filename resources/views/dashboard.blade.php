@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--view-dashboard] text-gray-500 dark:text-gray-400 w-6 h-6 mr-3" aria-hidden="true"></span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
    </div>
@endsection

@section('content')
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
    <x-stat-card 
        icon="mdi--school" 
        icon-color="text-blue-500"
        title="Total Facultades"
        value="12"
    />

    <x-stat-card 
        icon="mdi--book-education" 
        icon-color="text-green-500"
        title="Total Carreras"
        value="45"
    />

    <x-stat-card 
        icon="mdi--calendar-month" 
        icon-color="text-purple-500"
        title="Este Mes"
        value="3"
    />
</div>

<!-- Acciones rápidas -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-quick-action 
        href="#"
        icon="mdi--school"
        icon-color="text-blue-500"
        title="Gestionar Facultades"
        description="Ver y administrar facultades"
    />

    <x-quick-action 
        href="#"
        icon="mdi--book-education"
        icon-color="text-green-500"
        title="Gestionar Carreras"
        description="Ver y administrar carreras"
    />
</div>
@endsection