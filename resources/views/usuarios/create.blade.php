@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--account-plus] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Crear Nuevo Usuario
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Registra un nuevo usuario en el sistema
    </p>
@endsection

@section('content')
<div class="space-y-6">
    <x-card>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Formulario de Usuario
                </h3>
                <x-button 
                    href="{{ route('usuarios.index') }}" 
                    variant="outline"
                    icon="icon-[mdi--arrow-left]"
                >
                    Volver al Listado
                </x-button>
            </div>
        </x-slot>

        <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <div class="space-y-4">
                    <div class="flex items-center mb-4">
                        <span class="icon-[mdi--account-details] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                            Información Personal
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
                            value="{{ old('ci') }}"
                            class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                                   bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                                   dark:focus:ring-primary-400 dark:focus:border-primary-400
                                   transition-colors duration-200
                                   {{ $errors->has('ci') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                            placeholder="Ingrese el CI"
                            required 
                            autofocus
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
                            value="{{ old('name') }}"
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
                            value="{{ old('email') }}"
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

                <!-- Información de Acceso -->
                <div class="space-y-4">
                    <div class="flex items-center mb-4">
                        <span class="icon-[mdi--shield-account] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                            Información de Acceso
                        </h4>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="icon-[mdi--lock] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Contraseña
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
                            placeholder="Ingrese la contraseña"
                            required
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                            <span class="icon-[mdi--lock-check] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Confirmar Contraseña
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

                    <!-- Roles -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            <span class="icon-[mdi--shield-account] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                            Roles del Usuario
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
                                        {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
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
                    icon="icon-[mdi--account-plus]"
                >
                    Crear Usuario
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection