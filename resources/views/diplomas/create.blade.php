<x-diplomas-layout section-title="Formulario">
    <x-slot name="headerExtra">
        <a href="{{ route('diplomas.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
            Volver a Lista
        </a>
    </x-slot>

    <!-- Formulario Section -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Registrar Nuevo Diploma Académico</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Complete la información del diploma académico. Puede buscar los datos personales a través de la API universitaria o registrarlos manualmente.
                </p>
            </div>
            
            <!-- Livewire Component for Form -->
            @livewire('diploma-academico-form-component')
        </div>
    </div>
</x-diplomas-layout>