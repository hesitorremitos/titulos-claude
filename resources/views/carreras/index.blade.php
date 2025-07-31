@extends('layouts.app')

@section('page-title', 'Gestión de Carreras')

@section('breadcrumbs')
<nav class="text-sm text-gray-600 dark:text-gray-400 mb-6">
    <ol class="list-none p-0 inline-flex">
        <li class="flex items-center">
            <a href="{{ route('dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
            <span class="icon-[mdi--chevron-right] w-4 h-4 mx-2" aria-hidden="true"></span>
        </li>
        <li class="text-gray-500">Carreras</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="space-y-6">
    <x-card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Carreras
                </h3>
                @can('crear-carreras')
                <x-button 
                    href="{{ route('carreras.create') }}" 
                    icon="icon-[mdi--plus]"
                >
                    Nueva Carrera
                </x-button>
                @endcan
            </div>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Código
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Programa
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Facultad
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($carreras as $carrera)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="icon-[mdi--school-outline] text-primary-600 dark:text-primary-400 w-5 h-5 mr-3" aria-hidden="true"></span>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $carrera->id }}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $carrera->programa }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-white">{{ $carrera->facultad->nombre ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <x-button 
                        href="{{ route('carreras.show', $carrera) }}" 
                        variant="outline" 
                        size="sm"
                        icon="icon-[mdi--eye]"
                    >
                        Ver
                    </x-button>
                    
                    @can('editar-carreras')
                    <x-button 
                        href="{{ route('carreras.edit', $carrera) }}" 
                        variant="secondary" 
                        size="sm"
                        icon="icon-[mdi--pencil]"
                    >
                        Editar
                    </x-button>
                    @endcan
                    
                    @can('eliminar-carreras')
                    <form method="POST" action="{{ route('carreras.destroy', $carrera) }}" class="inline" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta carrera?')">
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
                    @endcan
                </td>
            </tr>
        @endforeach
                </tbody>
            </table>
        </div>

        @if($carreras->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $carreras->links() }}
        </div>
        @endif
    </x-card>
</div>
@endsection
