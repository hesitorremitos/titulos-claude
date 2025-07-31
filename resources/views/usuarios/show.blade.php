<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalles del Usuario') }}
            </h2>
            <div class="space-x-2">
                @can('editar-usuarios')
                <x-button href="{{ route('usuarios.edit', $user) }}" variant="secondary">
                    Editar Usuario
                </x-button>
                @endcan
                <x-button href="{{ route('usuarios.index') }}" variant="outline">
                    Volver al Listado
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Información Personal
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    CI (Carnet de Identidad)
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                                    {{ $user->ci }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nombre Completo
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Correo Electrónico
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Información del Sistema
                            </h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Roles Asignados
                                </label>
                                <div class="mt-1 space-y-2">
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                                @if($role->name === 'Administrador') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                @elseif($role->name === 'Jefe') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @elseif($role->name === 'Personal') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100 @endif">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 italic">No tiene roles asignados</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Fecha de Registro
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                                    {{ $user->created_at->format('d/m/Y H:i:s') }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Última Actualización
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 px-3 py-2 rounded-md">
                                    {{ $user->updated_at->format('d/m/Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permisos del Usuario -->
                    @if($user->roles->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Permisos Efectivos
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @php
                                $allPermissions = $user->getAllPermissions();
                            @endphp
                            @foreach($allPermissions as $permission)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>