@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Diplomas Académicos', 'url' => route('diplomas.index')],
        ['label' => 'Modalidades de Graduación']
    ];
@endphp

<x-diplomas-layout section-title="Modalidades" :breadcrumbs="$breadcrumbs">
    <x-slot name="headerExtra">
        @can('crear-titulos')
            <x-primary-button onclick="window.location.href='{{ route('diplomas.modalidades.create') }}'">
                <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                Nueva Modalidad
            </x-primary-button>
        @endcan
    </x-slot>

    <!-- Lista de modalidades -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Modalidades de Graduación</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de modalidades y medios de graduación académica</p>
        </div>
        
        <div class="p-6">
            @if($modalidades->count() > 0)
                <x-data-table>
                    <x-slot name="header">
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
                    </x-slot>

                    <x-slot name="body">
                        @foreach($modalidades as $modalidad)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mr-4">
                                        <span class="icon-[mdi--trophy] w-5 h-5 text-success-600 dark:text-success-400"></span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $modalidad->medio_graduacion }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($modalidad->diplomas_count > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                            <span class="icon-[mdi--certificate] w-3 h-3 mr-1"></span>
                                            {{ $modalidad->diplomas_count }} diplomas
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
                                        onclick="window.location.href='{{ route('diplomas.modalidades.show', $modalidad) }}'"
                                        title="Ver modalidad" />
                                    
                                    @can('editar-titulos')
                                        <x-icon-button 
                                            icon="icon-[mdi--pencil]" 
                                            variant="secondary" 
                                            size="sm"
                                            onclick="window.location.href='{{ route('diplomas.modalidades.edit', $modalidad) }}'"
                                            title="Editar modalidad" />
                                    @endcan
                                    
                                    @can('eliminar-titulos')
                                        @if($modalidad->diplomas_count == 0)
                                            <form method="POST" action="{{ route('diplomas.modalidades.destroy', $modalidad) }}" class="inline">
                                                @csrf @method('DELETE')
                                                <x-icon-button 
                                                    type="submit"
                                                    icon="icon-[mdi--delete]" 
                                                    variant="danger" 
                                                    size="sm"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta modalidad?')"
                                                    title="Eliminar modalidad" />
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
                    {{ $modalidades->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <span class="icon-[mdi--trophy-outline] w-12 h-12 text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay modalidades registradas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Comienza creando modalidades de graduación para clasificar los tipos de obtención de diploma.</p>
                    @can('crear-titulos')
                        <x-primary-button onclick="window.location.href='{{ route('diplomas.modalidades.create') }}'">
                            <span class="icon-[mdi--plus] w-4 h-4 mr-2"></span>
                            Crear Primera Modalidad
                        </x-primary-button>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</x-diplomas-layout>