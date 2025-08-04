<x-diplomas-layout section-title="Detalle de Mención">
    <x-slot name="headerExtra">
        <div class="flex space-x-2">
            @can('editar-titulos')
                <a href="{{ route('diplomas.menciones.edit', $mencion) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <span class="icon-[mdi--pencil] w-4 h-4 mr-2"></span>
                    Editar
                </a>
            @endcan
            <a href="{{ route('diplomas.menciones.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
                Volver
            </a>
        </div>
    </x-slot>

    <!-- Breadcrumb Navigation -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2 text-gray-500">
            <li><a href="{{ route('diplomas.index') }}" class="hover:text-gray-700">Diplomas Académicos</a></li>
            <li class="flex items-center"><span class="icon-[mdi--chevron-right] w-4 h-4 mx-2"></span></li>
            <li><a href="{{ route('diplomas.menciones.index') }}" class="hover:text-gray-700">Menciones</a></li>
            <li class="flex items-center"><span class="icon-[mdi--chevron-right] w-4 h-4 mx-2"></span></li>
            <li class="text-gray-900 dark:text-gray-100">{{ $mencion->nombre }}</li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información de la Mención -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información de la Mención</h3>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $mencion->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Carrera</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $mencion->carrera->programa }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Facultad</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $mencion->carrera->facultad->nombre }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Diplomas</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $diplomasCount }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Información de Auditoría -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información de Registro</h3>
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de creación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $mencion->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @if($mencion->updated_at != $mencion->created_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $mencion->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                @can('eliminar-titulos')
                    @if($diplomasCount == 0)
                        <form method="POST" action="{{ route('diplomas.menciones.destroy', $mencion) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta mención? Esta acción no se puede deshacer.')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <span class="icon-[mdi--delete] w-4 h-4 mr-2"></span>
                                Eliminar Mención
                            </button>
                        </form>
                    @else
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="icon-[mdi--information] w-4 h-4 inline mr-1"></span>
                            No se puede eliminar esta mención porque está siendo utilizada por {{ $diplomasCount }} diploma(s).
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
</x-diplomas-layout>