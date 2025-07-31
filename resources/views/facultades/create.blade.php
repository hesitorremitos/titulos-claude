@extends('layouts.app')

@section('title', 'Nueva Facultad')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--plus] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crear Nueva Facultad
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Registra una nueva facultad en el sistema
    </p>
@endsection

@section('content')
<div class="max-w-2xl">
    <x-card title="Información de la Facultad">
        <form action="{{ route('facultades.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <x-form-input
                label="Nombre de la Facultad"
                name="nombre"
                icon="icon-[mdi--school]"
                placeholder="Ej: Facultad de Ingeniería"
                required
            />
            
            <x-form-input
                label="Dirección"
                name="direccion"
                icon="icon-[mdi--map-marker]"
                placeholder="Dirección física de la facultad"
            />
            
            <div class="flex justify-end space-x-3">
                <x-button 
                    href="{{ route('facultades.index') }}" 
                    variant="outline"
                    icon="icon-[mdi--arrow-left]"
                >
                    Cancelar
                </x-button>
                
                <x-button 
                    type="submit"
                    icon="icon-[mdi--content-save]"
                >
                    Crear Facultad
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
