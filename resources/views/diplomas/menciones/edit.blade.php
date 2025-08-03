<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Mención') }}
            </h2>
            <a href="{{ route('diplomas.menciones.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-500">
                    <li><a href="{{ route('diplomas.index') }}" class="hover:text-gray-700">Diplomas Académicos</a></li>
                    <li class="flex items-center"><span class="icon-[mdi--chevron-right] w-4 h-4 mx-2"></span></li>
                    <li><a href="{{ route('diplomas.menciones.index') }}" class="hover:text-gray-700">Menciones</a></li>
                    <li class="flex items-center"><span class="icon-[mdi--chevron-right] w-4 h-4 mx-2"></span></li>
                    <li class="text-gray-900 dark:text-gray-100">Editar</li>
                </ol>
            </nav>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Editar Mención Académica</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Modifique la información de la mención académica.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('diplomas.menciones.update', $mencion) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="nombre" value="Nombre de la Mención" />
                                <x-text-input 
                                    id="nombre" 
                                    name="nombre" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    value="{{ old('nombre', $mencion->nombre) }}" 
                                    required 
                                    autofocus />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Carrera -->
                            <div>
                                <x-input-label for="carrera_id" value="Carrera" />
                                <select 
                                    id="carrera_id" 
                                    name="carrera_id" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" 
                                    required>
                                    <option value="">Seleccione una carrera</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $mencion->carrera_id) == $carrera->id ? 'selected' : '' }}>
                                            {{ $carrera->programa }} - {{ $carrera->facultad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('carrera_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.menciones.index') }}'">
                                Cancelar
                            </x-secondary-button>
                            <x-primary-button>
                                Actualizar Mención
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>