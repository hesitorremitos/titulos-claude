@extends('layouts.app')

@section('title', 'Facultades')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--school] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Gestión de Facultades
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Administra las facultades de la universidad
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <x-card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Facultades
                </h3>
                <x-button 
                    href="{{ route('facultades.create') }}" 
                    icon="icon-[mdi--plus]"
                >
                    Nueva Facultad
                </x-button>
            </div>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Dirección
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Carreras
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($facultades as $facultad)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="icon-[mdi--school] text-primary-600 dark:text-primary-400 w-5 h-5 mr-3" aria-hidden="true"></span>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $facultad->nombre }}
                            </div>
                        </div>
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-gray-300">
                        {{ $facultad->direccion ?? 'No especificada' }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <span class="icon-[mdi--book-education] w-3 h-3 mr-1" aria-hidden="true"></span>
                        {{ $facultad->carreras_count }} {{ $facultad->carreras_count == 1 ? 'carrera' : 'carreras' }}
                    </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <x-button 
                        href="{{ route('facultades.show', $facultad) }}" 
                        variant="outline" 
                        size="sm"
                        icon="icon-[mdi--eye]"
                    >
                        Ver
                    </x-button>
                    
                    <x-button 
                        href="{{ route('facultades.edit', $facultad) }}" 
                        variant="secondary" 
                        size="sm"
                        icon="icon-[mdi--pencil]"
                    >
                        Editar
                    </x-button>
                    
                    <form method="POST" action="{{ route('facultades.destroy', $facultad) }}" class="inline" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta facultad?')">
                        @csrf
                        @method('DELETE')
                        <x-button 
                            variant="danger" 
                            size="sm"
                            icon="icon-[mdi--delete]"
                            type="submit"
                        >
                            Eliminar
                        </x-button>
                    </form>
                </td>
            </tr>
        @endforeach
                </tbody>
            </table>
        </div>

        @if($facultades->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $facultades->links() }}
        </div>
        @endif
    </x-card>
</div>
@endsection
