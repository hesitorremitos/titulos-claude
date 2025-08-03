<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Diplomas Académicos') }}
            </h2>
            <a href="{{ route('diplomas.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
                Volver a Lista
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Pills Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <!-- Lista -->
                        <a href="{{ route('diplomas.index') }}"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 inline-flex items-center">
                            <span class="icon-[mdi--format-list-bulleted] w-5 h-5 mr-2"></span>
                            Lista
                        </a>
                        
                        <!-- Formulario -->
                        <a href="{{ route('diplomas.create') }}"
                           class="border-blue-500 text-blue-600 dark:text-blue-400 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 inline-flex items-center"
                           aria-current="page">
                            <span class="icon-[mdi--file-document-plus] w-5 h-5 mr-2"></span>
                            Formulario
                        </a>
                        
                        <!-- Menciones -->
                        @can('ver-titulos')
                        <a href="{{ route('diplomas.menciones.index') }}"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 inline-flex items-center">
                            <span class="icon-[mdi--medal] w-5 h-5 mr-2"></span>
                            Menciones
                        </a>
                        @endcan
                        
                        <!-- Modalidades de Graduación -->
                        @can('ver-titulos')
                        <a href="{{ route('diplomas.modalidades.index') }}"
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 inline-flex items-center">
                            <span class="icon-[mdi--school] w-5 h-5 mr-2"></span>
                            Mod. Graduación
                        </a>
                        @endcan
                    </nav>
                </div>
            </div>

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
        </div>
    </div>
</x-app-layout>
