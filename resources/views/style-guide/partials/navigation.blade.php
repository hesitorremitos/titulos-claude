<!-- Navigation -->
<nav class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3">
            <div class="flex space-x-6 flex-wrap gap-y-2">
                <a href="#colors" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Colores</a>
                <a href="#typography" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Tipografía</a>
                <a href="#buttons" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Botones</a>
                <a href="#forms" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Formularios</a>
                <a href="#dashboard" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
                <a href="#complete-form" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Formulario Completo</a>
                <a href="#cards" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Cards</a>
                <a href="#navigation" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Navegación</a>
                <a href="#icons" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Iconos</a>
                <a href="#toasts" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Notificaciones Toast</a>
                <a href="#searchable-select" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Select Buscable</a>
                <a href="#pdf-viewer" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Visor PDF</a>
                <a href="#feedback" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Feedback</a>
            </div>
            
            <!-- Dark Mode Toggle with Alpine.js -->
            <div x-data="darkModeToggle()" class="ml-4">
                <button @click="toggle()" 
                        class="flex items-center justify-center p-2 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors"
                        :aria-label="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'">
                    <span :class="isDark ? 'icon-[mdi--weather-night] w-5 h-5' : 'icon-[mdi--weather-sunny] w-5 h-5'" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</nav>
