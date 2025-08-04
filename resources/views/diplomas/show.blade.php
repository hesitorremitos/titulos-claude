<x-diplomas-layout section-title="Diploma #{{ $diploma->nro_documento }}">
    <x-slot name="headerExtra">
        <div class="flex space-x-2">
            @if($diploma->file_dir)
                <a href="{{ route('diplomas.download', $diploma) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <span class="icon-[mdi--download] w-4 h-4 mr-2"></span>
                    Descargar PDF
                </a>
            @endif
            <a href="{{ route('diplomas.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
                Volver al listado
            </a>
        </div>
    </x-slot>

    <!-- Diploma Details -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información Personal -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información Personal</h3>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carnet de Identidad</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->persona->ci }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->persona->nombre_completo }}</dd>
                        </div>
                        @if($diploma->persona->fecha_nacimiento)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->persona->fecha_nacimiento->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información Académica -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información Académica</h3>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Facultad</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->mencion->carrera->facultad->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carrera</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->mencion->carrera->programa }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mención</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->mencion->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modalidad de Graduación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->graduacion->nombre }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información del Documento -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información del Documento</h3>
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Documento</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->nro_documento }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Libro</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->libro }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fojas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->fojas }}</dd>
                            </div>
                            @if($diploma->fecha_emision)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Emisión</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->fecha_emision->format('d/m/Y') }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estado y Auditoría -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Estado y Auditoría</h3>
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1">
                                    @if($diploma->file_dir)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Digitalizado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                            Pendiente de digitalización
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado por</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->createdBy->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diploma->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @if($diploma->updated_at != $diploma->created_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $diploma->updated_at->format('d/m/Y H:i') }}
                                    @if($diploma->updatedBy)
                                        por {{ $diploma->updatedBy->name }}
                                    @endif
                                </dd>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            @if($diploma->observaciones)
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Observaciones</h3>
                <div class="text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    {{ $diploma->observaciones }}
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                @can('eliminar-titulos')
                    @if(auth()->user()->hasRole('Administrador') || $diploma->created_by === auth()->id())
                        <form method="POST" action="{{ route('diplomas.destroy', $diploma) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('¿Estás seguro de eliminar este diploma? Esta acción no se puede deshacer.')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <span class="icon-[mdi--delete] w-4 h-4 mr-2"></span>
                                Eliminar Diploma
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </div>
</x-diplomas-layout>