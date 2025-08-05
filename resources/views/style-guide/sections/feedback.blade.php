<!-- Estados de Retroalimentación -->
<section id="feedback" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Estados de Retroalimentación</h2>
        <p class="text-gray-600 dark:text-gray-400">Componentes de alerta y feedback visual para diferentes estados del sistema</p>
    </div>

    <div class="space-y-8">
        <!-- Estados de Alerta -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estados de Alerta</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Alertas inline para diferentes contextos y niveles de importancia
                </p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Alerta de Éxito -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Estado de Éxito</h4>
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-200">¡Operación exitosa!</h4>
                                <p class="mt-1 text-sm text-green-700 dark:text-green-300">Los cambios se han guardado correctamente en el sistema.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerta de Error -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Estado de Error</h4>
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-200">Error en la operación</h4>
                                <p class="mt-1 text-sm text-red-700 dark:text-red-300">Ha ocurrido un error. Por favor, revisa los datos e intenta nuevamente.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerta de Advertencia -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Estado de Advertencia</h4>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Atención requerida</h4>
                                <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">Esta acción podría tener consecuencias importantes. Confirma antes de continuar.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerta de Información -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Estado de Información</h4>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Información importante</h4>
                                <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">Ten en cuenta esta información para completar el proceso correctamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estados de Carga -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estados de Carga</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Indicadores visuales para procesos en curso y estados de carga
                </p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Spinner básico -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Spinner de Carga</h4>
                    <div class="flex items-center space-x-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                        <span class="text-gray-600 dark:text-gray-400">Cargando...</span>
                    </div>
                </div>

                <!-- Barra de progreso -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Barra de Progreso</h4>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span>Progreso</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 65%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span>Subiendo archivo</span>
                                <span>85%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skeleton loading -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Skeleton Loading</h4>
                    <div class="space-y-4">
                        <div class="animate-pulse">
                            <div class="flex items-center space-x-4">
                                <div class="rounded-full bg-gray-300 dark:bg-gray-600 h-10 w-10"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-1/2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="animate-pulse">
                            <div class="space-y-3">
                                <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-5/6"></div>
                                <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-4/6"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estados de botones -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Estados de Botones</h4>
                    <div class="flex flex-wrap gap-4">
                        <!-- Botón normal -->
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition-colors">
                            Acción Normal
                        </button>
                        
                        <!-- Botón cargando -->
                        <button disabled class="bg-indigo-400 text-white px-4 py-2 rounded-md cursor-not-allowed flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Procesando...
                        </button>
                        
                        <!-- Botón deshabilitado -->
                        <button disabled class="bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 px-4 py-2 rounded-md cursor-not-allowed">
                            Deshabilitado
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estados Vacíos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estados Vacíos</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Pantallas de estados vacíos con llamadas a la acción
                </p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Estado vacío básico -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Sin Datos</h4>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay elementos</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primer elemento.</p>
                        <div class="mt-6">
                            <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Crear elemento
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Estado de búsqueda sin resultados -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Sin Resultados de Búsqueda</h4>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No se encontraron resultados</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Intenta con otros términos de búsqueda.</p>
                        <div class="mt-6">
                            <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Códigos de Ejemplo -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Códigos de Ejemplo</h3>
            </div>
            <div class="p-6 space-y-6">
                <!-- Alerta básica -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Estructura de Alerta</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm"><code>{{-- Alerta de éxito --}}
&lt;div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4"&gt;
    &lt;div class="flex items-center"&gt;
        &lt;div class="flex-shrink-0"&gt;
            &lt;svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"&gt;
                &lt;path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /&gt;
            &lt;/svg&gt;
        &lt;/div&gt;
        &lt;div class="ml-3"&gt;
            &lt;h4 class="text-sm font-medium text-green-800 dark:text-green-200"&gt;Título&lt;/h4&gt;
            &lt;p class="mt-1 text-sm text-green-700 dark:text-green-300"&gt;Mensaje descriptivo&lt;/p&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>

                <!-- Spinner de carga -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Spinner de Carga</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm"><code>{{-- Spinner básico --}}
&lt;div class="flex items-center space-x-4"&gt;
    &lt;div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"&gt;&lt;/div&gt;
    &lt;span class="text-gray-600 dark:text-gray-400"&gt;Cargando...&lt;/span&gt;
&lt;/div&gt;

{{-- Botón con spinner --}}
&lt;button disabled class="bg-indigo-400 text-white px-4 py-2 rounded-md cursor-not-allowed flex items-center"&gt;
    &lt;svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"&gt;
        &lt;circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"&gt;&lt;/circle&gt;
        &lt;path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"&gt;&lt;/path&gt;
    &lt;/svg&gt;
    Procesando...
&lt;/button&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mejores Prácticas -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-200 mb-4">Mejores Prácticas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-amber-900 dark:text-amber-200 mb-2">Estados de Retroalimentación</h4>
                    <ul class="text-sm text-amber-800 dark:text-amber-300 space-y-1">
                        <li>• Usa colores consistentes para cada tipo de estado</li>
                        <li>• Incluye iconos para mejor reconocimiento visual</li>
                        <li>• Proporciona mensajes claros y accionables</li>
                        <li>• Considera la accesibilidad y contraste</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-amber-900 dark:text-amber-200 mb-2">Estados de Carga</h4>
                    <ul class="text-sm text-amber-800 dark:text-amber-300 space-y-1">
                        <li>• Muestra indicadores para procesos de más de 1 segundo</li>
                        <li>• Usa barras de progreso para procesos medibles</li>
                        <li>• Implementa skeleton loading para contenido estructurado</li>
                        <li>• Deshabilita controles durante operaciones críticas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
