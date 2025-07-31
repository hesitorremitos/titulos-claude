@extends('layouts.app')

@section('title', 'Detalle de Facultad')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--school] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            {{ $facultad->nombre }}
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Información detallada de la facultad
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Información General -->
    <x-card title="Información General">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--school] w-4 h-4 inline mr-1"></span>
                    Nombre
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $facultad->nombre }}
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <span class="icon-[mdi--map-marker] w-4 h-4 inline mr-1"></span>
                    Dirección
                </label>
                <p class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                    {{ $facultad->direccion ?? 'No especificada' }}
                </p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
            <x-button 
                href="{{ route('facultades.index') }}" 
                variant="outline"
                icon="icon-[mdi--arrow-left]"
            >
                Volver
            </x-button>
            
            <x-button 
                href="{{ route('facultades.edit', $facultad) }}" 
                variant="secondary"
                icon="icon-[mdi--pencil]"
            >
                Editar
            </x-button>
        </div>
    </x-card>

    <!-- Carreras Asociadas -->
    <x-card title="Carreras Asociadas" :description="'Total: ' . $facultad->carreras->count() . ' carreras'">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Lista de carreras
            </h4>
            <x-button 
                href="{{ route('carreras.create', ['facultad_id' => $facultad->id]) }}" 
                variant="primary"
                size="sm"
                icon="icon-[mdi--plus]"
            >
                Agregar Carrera
            </x-button>
        </div>

        @if($facultad->carreras->count() > 0)
            <div class="space-y-3">
                @foreach($facultad->carreras as $carrera)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <span class="icon-[mdi--book-education] text-primary-600 dark:text-primary-400 w-5 h-5 mr-3" aria-hidden="true"></span>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $carrera->programa }}
                                </h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Código: {{ $carrera->id }}
                                </p>
                            </div>
                        </div>
                        
                        <x-button 
                            href="{{ route('carreras.show', $carrera) }}" 
                            variant="outline"
                            size="sm"
                            icon="icon-[mdi--eye]"
                        >
                            Ver detalle
                        </x-button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <span class="icon-[mdi--book-education] w-12 h-12 text-gray-400 mb-4 block mx-auto" aria-hidden="true"></span>
                <p class="text-gray-500 dark:text-gray-400">No hay carreras registradas en esta facultad</p>
                <x-button 
                    href="{{ route('carreras.create', ['facultad_id' => $facultad->id]) }}" 
                    class="mt-4"
                    icon="icon-[mdi--plus]"
                >
                    Agregar Primera Carrera
                </x-button>
            </div>
        @endif
    </x-card>
</div>
@endsection
