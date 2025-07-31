<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Nuevo Usuario') }}
            </h2>
            <x-button href="{{ route('usuarios.index') }}" variant="outline">
                Volver al Listado
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Información Personal
                                </h3>

                                <!-- CI -->
                                <div>
                                    <x-input-label for="ci" :value="__('CI (Carnet de Identidad)')" />
                                    <x-text-input id="ci" name="ci" type="text" class="mt-1 block w-full" 
                                                  :value="old('ci')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('ci')" />
                                </div>

                                <!-- Nombre -->
                                <div>
                                    <x-input-label for="name" :value="__('Nombre Completo')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                                  :value="old('name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                                  :value="old('email')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            <!-- Información de Acceso -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Información de Acceso
                                </h3>

                                <!-- Contraseña -->
                                <div>
                                    <x-input-label for="password" :value="__('Contraseña')" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>

                                <!-- Roles -->
                                <div>
                                    <x-input-label :value="__('Roles')" />
                                    <div class="mt-2 space-y-2">
                                        @foreach($roles as $role)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $role->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <x-button type="button" variant="outline" onclick="window.history.back()">
                                Cancelar
                            </x-button>
                            <x-button type="submit">
                                Crear Usuario
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>