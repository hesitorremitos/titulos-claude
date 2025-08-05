<x-diplomas-layout>

    <!-- Filtros de búsqueda -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filtros de Búsqueda</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Encuentra diplomas académicos específicos usando los criterios de búsqueda</p>
        </div>
        
        <div class="p-6">
            <form method="GET" action="{{ route('diplomas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-form-field label="Buscar por CI o nombre" name="search">
                    <x-form-input-icon 
                        icon="icon-[mdi--magnify]"
                        name="search" 
                        type="text" 
                        value="{{ request('search') }}"
                        placeholder="CI, nombres o apellidos" />
                </x-form-field>
                
                <x-form-field label="Estado del diploma" name="estado">
                    <x-form-select name="estado" id="estado">
                        <option value="">Todos los estados</option>
                        <option value="digitalizado" {{ request('estado') === 'digitalizado' ? 'selected' : '' }}>
                            Digitalizado
                        </option>
                        <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>
                            Pendiente de digitalización
                        </option>
                    </x-form-select>
                </x-form-field>
                
                <div class="flex items-end space-x-3">
                    <div class="inline-flex rounded-md shadow-sm divide-x divide-gray-300 dark:divide-gray-600">
                        <x-primary-button type="submit">
                            <span class="icon-[mdi--magnify] w-4 h-4 mr-2"></span>
                            Buscar
                        </x-primary-button>
                        <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.index') }}'">
                            <span class="icon-[mdi--refresh] w-4 h-4 mr-2"></span>
                            Limpiar
                        </x-secondary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de diplomas -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Lista de Diplomas Académicos</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Registro completo de diplomas académicos del sistema</p>
        </div>
        
        <div class="p-6">
            @if($diplomas->count() > 0)
                <x-data-table>
                    <x-slot name="header">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Persona
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Documento
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Mención
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Registrado por
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        @foreach($diplomas as $diploma)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <span class="icon-[mdi--account] w-5 h-5 text-primary-600 dark:text-primary-400"></span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $diploma->persona->nombre_completo }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                CI: {{ $diploma->persona->ci }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        <div class="font-medium">Nro: {{ $diploma->nro_documento }}</div>
                                        <div>Libro: {{ $diploma->libro }}, Fojas: {{ $diploma->fojas }}</div>
                                        @if($diploma->fecha_emision)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span class="icon-[mdi--calendar] w-3 h-3 inline mr-1"></span>
                                                {{ $diploma->fecha_emision->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $diploma->mencion->nombre }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                        <span class="icon-[mdi--school] w-3 h-3 mr-1"></span>
                                        {{ $diploma->mencion->carrera->programa }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($diploma->file_dir)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                            <span class="icon-[mdi--check-circle] w-3 h-3 mr-1"></span>
                                            Digitalizado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-800 dark:bg-warning-900 dark:text-warning-200">
                                            <span class="icon-[mdi--clock] w-3 h-3 mr-1"></span>
                                            Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $diploma->createdBy->name }}</div>
                                    <div class="text-xs flex items-center mt-1">
                                        <span class="icon-[mdi--clock-outline] w-3 h-3 mr-1"></span>
                                        {{ $diploma->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="inline-flex">
                                        @can('ver-titulos')
                                            <x-icon-button 
                                                icon="icon-[mdi--eye]" 
                                                variant="outline" 
                                                size="sm"
                                                onclick="window.location.href='{{ route('diplomas.show', $diploma) }}'"
                                                title="Ver diploma" />
                                        @endcan
                                        
                                        @if($diploma->file_dir)
                                            <x-icon-button 
                                                icon="icon-[mdi--file-pdf-box]" 
                                                variant="secondary" 
                                                size="sm"
                                                onclick="window.location.href='{{ route('diplomas.download', $diploma) }}'"
                                                title="Descargar PDF" />
                                        @endif
                                        
                                        @can('eliminar-titulos')
                                            @if(auth()->user()->hasRole('Administrador') || $diploma->created_by === auth()->id())
                                                <form method="POST" action="{{ route('diplomas.destroy', $diploma) }}" class="inline">
                                                    @csrf @method('DELETE')
                                                    <x-icon-button 
                                                        type="submit"
                                                        icon="icon-[mdi--delete]" 
                                                        variant="danger" 
                                                        size="sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar este diploma?')"
                                                        title="Eliminar diploma" />
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-data-table>
                
                <div class="mt-6">
                    {{ $diplomas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <span class="icon-[mdi--school-outline] w-12 h-12 text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay diplomas académicos</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Comienza creando tu primer diploma académico para gestionar los títulos universitarios.</p>
                    @can('crear-titulos')
                        <x-primary-button onclick="window.location.href='{{ route('diplomas.create') }}'">
                            <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                            Crear Primer Diploma
                        </x-primary-button>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</x-diplomas-layout>