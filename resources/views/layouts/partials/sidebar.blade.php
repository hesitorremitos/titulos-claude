<!-- Sidebar Desktop -->
<aside class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
            <nav class="mt-5 flex-1 px-2 space-y-1">
                <!-- Dashboard -->
                <x-sidebar-link 
                    href="{{ route('dashboard') }}" 
                    icon="mdi--view-dashboard"
                    :active="request()->routeIs('dashboard')"
                >
                    Dashboard
                </x-sidebar-link>

                <!-- Sección: Catálogos -->
                <x-sidebar-section title="Catálogos">
                    @can('ver-facultades')
                    <x-sidebar-link 
                        href="{{ route('facultades.index') }}" 
                        icon="mdi--school"
                        :active="request()->routeIs('facultades.*')"
                    >
                        Facultades
                    </x-sidebar-link>
                    @endcan
                    
                    @can('ver-carreras')
                    <x-sidebar-link 
                        href="{{ route('carreras.index') }}" 
                        icon="mdi--book-education"
                        :active="request()->routeIs('carreras.*')"
                    >
                        Carreras
                    </x-sidebar-link>
                    @endcan
                </x-sidebar-section>
            </nav>
        </div>
    </div>
</aside>

<!-- Sidebar Mobile -->
<div class="md:hidden" id="mobile-menu" style="display: none;">
    <div class="fixed inset-0 flex z-40">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" id="mobile-menu-overlay"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-gray-800">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button 
                    type="button" 
                    id="mobile-menu-close"
                    class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                >
                    <span class="sr-only">Cerrar sidebar</span>
                    <span class="icon-[mdi--close] h-6 w-6 text-white" aria-hidden="true"></span>
                </button>
            </div>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                <nav class="mt-5 px-2 space-y-1">
                    <!-- Dashboard -->
                    <x-sidebar-link 
                        href="{{ route('dashboard') }}" 
                        icon="mdi--view-dashboard"
                        :active="request()->routeIs('dashboard')"
                        :mobile="true"
                    >
                        Dashboard
                    </x-sidebar-link>

                    <!-- Sección: Catálogos -->
                    <x-sidebar-section title="Catálogos">
                        @can('ver-facultades')
                        <x-sidebar-link 
                            href="{{ route('facultades.index') }}" 
                            icon="mdi--school" 
                            :active="request()->routeIs('facultades.*')"
                            :mobile="true"
                        >
                            Facultades
                        </x-sidebar-link>
                        @endcan
                        
                        @can('ver-carreras')
                        <x-sidebar-link 
                            href="{{ route('carreras.index') }}" 
                            icon="mdi--book-education" 
                            :active="request()->routeIs('carreras.*')"
                            :mobile="true"
                        >
                            Carreras
                        </x-sidebar-link>
                        @endcan
                    </x-sidebar-section>
                </nav>
            </div>
        </div>
    </div>
</div>
