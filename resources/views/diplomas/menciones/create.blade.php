@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Menciones', 'url' => route('diplomas.menciones.index')],
        ['label' => 'Nueva Mención']
    ];
@endphp

<x-diplomas-layout section-title="Crear Mención" :breadcrumbs="$breadcrumbs">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Nueva Mención Académica</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Complete la información para crear una nueva mención académica.
                </p>
            </div>

            <form method="POST" action="{{ route('diplomas.menciones.store') }}" class="space-y-6">
                @csrf
                <x-form-field label="Nombre de la Mención" name="nombre">
                    <x-form-input-icon 
                        icon="icon-[mdi--medal]"
                        id="nombre"
                        name="nombre"
                        type="text"
                        value="{{ old('nombre') }}"
                        required
                        autofocus
                        placeholder="Ej: Mención Honorífica" />
                </x-form-field>

                <x-form-field label="Carrera" name="carrera_id">
                    <x-form-select
                        label="Carrera"
                        name="carrera_id"
                        :options="$carreras"
                        required
                        :value="old('carrera_id', $)"
                    />
                </x-form-field>

                <div class="flex items-center justify-end space-x-3">
                    <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.menciones.index') }}'">
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button>
                        Crear Mención
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-diplomas-layout>