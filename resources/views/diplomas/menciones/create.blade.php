@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Menciones', 'url' => route('diplomas.menciones.index')],
        ['label' => 'Nueva Mención']
    ];
@endphp

<x-diplomas-layout section-title="Crear Mención" :breadcrumbs="$breadcrumbs">
    <x-slot name="headerExtra">
        <x-secondary-button onclick="window.location.href='{{ route('diplomas.menciones.index') }}'">
            <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
            Volver
        </x-secondary-button>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Nueva Mención Académica</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Complete la información para crear una nueva mención académica.
                </p>
            </div>

            <form method="POST" action="{{ route('diplomas.menciones.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <x-input-label for="nombre" value="Nombre de la Mención" />
                        <x-text-input 
                            id="nombre" 
                            name="nombre" 
                            type="text" 
                            class="mt-1 block w-full" 
                            value="{{ old('nombre') }}" 
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
                                <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
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
                        Crear Mención
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-diplomas-layout>