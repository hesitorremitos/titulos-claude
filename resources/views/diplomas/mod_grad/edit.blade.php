<x-diplomas-layout section-title="Editar Modalidad">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Editar Modalidad de Graduación</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Modifique la información de la modalidad de graduación.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('diplomas.mod_grad.update', $modalidad) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="nombre" value="Nombre de la Modalidad" />
                                <x-text-input 
                                    id="nombre" 
                                    name="nombre" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    value="{{ old('nombre', $modalidad->nombre) }}" 
                                    required 
                                    autofocus />
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
                                    value="{{ old('medio_graduacion', $modalidad->medio_graduacion) }}" 
                                    required />
                                <x-input-error :messages="$errors->get('medio_graduacion')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.mod_grad.index') }}'">
                                Cancelar
                            </x-secondary-button>
                            <x-primary-button>
                                Actualizar Modalidad
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
</x-diplomas-layout>