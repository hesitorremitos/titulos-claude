<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo y título -->
            <div class="flex items-center">
                <button 
                    id="mobile-menu-button" 
                    type="button" 
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                    aria-controls="mobile-menu" 
                    aria-expanded="false"
                >
                    <span class="sr-only">Abrir menú principal</span>
                    <span class="icon-[mdi--menu] w-6 h-6" aria-hidden="true"></span>
                </button>
                
                <div class="flex-shrink-0 flex items-center ml-4 md:ml-0">
                    <span class="icon-[mdi--certificate] text-primary-600 dark:text-primary-400 w-8 h-8 mr-3" aria-hidden="true"></span>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Departamento de Títulos
                        </h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Universidad Autónoma Tomás Frías
                        </p>
                    </div>
                </div>
            </div>

            <!-- Acciones del usuario -->
            <div class="flex items-center space-x-4">
                <!-- Toggle modo oscuro -->
                <button 
                    id="theme-toggle" 
                    type="button" 
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors duration-200"
                    title="Cambiar tema"
                >
                    <!-- Icono para tema claro (se muestra en modo oscuro) -->
                    <span class="icon-[mdi--white-balance-sunny] hidden dark:inline-block w-5 h-5" aria-hidden="true"></span>
                    <!-- Icono para tema oscuro (se muestra en modo claro) -->
                    <span class="icon-[mdi--moon-waning-crescent] dark:hidden w-5 h-5" aria-hidden="true"></span>
                </button>
                
                <!-- Dropdown del usuario -->
                <div class="relative">
                    <button 
                        type="button"
                        id="user-menu-button" 
                        class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2"
                        aria-expanded="false" 
                        aria-haspopup="true"
                    >
                        <span class="icon-[mdi--account-circle] text-gray-500 dark:text-gray-400 w-6 h-6 mr-2" aria-hidden="true"></span>
                        <span class="text-gray-700 dark:text-gray-300 hidden sm:block font-medium">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="icon-[mdi--chevron-down] text-gray-500 dark:text-gray-400 w-4 h-4 ml-2" aria-hidden="true"></span>
                    </button>

                    <!-- Dropdown menu -->
                    <div 
                        id="user-menu" 
                        class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none border border-gray-200 dark:border-gray-700"
                        role="menu" 
                        aria-orientation="vertical" 
                        aria-labelledby="user-menu-button" 
                        tabindex="-1"
                    >
                        <!-- Header del dropdown -->
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        
                        <!-- Opciones del menú -->
                        <div class="py-1" role="none">
                            <a 
                                href="{{ route('profile.index') }}" 
                                class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-150" 
                                role="menuitem"
                            >
                                <span class="icon-[mdi--account-cog] w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" aria-hidden="true"></span>
                                Configuraciones
                            </a>
                            
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                            
                            <form action="{{ route('logout') }}" method="POST" role="none">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-150 text-left"
                                    role="menuitem"
                                >
                                    <span class="icon-[mdi--logout] w-4 h-4 mr-3 text-gray-500 dark:text-gray-400" aria-hidden="true"></span>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
