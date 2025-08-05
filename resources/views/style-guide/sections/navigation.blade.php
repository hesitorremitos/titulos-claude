<!-- Navegación -->
<section id="navigation" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Navegación</h2>
        <p class="text-gray-600 dark:text-gray-400">Componentes de navegación del sistema</p>
    </div>

    <div class="space-y-8">
        <!-- Navigation Tabs -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Navigation Tabs</h3>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
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
                </nav>
            </div>
        </div>

        <!-- Breadcrumbs -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Breadcrumbs</h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-2 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700/50">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-1 text-xs">
                            <li>
                                <a href="#" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center">
                                    <span class="icon-[mdi--home] w-3 h-3 mr-1"></span>
                                    Dashboard
                                </a>
                            </li>
                            <li class="flex items-center">
                                <span class="icon-[mdi--chevron-right] w-3 h-3 text-gray-400 dark:text-gray-500 mx-1"></span>
                                <a href="#" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Diplomas Académicos</a>
                            </li>
                            <li class="flex items-center">
                                <span class="icon-[mdi--chevron-right] w-3 h-3 text-gray-400 dark:text-gray-500 mx-1"></span>
                                <span class="text-gray-900 dark:text-white font-medium">Menciones</span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
