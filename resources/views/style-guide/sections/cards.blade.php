<!-- Cards -->
<section id="cards" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Cards y Contenedores</h2>
        <p class="text-gray-600 dark:text-gray-400">Componentes de tarjetas y contenedores</p>
    </div>

    <div class="space-y-8">
        <!-- Card Básica -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Card Básica</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card title="Título de la Card" description="Descripción breve de la tarjeta">
                    <p class="text-gray-600 dark:text-gray-400">
                        Contenido de la tarjeta. Este es un ejemplo de cómo se ve el contenido principal dentro de una card básica.
                    </p>
                    <div class="flex space-x-2 mt-4">
                        <x-button variant="primary" size="sm">Acción Principal</x-button>
                        <x-button variant="secondary" size="sm">Acción Secundaria</x-button>
                    </div>
                </x-card>

                <x-card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Header Personalizado</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Badge</span>
                        </div>
                    </x-slot>
                    <p class="text-gray-600 dark:text-gray-400">
                        Card con header slot personalizado. Permite mayor flexibilidad en el diseño del encabezado.
                    </p>
                </x-card>
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tarjetas de Estadísticas</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="icon-[mdi--school] w-8 h-8 text-blue-500"></span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Diplomas
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                        1,234
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="icon-[mdi--clock-outline] w-8 h-8 text-yellow-500"></span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Pendientes
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                        45
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="icon-[mdi--check-circle] w-8 h-8 text-green-500"></span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Digitalizados
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                        1,189
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="icon-[mdi--account-multiple] w-8 h-8 text-purple-500"></span>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Usuarios Activos
                                    </dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                        12
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código HTML directo:</p>
                <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                    &lt;div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg"&gt;...&lt;/div&gt;
                </code>
            </div>
        </div>
    </div>
</section>
