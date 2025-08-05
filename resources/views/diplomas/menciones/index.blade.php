@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Menciones Académicas']
    ];
@endphp

<x-diplomas-layout section-title="Menciones" :breadcrumbs="$breadcrumbs">
    <x-slot name="headerExtra">
        @can('crear-titulos')
            <x-primary-button onclick="window.location.href='{{ route('diplomas.menciones.create') }}'">
                <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                Nueva Mención
            </x-primary-button>
        @endcan
    </x-slot>

    <!-- Lista de menciones -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Menciones Académicas</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de menciones por carrera académica</p>
        </div>
        
        <div class="p-6">
            @if($menciones->count() > 0)
                <x-data-table>
                    <x-slot name="header">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Mención
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Carrera
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Facultad
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Diplomas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                </x-slot>

                <x-slot name="body">
                    @foreach($menciones as $mencion)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-warning-100 dark:bg-warning-900 rounded-full flex items-center justify-center mr-4">
                                        <span class="icon-[mdi--medal] w-5 h-5 text-warning-600 dark:text-warning-400"></span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $mencion->nombre }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--school] w-4 h-4 text-secondary-500 mr-2"></span>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $mencion->carrera->programa }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--domain] w-4 h-4 text-primary-500 mr-2"></span>
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $mencion->carrera->facultad->nombre }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($mencion->diplomas_count > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                            <span class="icon-[mdi--certificate] w-3 h-3 mr-1"></span>
                                            {{ $mencion->diplomas_count }} diplomas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            <span class="icon-[mdi--certificate-outline] w-3 h-3 mr-1"></span>
                                            Sin diplomas
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="inline-flex">
                                    <x-icon-button 
                                        icon="icon-[mdi--eye]" 
                                        variant="outline" 
                                        size="sm"
                                        onclick="window.location.href='{{ route('diplomas.menciones.show', $mencion) }}'"
                                        title="Ver mención" />
                                    
                                    @can('editar-titulos')
                                        <x-icon-button 
                                            icon="icon-[mdi--pencil]" 
                                            variant="secondary" 
                                            size="sm"
                                            onclick="window.location.href='{{ route('diplomas.menciones.edit', $mencion) }}'"
                                            title="Editar mención" />
                                    @endcan
                                    
                                    @can('eliminar-titulos')
                                        @if($mencion->diplomas_count == 0)
                                            <form method="POST" action="{{ route('diplomas.menciones.destroy', $mencion) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <x-icon-button 
                                                    type="submit"
                                                    icon="icon-[mdi--delete]" 
                                                    variant="danger" 
                                                    size="sm"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta mención?')"
                                                    title="Eliminar mención" />
                                            </form>
                                        @else
                                            <x-icon-button 
                                                icon="icon-[mdi--lock]" 
                                                variant="ghost" 
                                                size="sm"
                                                disabled
                                                title="No se puede eliminar: en uso" />
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
                </x-data-table>
                
                <div class="mt-6">
                    {{ $menciones->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <span class="icon-[mdi--medal-outline] w-12 h-12 text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay menciones registradas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Comienza creando menciones académicas para organizar los diplomas por especialidad.</p>
                    @can('crear-titulos')
                        <x-primary-button onclick="window.location.href='{{ route('diplomas.menciones.create') }}'">
                            <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                            Crear Primera Mención
                        </x-primary-button>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</x-diplomas-layout>