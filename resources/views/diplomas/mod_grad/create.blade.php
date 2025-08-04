<x-diplomas-layout section-title="Crear Modalidad">
    <x-slot name="headerExtra">
        <a href="{{ route('diplomas.modalidades.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
            Volver
        </a>
    </x-slot>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Nueva Modalidad de Graduación</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Complete la información para crear una nueva modalidad de graduación.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('diplomas.modalidades.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="nombre" value="Nombre de la Modalidad" />
                                <x-text-input 
                                    id="nombre" 
                                    name="nombre" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    value="{{ old('nombre') }}" 
                                    required 
                                    autofocus 
                                    placeholder="Ej: Tesis de Grado" />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Medio de Graduación -->
                            <div>
                                <x-input-label for="medio_graduacion" value="Medio de Graduación" />
                                <x-text-input 
                                    id="medio_graduacion" 
                                    name="medio_graduacion" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    value="{{ old('medio_graduacion') }}" 
                                    required
                                    placeholder="Ej: Trabajo dirigido o de grado" />
                                <x-input-error :messages="$errors->get('medio_graduacion')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.modalidades.index') }}'">
                                Cancelar
                            </x-secondary-button>
                            <x-primary-button>
                                Crear Modalidad
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
</x-diplomas-layout>