@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Panel de Control</h1>
            <p class="text-gray-600 mt-2">Bienvenido al sistema de digitalización de títulos académicos</p>
        </div>

        <!-- Welcome Card -->
        <x-ui.card class="mb-8" padding="p-6 bg-gradient-to-r from-red-50 to-blue-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--school] h-12 w-12 text-red-600"></span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">
                        ¡Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}!
                    </h2>
                    <p class="text-gray-600 mt-1">
                        Estás conectado al sistema de digitalización de títulos académicos de la UATF
                    </p>
                </div>
            </div>
        </x-ui.card>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Titles -->
            <x-ui.stat-card 
                title="Títulos Registrados"
                value="0"
                icon="mdi--file-document-outline"
                icon-color="text-blue-600"
            />

            <!-- Digitalized -->
            <x-ui.stat-card 
                title="Digitalizados"
                value="0"
                icon="mdi--check-circle"
                icon-color="text-green-600"
            />

            <!-- Pending -->
            <x-ui.stat-card 
                title="Pendientes"
                value="0"
                icon="mdi--clock-outline"
                icon-color="text-yellow-600"
            />

            <!-- Faculties -->
            <x-ui.stat-card 
                title="Facultades"
                value="0"
                icon="mdi--school"
                icon-color="text-red-600"
            />
        </div>

        <!-- Quick Actions -->
        <x-ui.card title="Acciones Rápidas">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Register Title -->
                <x-ui.action-button 
                    title="Registrar Título"
                    description="Agregar nuevo título académico"
                    icon="mdi--plus-circle"
                    color="red"
                />

                <!-- Search Titles -->
                <x-ui.action-button 
                    title="Buscar Títulos"
                    description="Consultar títulos existentes"
                    icon="mdi--magnify"
                    color="blue"
                />

                <!-- Manage Faculties -->
                <x-ui.action-button 
                    title="Administrar"
                    description="Gestionar facultades y carreras"
                    icon="mdi--cog"
                    color="green"
                />
            </div>
        </x-ui.card>
    </div>
</div>
@endsection