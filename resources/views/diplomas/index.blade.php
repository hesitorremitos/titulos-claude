<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Diplomas Académicos') }}
            </h2>
            @can('crear-titulos')
                <x-button href="{{ route('diplomas.create') }}" icon="icon-[mdi--plus]">
                    Nuevo Diploma
                </x-button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros de búsqueda -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('diplomas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="search" value="Buscar por CI o nombre" />
                            <x-text-input 
                                id="search" 
                                name="search" 
                                type="text" 
                                value="{{ request('search') }}"
                                placeholder="CI, nombres o apellidos"
                                class="mt-1 block w-full" />
                        </div>
                        
                        <div>
                            <x-input-label for="estado" value="Estado del diploma" />
                            <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Todos los estados</option>
                                <option value="digitalizado" {{ request('estado') === 'digitalizado' ? 'selected' : '' }}>
                                    Digitalizado
                                </option>
                                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>
                                    Pendiente de digitalización
                                </option>
                            </select>
                        </div>
                        
                        <div class="flex items-end space-x-2">
                            <x-primary-button type="submit">
                                Buscar
                            </x-primary-button>
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('diplomas.index') }}'">
                                Limpiar
                            </x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de diplomas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($diplomas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
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
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($diplomas as $diploma)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $diploma->persona->nombre_completo }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        CI: {{ $diploma->persona->ci }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    <div>Nro: {{ $diploma->nro_documento }}</div>
                                                    <div>Libro: {{ $diploma->libro }}, Fojas: {{ $diploma->fojas }}</div>
                                                    @if($diploma->fecha_emision)
                                                        <div class="text-xs text-gray-500">{{ $diploma->fecha_emision->format('d/m/Y') }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $diploma->mencion->nombre }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $diploma->mencion->carrera->programa }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($diploma->file_dir)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Digitalizado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <div>{{ $diploma->createdBy->name }}</div>
                                                <div class="text-xs">{{ $diploma->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                @can('ver-titulos')
                                                    <x-button href="{{ route('diplomas.show', $diploma) }}" variant="secondary" size="sm">
                                                        Ver
                                                    </x-button>
                                                @endcan
                                                
                                                @if($diploma->file_dir)
                                                    <x-button href="{{ route('diplomas.download', $diploma) }}" variant="outline" size="sm">
                                                        PDF
                                                    </x-button>
                                                @endif
                                                
                                                @can('eliminar-titulos')
                                                    @if(auth()->user()->hasRole('Administrador') || $diploma->created_by === auth()->id())
                                                        <form method="POST" action="{{ route('diplomas.destroy', $diploma) }}" class="inline">
                                                            @csrf @method('DELETE')
                                                            <x-button variant="danger" size="sm" type="submit" 
                                                                onclick="return confirm('¿Estás seguro de eliminar este diploma?')">
                                                                Eliminar
                                                            </x-button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $diplomas->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay diplomas académicos</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primer diploma académico.</p>
                            @can('crear-titulos')
                                <div class="mt-6">
                                    <x-button href="{{ route('diplomas.create') }}">
                                        Crear Diploma
                                    </x-button>
                                </div>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
