@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Diploma #' . $diploma->nro_documento]
    ];
@endphp

<x-diplomas-layout section-title="Diploma #{{ $diploma->nro_documento }}" :breadcrumbs="$breadcrumbs">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información Personal -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información Personal</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Datos personales del titular del diploma</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--card-account-details] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carnet de Identidad</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->persona->ci }}</dd>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-secondary-100 dark:bg-secondary-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--account] w-5 h-5 text-secondary-600 dark:text-secondary-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->persona->nombre_completo }}</dd>
                        </div>
                    </div>
                    
                    @if($diploma->persona->fecha_nacimiento)
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--cake-variant] w-5 h-5 text-success-600 dark:text-success-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</dt>
                            <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->persona->fecha_nacimiento->format('d/m/Y') }}</dd>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información Académica -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información Académica</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalles de la formación académica</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--domain] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Facultad</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->mencion->carrera->facultad->nombre }}</dd>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-secondary-100 dark:bg-secondary-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--school] w-5 h-5 text-secondary-600 dark:text-secondary-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carrera</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->mencion->carrera->programa }}</dd>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-warning-100 dark:bg-warning-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--medal] w-5 h-5 text-warning-600 dark:text-warning-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mención</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->mencion->nombre }}</dd>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-10 h-10 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mr-4">
                            <span class="icon-[mdi--trophy] w-5 h-5 text-success-600 dark:text-success-400"></span>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modalidad de Graduación</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->graduacion->nombre }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información del Documento -->
        <x-page-section title="Información del Documento" description="Detalles del documento oficial">
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--file-document] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Documento</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->nro_documento }}</dd>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-8 h-8 bg-secondary-100 dark:bg-secondary-900 rounded-full flex items-center justify-center mr-3">
                            <span class="icon-[mdi--book] w-4 h-4 text-secondary-600 dark:text-secondary-400"></span>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Libro</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->libro }}</dd>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="w-8 h-8 bg-warning-100 dark:bg-warning-900 rounded-full flex items-center justify-center mr-3">
                            <span class="icon-[mdi--file-outline] w-4 h-4 text-warning-600 dark:text-warning-400"></span>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Fojas</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->fojas }}</dd>
                        </div>
                    </div>
                </div>
                
                @if($diploma->fecha_emision)
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--calendar-check] w-5 h-5 text-success-600 dark:text-success-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Emisión</dt>
                        <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->fecha_emision->format('d/m/Y') }}</dd>
                    </div>
                </div>
                @endif
            </div>
        </x-page-section>

        <!-- Estado y Auditoría -->
        <x-page-section title="Estado y Auditoría" description="Información de estado y trazabilidad">
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-{{ $diploma->file_dir ? 'success' : 'warning' }}-100 dark:bg-{{ $diploma->file_dir ? 'success' : 'warning' }}-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--{{ $diploma->file_dir ? 'check-circle' : 'clock' }}] w-5 h-5 text-{{ $diploma->file_dir ? 'success' : 'warning' }}-600 dark:text-{{ $diploma->file_dir ? 'success' : 'warning' }}-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                        <dd class="mt-1">
                            @if($diploma->file_dir)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                    <span class="icon-[mdi--check-circle] w-4 h-4 mr-2"></span>
                                    Digitalizado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-warning-100 text-warning-800 dark:bg-warning-900 dark:text-warning-200">
                                    <span class="icon-[mdi--clock] w-4 h-4 mr-2"></span>
                                    Pendiente de digitalización
                                </span>
                            @endif
                        </dd>
                    </div>
                </div>
                
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--account-plus] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado por</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->createdBy->name }}</dd>
                    </div>
                </div>
                
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-secondary-100 dark:bg-secondary-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--clock-outline] w-5 h-5 text-secondary-600 dark:text-secondary-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $diploma->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </div>
                
                @if($diploma->updated_at != $diploma->created_at)
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 bg-warning-100 dark:bg-warning-900 rounded-full flex items-center justify-center mr-4">
                        <span class="icon-[mdi--pencil] w-5 h-5 text-warning-600 dark:text-warning-400"></span>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ $diploma->updated_at->format('d/m/Y H:i') }}
                            @if($diploma->updatedBy)
                                <span class="text-xs text-gray-500 dark:text-gray-400">por {{ $diploma->updatedBy->name }}</span>
                            @endif
                        </dd>
                    </div>
                </div>
                @endif
            </div>
        </x-page-section>
    </div>

    <!-- Observaciones -->
    @if($diploma->observaciones)
    <x-page-section title="Observaciones" description="Notas y comentarios adicionales">
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="icon-[mdi--information] w-5 h-5 text-blue-400"></span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-300">{{ $diploma->observaciones }}</p>
                </div>
            </div>
        </div>
    </x-page-section>
    @endif

    <!-- Actions -->
    <x-page-section title="Acciones" description="Operaciones disponibles para este diploma">
        <div class="flex justify-end">
            @can('eliminar-titulos')
                @if(auth()->user()->hasRole('Administrador') || $diploma->created_by === auth()->id())
                    <form method="POST" action="{{ route('diplomas.destroy', $diploma) }}" class="inline">
                        @csrf @method('DELETE')
                        <x-button 
                            variant="danger"
                            type="submit"
                            onclick="return confirm('¿Estás seguro de eliminar este diploma? Esta acción no se puede deshacer.')">
                            <span class="icon-[mdi--delete] w-4 h-4 mr-2"></span>
                            Eliminar Diploma
                        </x-button>
                    </form>
                @endif
            @endcan
        </div>
    </x-page-section>
</x-diplomas-layout>