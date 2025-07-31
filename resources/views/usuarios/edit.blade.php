@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--account-edit] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Editar Usuario - {{ $user->name }}
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Modifica los datos del usuario y gestiona sus permisos
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex justify-end space-x-2">
        <x-button 
            href="{{ route('usuarios.show', $user) }}" 
            variant="outline"
            icon="icon-[mdi--eye]"
        >
            Ver Detalles
        </x-button>
        <x-button 
            href="{{ route('usuarios.index') }}" 
            variant="outline"
            icon="icon-[mdi--arrow-left]"
        >
            Volver al Listado
        </x-button>
    </div>

    <!-- Formulario de Información del Usuario -->
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--account-details] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                Información del Usuario
            </h3>
        </x-slot>

        <form method="POST" action="{{ route('usuarios.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <div class="space-y-4">
                    <div class="flex items-center mb-4">
                        <span class="icon-[mdi--account-details] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                            Datos Personales
                        </h4>
                    </div>

                    <!-- CI -->
                    <div>
                        <label for="ci" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="icon-[mdi--card-account-details] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            CI (Carnet de Identidad)
                        </label>
                        <input 
                            type="text" 
                            id="ci" 
                            name="ci"
                            value="{{ old('ci', $user->ci) }}"
                            class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   dark:focus:ring-primary-400 dark:focus:border-primary-400
                                   transition-colors duration-200
                                   {{ $errors->has('ci') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="Ingrese el CI"
                            required
                        >
                        @error('ci')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="icon-[mdi--account] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Nombre Completo
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   dark:focus:ring-primary-400 dark:focus:border-primary-400
                                   transition-colors duration-200
                                   {{ $errors->has('name') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="Ingrese el nombre completo"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="icon-[mdi--email] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   dark:focus:ring-primary-400 dark:focus:border-primary-400
                                   transition-colors duration-200
                                   {{ $errors->has('email') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="ejemplo@uatf.edu.bo"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Roles y Información adicional -->
                <div class="space-y-4">
                    <div class="flex items-center mb-4">
                        <span class="icon-[mdi--shield-account] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                            Roles del Sistema
                        </h4>
                    </div>

                    <!-- Roles -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            <span class="icon-[mdi--shield-account] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Roles Asignados
                        </label>
                        <div class="space-y-3 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            @foreach($roles as $role)
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->name }}" 
                                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 
                                               dark:bg-gray-700 rounded"
                                        {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}
                                    >
                                    <span class="ml-3 flex items-center text-sm text-gray-700 dark:text-gray-300">
                                        @if($role->name === 'Administrador')
                                            <span class="icon-[mdi--shield-crown] w-4 h-4 mr-1 text-red-500" aria-hidden="true"></span>
                                        @elseif($role->name === 'Jefe')
                                            <span class="icon-[mdi--shield-star] w-4 h-4 mr-1 text-blue-500" aria-hidden="true"></span>
                                        @elseif($role->name === 'Personal')
                                            <span class="icon-[mdi--shield-account] w-4 h-4 mr-1 text-green-500" aria-hidden="true"></span>
                                        @else
                                            <span class="icon-[mdi--shield] w-4 h-4 mr-1 text-gray-500" aria-hidden="true"></span>
                                        @endif
                                        {{ $role->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Información adicional -->
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información del Sistema</h5>
                        <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                            <p class="flex items-center">
                                <span class="icon-[mdi--calendar-plus] w-4 h-4 mr-2" aria-hidden="true"></span>
                                <strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="flex items-center">
                                <span class="icon-[mdi--calendar-edit] w-4 h-4 mr-2" aria-hidden="true"></span>
                                <strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 space-x-4 border-t border-gray-200 dark:border-gray-700">
                <x-button 
                    type="button" 
                    variant="outline" 
                    icon="icon-[mdi--cancel]"
                    onclick="window.history.back()"
                >
                    Cancelar
                </x-button>
                <x-button 
                    type="submit"
                    icon="icon-[mdi--content-save]"
                >
                    Actualizar Usuario
                </x-button>
            </div>
        </form>
    </x-card>

    <!-- Formulario de Restablecimiento de Contraseña -->
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--lock-reset] text-orange-600 dark:text-orange-400 w-5 h-5 mr-2"></span>
                Restablecer Contraseña
            </h3>
        </x-slot>

        <form method="POST" action="{{ route('usuarios.reset-password', $user) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nueva Contraseña -->
                <div>
                    <label for="password" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="icon-[mdi--lock] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                        Nueva Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                               bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               dark:focus:ring-primary-400 dark:focus:border-primary-400
                               transition-colors duration-200
                               {{ $errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                        placeholder="Mínimo 8 caracteres"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Mínimo 8 caracteres
                    </p>
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="icon-[mdi--lock-check] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                        Confirmar Nueva Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                               bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                               dark:focus:ring-primary-400 dark:focus:border-primary-400
                               transition-colors duration-200
                               {{ $errors->has('password_confirmation') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                        placeholder="Confirme la contraseña"
                        required
                    >
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                <x-button 
                    type="submit" 
                    variant="secondary"
                    icon="icon-[mdi--lock-reset]"
                >
                    Restablecer Contraseña
                </x-button>
            </div>
        </form>
    </x-card>

    <!-- Zona de Peligro -->
    @can('eliminar-usuarios')
    @if($user->id !== auth()->id())
    <x-card class="border-l-4 border-red-500">
        <x-slot name="header">
            <h3 class="text-lg font-medium text-red-600 dark:text-red-400 flex items-center">
                <span class="icon-[mdi--alert-circle] w-5 h-5 mr-2"></span>
                Zona de Peligro
            </h3>
        </x-slot>
        
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Eliminar este usuario permanentemente del sistema.
                </p>
                <p class="text-xs text-red-600 dark:text-red-400 mt-1 flex items-center">
                    <span class="icon-[mdi--warning] w-3 h-3 mr-1"></span>
                    Esta acción no se puede deshacer.
                </p>
            </div>
            
            <form method="POST" action="{{ route('usuarios.destroy', $user) }}" 
                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <x-button 
                    variant="danger" 
                    type="submit"
                    icon="icon-[mdi--delete]"
                >
                    Eliminar Usuario
                </x-button>
            </form>
        </div>
    </x-card>
    @endif
    @endcan
</div>
@endsection