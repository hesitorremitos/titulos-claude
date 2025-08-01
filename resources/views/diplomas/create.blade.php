<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Diploma Académico') }}
            </h2>
            <x-button href="{{ route('diplomas.index') }}" variant="secondary">
                Volver al listado
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Componente Livewire del formulario -->
                    @livewire('diploma-academico-form-component')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
