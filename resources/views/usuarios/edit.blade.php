<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Usuario') }} - {{ $user->name }}
            </h2>
            <div class="space-x-2">
                <x-button href="{{ route('usuarios.show', $user) }}" variant="outline">
                    Ver Detalles
                </x-button>
                <x-button href="{{ route('usuarios.index') }}" variant="outline">
                    Volver al Listado
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulario de Información del Usuario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        Información del Usuario
                    </h3>

                    <form method="POST" action="{{ route('usuarios.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                    Datos Personales
                                </h4>

                                <!-- CI -->
                                <div>
                                    <x-input-label for="ci" :value="__('CI (Carnet de Identidad)')" />
                                    <x-text-input id="ci" name="ci" type="text" class="mt-1 block w-full" 
                                                  :value="old('ci', $user->ci)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('ci')" />
                                </div>

                                <!-- Nombre -->
                                <div>
                                    <x-input-label for="name" :value="__('Nombre Completo')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                                  :value="old('name', $user->name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                                  :value="old('email', $user->email)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            <!-- Roles -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                    Roles del Sistema
                                </h4>

                                <div>
                                    <x-input-label :value="__('Roles Asignados')" />
                                    <div class="mt-2 space-y-2">
                                        @foreach($roles as $role)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $role->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                                </div>

                                <!-- Información adicional -->
                                <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                                    <p><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    <p><strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <x-button type="button" variant="outline" onclick="window.history.back()">
                                Cancelar
                            </x-button>
                            <x-button type="submit">
                                Actualizar Usuario
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulario de Restablecimiento de Contraseña -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        Restablecer Contraseña
                    </h3>

                    <form method="POST" action="{{ route('usuarios.reset-password', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nueva Contraseña -->
                            <div>
                                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Mínimo 8 caracteres
                                </p>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button type="submit" variant="secondary">
                                Restablecer Contraseña
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Zona de Peligro -->
            @can('eliminar-usuarios')
            @if($user->id !== auth()->id())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">
                        Zona de Peligro
                    </h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Eliminar este usuario permanentemente del sistema.
                            </p>
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                Esta acción no se puede deshacer.
                            </p>
                        </div>
                        
                        <form method="POST" action="{{ route('usuarios.destroy', $user) }}" 
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <x-button variant="danger" type="submit">
                                Eliminar Usuario
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endcan
        </div>
    </div>
</x-app-layout>