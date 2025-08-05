<!-- Header -->
<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 z-30">
    <!-- Top Navigation Bar -->
    <div class="px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 -mb-px">
            <!-- Header: Left side -->
            <div class="flex items-center space-x-3">
                <!-- Hamburger button -->
                <button 
                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 lg:hidden" 
                    @click.stop="sidebarOpen = !sidebarOpen" 
                    aria-controls="sidebar" 
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Abrir sidebar</span>
                    <span class="icon-[mdi--menu] w-6 h-6"></span>
                </button>
                
                <!-- Page Title -->
                <div class="hidden lg:block">
                    {{ $header ?? '' }}
                </div>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                <!-- Cambio de Tema -->
                <button id="theme-toggle" 
                        class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors"
                        title="Cambiar tema">
                    <span class="icon-[mdi--weather-sunny] dark:hidden w-5 h-5"></span>
                    <span class="icon-[mdi--weather-night] hidden dark:block w-5 h-5"></span>
                </button>
                
                <!-- Separator -->
                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></div>

                <!-- Usuario Profile Dropdown -->
                <div x-data="{ menuIsOpen: false }" x-on:keydown.esc.window="menuIsOpen = false" class="relative">
                    <button type="button" class="flex items-center space-x-3 transition-colors" aria-haspopup="true" x-on:click="menuIsOpen = ! menuIsOpen" :aria-expanded="menuIsOpen">
                        <div class="w-8 h-8 bg-secondary-500 rounded-full flex items-center justify-center">
                            <span class="icon-[mdi--account] w-5 h-5 text-white"></span>
                        </div>
                        <div class="hidden md:block text-sm text-left">
                            <p class="font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                        </div>
                        <span class="hidden md:block icon-[mdi--chevron-down] w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': menuIsOpen }"></span>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-cloak x-show="menuIsOpen" x-on:click.outside="menuIsOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-trap="menuIsOpen" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 z-50">
                        <!-- Profile Section -->
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <a href="{{ route('profile.index') }}" class="flex items-center space-x-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 py-2 rounded-md transition-colors" role="menuitem">
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
                                <span class="icon-[mdi--help-circle] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                <span>Ayuda</span>
                            </a>
                        </div>
                        
                        <!-- Sign Out Section -->
                        <div class="py-1 border-t border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="flex items-center space-x-3 px-6 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left" role="menuitem">
                                    <span class="icon-[mdi--logout] w-5 h-5"></span>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>