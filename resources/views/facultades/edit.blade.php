@extends('layouts.app')

@section('title', 'Editar Facultad')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--pencil] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Editar Facultad
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Modifica la información de la facultad: {{ $facultad->nombre }}
    </p>
@endsection

@section('content')
<div class="max-w-2xl">
    <x-card title="Información de la Facultad">
        <form action="{{ route('facultades.update', $facultad) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <x-form-input
                label="Nombre de la Facultad"
                name="nombre"
                icon="icon-[mdi--school]"
                placeholder="Ej: Facultad de Ingeniería"
                :value="$facultad->nombre"
                required
            />
            
            <x-form-input
                label="Dirección"
                name="direccion"
                icon="icon-[mdi--map-marker]"
                placeholder="Dirección física de la facultad"
                :value="$facultad->direccion"
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
                    Actualizar Facultad
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
