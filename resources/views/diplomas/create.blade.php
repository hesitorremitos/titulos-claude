@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Nuevo Diploma']
    ];
@endphp

<x-diplomas-layout section-title="Formulario" :breadcrumbs="$breadcrumbs">
    <!-- Formulario Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Registrar Nuevo Diploma Académico</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete la información del diploma académico. Puede buscar los datos personales a través de la API universitaria o registrarlos manualmente.</p>
        </div>
        
        <div class="p-6">
            <!-- Livewire Component for Form -->
            @livewire('diploma-academico-form-component')
        </div>
    </div>
</x-diplomas-layout>