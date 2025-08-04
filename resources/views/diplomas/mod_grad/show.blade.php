<x-diplomas-layout section-title="{{ $modalidad->nombre }}">
    <x-slot name="headerExtra">
        @can('editar-titulos')
            <a href="{{ route('diplomas.modalidades.edit', $modalidad) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--pencil] w-4 h-4 mr-2"></span>
                Editar
            </a>
        @endcan
        <a href="{{ route('diplomas.modalidades.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <span class="icon-[mdi--arrow-left] w-4 h-4 mr-2"></span>
            Volver
        </a>
    </x-slot>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Información de la Modalidad -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información de la Modalidad</h3>
                            <div class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $modalidad->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Medio de Graduación</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $modalidad->medio_graduacion }}</dd>
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
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $modalidad->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                @if($modalidad->updated_at != $modalidad->created_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última modificación</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $modalidad->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                        @can('eliminar-titulos')
                            @if($diplomasCount == 0)
                                <form method="POST" action="{{ route('diplomas.modalidades.destroy', $modalidad) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('¿Estás seguro de eliminar esta modalidad? Esta acción no se puede deshacer.')"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <span class="icon-[mdi--delete] w-4 h-4 mr-2"></span>
                                        Eliminar Modalidad
                                    </button>
                                </form>
                            @else
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="icon-[mdi--information] w-4 h-4 inline mr-1"></span>
                                    No se puede eliminar esta modalidad porque está siendo utilizada por {{ $diplomasCount }} diploma(s).
                                </div>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
</x-diplomas-layout>