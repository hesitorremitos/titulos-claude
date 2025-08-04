<x-diplomas-layout section-title="Modalidades">
    <x-slot name="headerExtra">
        @can('crear-titulos')
            <a href="{{ route('diplomas.modalidades.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                Nueva Modalidad
            </a>
        @endcan
    </x-slot>

            <!-- Lista de modalidades -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($modalidades->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Medio de Graduación
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Diplomas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($modalidades as $modalidad)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $modalidad->medio_graduacion }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $modalidad->diplomas_count ?? 0 }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('diplomas.modalidades.show', $modalidad) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                                                    Ver
                                                </a>
                                                
                                                @can('editar-titulos')
                                                    <a href="{{ route('diplomas.modalidades.edit', $modalidad) }}" 
                                                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                                        Editar
                                                    </a>
                                                @endcan
                                                
                                                @can('eliminar-titulos')
                                                    @if($modalidad->diplomas_count == 0)
                                                        <form method="POST" action="{{ route('diplomas.modalidades.destroy', $modalidad) }}" class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" 
                                                                    onclick="return confirm('¿Estás seguro de eliminar esta modalidad?')"
                                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 text-xs leading-4 font-medium rounded-md text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                                            En uso
                                                        </span>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $modalidades->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay modalidades registradas</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primera modalidad de graduación.</p>
                            @can('crear-titulos')
                                <div class="mt-6">
                                    <a href="{{ route('diplomas.modalidades.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Crear Modalidad
                                    </a>
                                </div>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
</x-diplomas-layout>