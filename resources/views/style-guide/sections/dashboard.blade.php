<!-- Dashboard Simulation -->
<section id="dashboard" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Simulación de Dashboard</h2>
        <p class="text-gray-600 dark:text-gray-400">Layout completo del sistema con sidebar, header y contenido principal</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden" style="height: 600px;">
        <div class="flex h-full">
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex-shrink-0">
                <!-- Logo/Header del Sidebar -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <span class="icon-[mdi--school] w-5 h-5 text-white"></span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">UATF Títulos</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Universidad</p>
                        </div>
                    </div>
                </div>

                <!-- Navegación del Sidebar -->
                <nav class="p-4 space-y-2" x-data="{ mainOpen: true, adminOpen: true }">
                    <!-- Grupo: Menú Principal -->
                    <div class="mb-4">
                        <button @click="mainOpen = !mainOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !mainOpen }"></span>
                            Menú Principal
                        </button>
                        
                        <div x-show="mainOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300">
                                <span class="icon-[mdi--view-dashboard] w-5 h-5"></span>
                                <span class="text-sm font-medium">Dashboard</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--school] w-5 h-5"></span>
                                <span class="text-sm">Diplomas Académicos</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--certificate] w-5 h-5"></span>
                                <span class="text-sm">Títulos Profesionales</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--account-school] w-5 h-5"></span>
                                <span class="text-sm">Bachiller</span>
                            </a>
                        </div>
                    </div>

                    <!-- Grupo: Administración -->
                    <div class="mb-4">
                        <button @click="adminOpen = !adminOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !adminOpen }"></span>
                            Administración
                        </button>
                        
                        <div x-show="adminOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--account-multiple] w-5 h-5"></span>
                                <span class="text-sm">Usuarios</span>
                            </a>
                            
                            <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <span class="icon-[mdi--cog] w-5 h-5"></span>
                                <span class="text-sm">Configuración</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Contenido Principal -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- Top Navigation Bar -->
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <!-- Page Title and Description -->
                            <div class="flex-1 min-w-0">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Diplomas Académicos</h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de títulos académicos universitarios</p>
                            </div>

                            <!-- User Actions -->
                            <div class="flex items-center space-x-4">
                                <!-- Notificaciones -->
                                <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="icon-[mdi--bell] w-5 h-5"></span>
                                    <span class="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full"></span>
                                </button>
                                
                                <!-- Usuario Profile Dropdown -->
                                <div x-data="{ menuIsOpen: false }" x-on:keydown.esc.window="menuIsOpen = false" class="relative">
                                    <button 
                                        type="button" 
                                        class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors hover:bg-gray-50 dark:hover:bg-gray-700"
                                        :class="menuIsOpen ? 'bg-primary-50 dark:bg-primary-900/20' : ''" 
                                        aria-haspopup="true" 
                                        x-on:click="menuIsOpen = ! menuIsOpen" 
                                        :aria-expanded="menuIsOpen">
                                        
                                        <div class="w-8 h-8 bg-secondary-500 rounded-full flex items-center justify-center">
                                            <span class="icon-[mdi--account] w-5 h-5 text-white"></span>
                                        </div>
                                        
                                        <div class="text-sm text-left">
                                            <p class="font-medium text-gray-900 dark:text-white">Juan Pérez</p>
                                            <p class="text-gray-500 dark:text-gray-400">Administrador</p>
                                        </div>
                                        
                                        <span class="icon-[mdi--chevron-down] w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': menuIsOpen }"></span>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div 
                                        x-cloak 
                                        x-show="menuIsOpen" 
                                        x-on:click.outside="menuIsOpen = false" 
                                        x-transition:enter="transition ease-out duration-200" 
                                        x-transition:enter-start="opacity-0 scale-95" 
                                        x-transition:enter-end="opacity-100 scale-100" 
                                        x-transition:leave="transition ease-in duration-150" 
                                        x-transition:leave-start="opacity-100 scale-100" 
                                        x-transition:leave-end="opacity-0 scale-95" 
                                        x-trap="menuIsOpen"
                                        class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 z-50">
                                        
                                        <!-- Profile Section -->
                                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                            <a href="#" class="flex items-center space-x-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 py-2 rounded-md transition-colors" role="menuitem">
                                                <span class="icon-[mdi--account] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Mi Perfil</span>
                                            </a>
                                        </div>
                                        
                                        <!-- Settings Section -->
                                        <div class="py-1">
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--cog] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span>Configuración</span>
                                            </a>
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--shield-account] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span>Seguridad</span>
                                            </a>
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--help-circle] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                <span>Ayuda</span>
                                            </a>
                                        </div>
                                        
                                        <!-- Sign Out Section -->
                                        <div class="py-1 border-t border-gray-200 dark:border-gray-700">
                                            <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" role="menuitem">
                                                <span class="icon-[mdi--logout] w-5 h-5"></span>
                                                <span>Cerrar Sesión</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub Navigation Tabs -->
                    <div class="px-6 py-0 bg-white dark:bg-gray-800">
                        <nav class="-mb-px flex space-x-8" aria-label="Sub Navigation">
                            <!-- Lista Activa -->
                            <a href="#" class="border-b-2 border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap py-3 px-1 font-medium text-sm flex items-center">
                                <span class="icon-[mdi--format-list-bulleted] w-4 h-4 mr-2"></span>
                                Lista Activa
                            </a>
                            
                            <!-- Menciones -->
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                <span class="icon-[mdi--medal] w-4 h-4 mr-2"></span>
                                Menciones
                            </a>
                            
                            <!-- Modalidades -->
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                <span class="icon-[mdi--school] w-4 h-4 mr-2"></span>
                                Modalidades
                            </a>
                            
                            <!-- Estadísticas -->
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                <span class="icon-[mdi--chart-line] w-4 h-4 mr-2"></span>
                                Estadísticas
                            </a>
                            
                            <!-- Configuración -->
                            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                <span class="icon-[mdi--cog] w-4 h-4 mr-2"></span>
                                Configuración
                            </a>
                        </nav>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="icon-[mdi--school] w-8 h-8 text-primary-500"></span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Diplomas</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,234</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="icon-[mdi--clock-outline] w-8 h-8 text-warning-500"></span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pendientes</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">45</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="icon-[mdi--check-circle] w-8 h-8 text-success-500"></span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Digitalizados</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,189</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="icon-[mdi--account-multiple] w-8 h-8 text-secondary-500"></span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Usuarios Activos</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">12</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido adicional -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Tabla de actividad reciente -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Actividad Reciente</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-success-500 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white">Diploma registrado - Juan Carlos Mamani</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Hace 2 minutos</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-warning-500 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white">Documento pendiente de validación</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Hace 15 minutos</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-primary-500 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-white">Usuario creado - María López</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Hace 1 hora</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones rápidas -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Acciones Rápidas</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="icon-[mdi--plus] w-8 h-8 text-primary-500 mb-2"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Nuevo Diploma</span>
                                    </button>
                                    <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="icon-[mdi--upload] w-8 h-8 text-secondary-500 mb-2"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Subir PDF</span>
                                    </button>
                                    <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="icon-[mdi--search] w-8 h-8 text-success-500 mb-2"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Buscar Título</span>
                                    </button>
                                    <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="icon-[mdi--download] w-8 h-8 text-warning-500 mb-2"></span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">Reportes</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>
