@extends('layouts.app')

@section('title', 'Usuarios')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--account-multiple] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Gestión de Usuarios
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Administra los usuarios del sistema y sus roles
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <x-card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Usuarios del Sistema
                </h3>
                @can('crear-usuarios')
                <x-button 
                    href="{{ route('usuarios.create') }}" 
                    icon="icon-[mdi--plus]"
                >
                    Nuevo Usuario
                </x-button>
                @endcan
            </div>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            CI
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Roles
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Creado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($users as $user)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->ci }}
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="icon-[mdi--account] text-primary-600 dark:text-primary-400 w-5 h-5 mr-3" aria-hidden="true"></span>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-gray-300">
                        {{ $user->email }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->roles->count() > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($role->name === 'Administrador') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($role->name === 'Jefe') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($role->name === 'Personal') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                    <span class="icon-[mdi--shield-account] w-3 h-3 mr-1" aria-hidden="true"></span>
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            <span class="icon-[mdi--help-circle] w-3 h-3 mr-1" aria-hidden="true"></span>
                            Sin rol
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-gray-300">
                        {{ $user->created_at->format('d/m/Y H:i') }}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <x-button 
                        href="{{ route('usuarios.show', $user) }}" 
                        variant="outline" 
                        size="sm"
                        icon="icon-[mdi--eye]"
                    >
                        Ver
                    </x-button>
                    
                    @can('editar-usuarios')
                    <x-button 
                        href="{{ route('usuarios.edit', $user) }}" 
                        variant="secondary" 
                        size="sm"
                        icon="icon-[mdi--pencil]"
                    >
                        Editar
                    </x-button>
                    @endcan
                    
                    @can('eliminar-usuarios')
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('usuarios.destroy', $user) }}" class="inline" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
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
                    @endif
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex flex-col items-center py-6">
                        <span class="icon-[mdi--account-off] w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" aria-hidden="true"></span>
                        <p>No se encontraron usuarios.</p>
                    </div>
                </td>
            </tr>
        @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
        @endif
    </x-card>
</div>
@endsection