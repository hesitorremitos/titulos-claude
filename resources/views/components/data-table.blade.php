@props(['columns', 'rows' => [], 'searchRoute' => null, 'searchValue' => ''])

<div class="space-y-4">
    @if($searchRoute)
        <!-- Barra de búsqueda -->
        <div class="flex justify-between items-center">
            <form method="GET" action="{{ $searchRoute }}" class="flex-1 max-w-md">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchValue }}"
                        placeholder="Buscar..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                    >
                    <span class="icon-[mdi--magnify] absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" aria-hidden="true"></span>
                </div>
            </form>
            {{ $actions ?? '' }}
        </div>
    @endif

    <!-- Tabla -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @foreach($columns as $column)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ $column }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @if(count($rows) > 0)
                        {{ $slot }}
                    @else
                        <tr>
                            <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <span class="icon-[mdi--database-search] w-12 h-12 mb-4 text-gray-400" aria-hidden="true"></span>
                                    <p class="text-lg font-medium">No se encontraron resultados</p>
                                    <p class="text-sm">{{ $searchValue ? 'Intenta con otros términos de búsqueda' : 'No hay datos para mostrar' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(isset($pagination))
            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                {{ $pagination }}
            </div>
        @endif
    </div>
</div>
