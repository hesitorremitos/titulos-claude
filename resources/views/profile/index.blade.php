@extends('layouts.app')

@section('title', 'Configuraciones')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--account-cog] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Configuraciones del Perfil
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Gestiona tu información personal y configuraciones de seguridad
    </p>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Información Personal -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--account-edit] text-primary-600 dark:text-primary-400 w-5 h-5 mr-2"></span>
                Información Personal
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Actualiza tu información básica de perfil
            </p>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--account] w-4 h-4 inline mr-1"></span>
                        Nombre Completo
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                        required
                    >
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CI -->
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--card-account-details] w-4 h-4 inline mr-1"></span>
                        Carnet de Identidad
                    </label>
                    <input 
                        type="text" 
                        id="ci" 
                        name="ci" 
                        value="{{ old('ci', $user->ci) }}"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                        required
                    >
                    @error('ci')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span class="icon-[mdi--email] w-4 h-4 inline mr-1"></span>
                    Correo Electrónico
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                    required
                >
                @error('email')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                >
                    <span class="icon-[mdi--content-save] w-4 h-4 mr-2"></span>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Cambiar Contraseña -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                <span class="icon-[mdi--lock-reset] text-orange-600 dark:text-orange-400 w-5 h-5 mr-2"></span>
                Cambiar Contraseña
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                Actualiza tu contraseña para mantener tu cuenta segura
            </p>
        </div>
        
        <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Contraseña Actual -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span class="icon-[mdi--lock] w-4 h-4 inline mr-1"></span>
                    Contraseña Actual
                </label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                    required
                >
                @error('current_password')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nueva Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--lock-plus] w-4 h-4 inline mr-1"></span>
                        Nueva Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                        required
                    >
                    @error('password')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <span class="icon-[mdi--lock-check] w-4 h-4 inline mr-1"></span>
                        Confirmar Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                        required
                    >
                </div>
            </div>

            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                >
                    <span class="icon-[mdi--lock-reset] w-4 h-4 mr-2"></span>
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>

    <!-- Zona de Peligro -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-red-200 dark:border-red-700">
        <div class="px-6 py-4 border-b border-red-200 dark:border-red-700">
            <h3 class="text-lg font-medium text-red-900 dark:text-red-400 flex items-center">
                <span class="icon-[mdi--alert-circle] text-red-600 dark:text-red-400 w-5 h-5 mr-2"></span>
                Zona de Peligro
            </h3>
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">
                Acciones irreversibles de la cuenta
            </p>
        </div>
        
        <div class="p-6">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-md p-4">
                <div class="flex items-start">
                    <span class="icon-[mdi--alert] text-red-600 dark:text-red-400 w-5 h-5 mr-3 mt-0.5 flex-shrink-0"></span>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-red-900 dark:text-red-400">
                            Eliminar Cuenta
                        </h4>
                        <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                            Una vez eliminada tu cuenta, todos los datos serán permanentemente eliminados. Esta acción no se puede deshacer.
                        </p>
                        <div class="mt-4">
                            <button 
                                type="button"
                                onclick="openDeleteModal()"
                                class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            >
                                <span class="icon-[mdi--account-remove] w-4 h-4 mr-2"></span>
                                Eliminar Cuenta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar Cuenta -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeDeleteModal()"></div>
        
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                            <span class="icon-[mdi--alert] text-red-600 dark:text-red-400 w-6 h-6"></span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Eliminar Cuenta
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    ¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer y todos tus datos serán eliminados permanentemente.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label for="delete_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Confirma tu contraseña para continuar:
                                </label>
                                <input 
                                    type="password" 
                                    id="delete_password" 
                                    name="password" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Eliminar Cuenta
                    </button>
                    <button 
                        type="button" 
                        onclick="closeDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openDeleteModal() {
    document.getElementById('delete-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('delete_password').value = '';
}
</script>
@endpush
