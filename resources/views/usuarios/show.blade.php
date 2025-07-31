@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--account-details] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Detalles del Usuario - {{ $user->name }}
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Información completa del usuario y sus permisos
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex justify-end space-x-2">
        @can('editar-usuarios')
        <x-button 
            href="{{ route('usuarios.edit', $user) }}" 
            variant="secondary"
            icon="icon-[mdi--pencil]"
        >
            Editar Usuario
        </x-button>
        @endcan
        <x-button 
            href="{{ route('usuarios.index') }}" 
            variant="outline"
            icon="icon-[mdi--arrow-left]"
        >
            Volver al Listado
        </x-button>
    </div>

    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--account-box] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                Información del Usuario
            </h3>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div class="space-y-4">
                <div class="flex items-center mb-4">
                    <span class="icon-[mdi--account-details] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                        Información Personal
                    </h4>
                </div>
                
                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--card-account-details] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        CI (Carnet de Identidad)
                    </label>
                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                        {{ $user->ci }}
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--account] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        Nombre Completo
                    </label>
                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                        {{ $user->name }}
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--email] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        Correo Electrónico
                    </label>
                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                        {{ $user->email }}
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="space-y-4">
                <div class="flex items-center mb-4">
                    <span class="icon-[mdi--cog] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                        Información del Sistema
                    </h4>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--shield-account] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        Roles Asignados
                    </label>
                    <div class="space-y-2">
                        @if($user->roles->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        @if($role->name === 'Administrador') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($role->name === 'Jefe') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($role->name === 'Personal') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                        @if($role->name === 'Administrador')
                                            <span class="icon-[mdi--shield-crown] w-3 h-3 mr-1" aria-hidden="true"></span>
                                        @elseif($role->name === 'Jefe')
                                            <span class="icon-[mdi--shield-star] w-3 h-3 mr-1" aria-hidden="true"></span>
                                        @elseif($role->name === 'Personal')
                                            <span class="icon-[mdi--shield-account] w-3 h-3 mr-1" aria-hidden="true"></span>
                                        @else
                                            <span class="icon-[mdi--shield] w-3 h-3 mr-1" aria-hidden="true"></span>
                                        @endif
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-400 dark:text-gray-500 italic bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                                No tiene roles asignados
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--calendar-plus] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        Fecha de Registro
                    </label>
                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                        {{ $user->created_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>

                <div>
                    <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--calendar-edit] w-4 h-4 mr-2 text-gray-500" aria-hidden="true"></span>
                        Última Actualización
                    </label>
                    <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 px-3 py-2 rounded-md border">
                        {{ $user->updated_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    </x-card>

    <!-- Permisos del Usuario -->
    @if($user->roles->count() > 0)
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--shield-check] text-green-600 dark:text-green-400 w-5 h-5 mr-2"></span>
                Permisos Efectivos
            </h3>
        </x-slot>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @php
                $allPermissions = $user->getAllPermissions();
            @endphp
            @if($allPermissions->count() > 0)
                @foreach($allPermissions as $permission)
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                        <span class="icon-[mdi--check-circle] w-3 h-3 mr-1" aria-hidden="true"></span>
                        {{ $permission->name }}
                    </span>
                @endforeach
            @else
                <div class="col-span-full">
                    <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                        <span class="icon-[mdi--shield-off] w-12 h-12 mx-auto mb-2 block" aria-hidden="true"></span>
                        <p>No tiene permisos específicos asignados</p>
                    </div>
                </div>
            @endif
        </div>
    </x-card>
    @endif
</div>
@endsection