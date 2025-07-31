@extends('layouts.app')

@section('title', 'Detalle de Carrera')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--book-education] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ $carrera->programa }}
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Información detallada de la carrera académica
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Información General -->
    <x-card title="Información General">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--identifier] w-4 h-4 inline mr-1"></span>
                    Código
                </label>
                <p class="text-sm font-mono text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->id }}
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--school] w-4 h-4 inline mr-1"></span>
                    Facultad
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->facultad->nombre }}
                </p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--book-education] w-4 h-4 inline mr-1"></span>
                    Programa Académico
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->programa }}
                </p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--map-marker] w-4 h-4 inline mr-1"></span>
                    Dirección
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->direccion ?? 'No especificada' }}
                </p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <x-button 
                href="{{ route('carreras.index') }}" 
                variant="outline"
                icon="icon-[mdi--arrow-left]"
            >
                Volver
            </x-button>
            
            <x-button 
                href="{{ route('facultades.show', $carrera->facultad) }}" 
                variant="outline"
                icon="icon-[mdi--school]"
            >
                Ver Facultad
            </x-button>
            
            <x-button 
                href="{{ route('carreras.edit', $carrera) }}" 
                variant="secondary"
                icon="icon-[mdi--pencil]"
            >
                Editar
            </x-button>
        </div>
    </x-card>

    <!-- Información de Fechas -->
    <x-card title="Información del Sistema">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--calendar-plus] w-4 h-4 inline mr-1"></span>
                    Fecha de Registro
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--calendar-edit] w-4 h-4 inline mr-1"></span>
                    Última Actualización
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $carrera->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
    </x-card>

    <!-- Estadísticas (placeholder para futuras funcionalidades) -->
    <x-card title="Estadísticas" description="Información estadística de la carrera">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <span class="icon-[mdi--certificate] text-blue-600 dark:text-blue-400 w-8 h-8 mx-auto mb-2 block" aria-hidden="true"></span>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Diplomas Académicos</p>
            </div>
            
            <div class="text-center p-6 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <span class="icon-[mdi--school] text-green-600 dark:text-green-400 w-8 h-8 mx-auto mb-2 block" aria-hidden="true"></span>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Títulos Profesionales</p>
            </div>
            
            <div class="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <span class="icon-[mdi--trophy] text-purple-600 dark:text-purple-400 w-8 h-8 mx-auto mb-2 block" aria-hidden="true"></span>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Títulos de Bachiller</p>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Las estadísticas se mostrarán cuando se implementen los módulos de gestión de títulos
            </p>
        </div>
    </x-card>
</div>
@endsection
