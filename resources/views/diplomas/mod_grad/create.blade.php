<x-diplomas-layout section-title="Crear Modalidad">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Nueva Modalidad de Graduación</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Complete la información para crear una nueva modalidad de graduación.
                </p>
            </div>

            <form method="POST" action="{{ route('diplomas.mod_grad.store') }}" class="space-y-6">
                @csrf
                <x-form-field label="Medio de Graduación" name="medio_graduacion">
                    <x-form-input-icon 
                        icon="icon-[mdi--school]"
                        id="medio_graduacion"
                        name="medio_graduacion"
                        type="text"
                        value="{{ old('medio_graduacion') }}"
                        required
                        autofocus
                        placeholder="Ej: Trabajo dirigido o de grado" />
                </x-form-field>

                <div class="flex items-center justify-end space-x-3">
                    <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.mod_grad.index') }}'">
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