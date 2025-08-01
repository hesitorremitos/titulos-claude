<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Diploma Académico') }} #{{ $diploma->nro_documento }}
            </h2>
            <div class="flex space-x-2">
                @if($diploma->file_dir)
                    <x-button href="{{ route('diplomas.download', $diploma) }}" icon="icon-[mdi--download]">
                        Descargar PDF
                    </x-button>
                @endif
                <x-button href="{{ route('diplomas.index') }}" variant="secondary">
                    Volver al listado
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Información de la Persona -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Datos Personales
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre completo</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                    {{ $diploma->persona->nombre_completo }}
                                </dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cédula de Identidad</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $diploma->persona->ci }}</dd>
                            </div>
                            @if($diploma->persona->fecha_nacimiento)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de nacimiento</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->persona->fecha_nacimiento->format('d/m/Y') }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                        <div>
                            @if($diploma->persona->genero)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Género</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->persona->genero === 'M' ? 'Masculino' : ($diploma->persona->genero === 'F' ? 'Femenino' : 'Otro') }}
                                    </dd>
                                </div>
                            @endif
                            @if($diploma->persona->departamento)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lugar de nacimiento</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->persona->localidad }}, {{ $diploma->persona->provincia }}, {{ $diploma->persona->departamento }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Diploma -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Información del Diploma Académico
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de documento</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $diploma->nro_documento }}
                                </dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Libro y Fojas</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    Libro: {{ $diploma->libro }}, Fojas: {{ $diploma->fojas }}
                                </dd>
                            </div>
                            @if($diploma->fecha_emision)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de emisión</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->fecha_emision->format('d/m/Y') }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mención</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                    {{ $diploma->mencion->nombre }}
                                </dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carrera</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $diploma->mencion->carrera->programa }}
                                </dd>
                            </div>
                            @if($diploma->graduacion)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modalidad de graduación</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->graduacion->medio_graduacion }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($diploma->observaciones)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Observaciones</dt>
                            <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $diploma->observaciones }}
                            </dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Estado y Archivo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Estado y Archivo
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado del diploma</dt>
                                <dd class="mt-1">
                                    @if($diploma->file_dir)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Digitalizado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pendiente de digitalización
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Verificado</dt>
                                <dd class="mt-1">
                                    @if($diploma->verificado)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Verificado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            No verificado
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </div>
                        <div>
                            @if($diploma->file_dir)
                                <div class="border-2 border-dashed border-green-300 dark:border-green-600 rounded-lg p-4 text-center bg-green-50 dark:bg-green-900/20">
                                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                                        Archivo PDF disponible
                                    </p>
                                    <x-button href="{{ route('diplomas.download', $diploma) }}" class="mt-3" size="sm">
                                        Descargar
                                    </x-button>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path d="M34 40H14a4 4 0 01-4-4V12a4 4 0 014-4h10l6 6h10a4 4 0 014 4v18a4 4 0 01-4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Sin archivo PDF
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Caso de pérdida de documento
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Auditoría -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información de Auditoría
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado por</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $diploma->createdBy->name }}
                                </dd>
                            </div>
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</dt>
                                <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                    {{ $diploma->created_at->format('d/m/Y H:i:s') }}
                                </dd>
                            </div>
                        </div>
                        <div>
                            @if($diploma->updatedBy)
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última modificación por</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->updatedBy->name }}
                                    </dd>
                                </div>
                                <div class="mb-4">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de modificación</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $diploma->updated_at->format('d/m/Y H:i:s') }}
                                    </dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            @can('eliminar-titulos')
                @if(auth()->user()->hasRole('Administrador') || $diploma->created_by === auth()->id())
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4">Zona de peligro</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Una vez eliminado, este diploma y toda su información se perderán permanentemente.
                            </p>
                            <form method="POST" action="{{ route('diplomas.destroy', $diploma) }}" class="inline">
                                @csrf @method('DELETE')
                                <x-button variant="danger" type="submit" 
                                    onclick="return confirm('¿Estás completamente seguro de eliminar este diploma académico? Esta acción no se puede deshacer.')">
                                    Eliminar Diploma
                                </x-button>
                            </form>
                        </div>
                    </div>
                @endif
            @endcan
        </div>
    </div>
</x-app-layout>
