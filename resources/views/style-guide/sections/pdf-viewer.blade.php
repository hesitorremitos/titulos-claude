<!-- Visor PDF -->
<section id="pdf-viewer" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visor PDF con Drag & Drop</h2>
        <p class="text-gray-600 dark:text-gray-400">Componente para visualizar PDFs con carga por arrastrar y soltar usando el viewer nativo del navegador</p>
    </div>

    <div class="space-y-8">
        <!-- Ejemplo Visual -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ejemplo Interactivo</h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <x-pdf-viewer 
                    height="400px" 
                    :max-file-size="50" 
                    :show-progress="true" 
                    :show-file-list="true" 
                />
            </div>
        </div>

        <!-- Parámetros del Componente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Parámetros del Componente</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Parámetro</th>
                            <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Tipo</th>
                            <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Por Defecto</th>
                            <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Descripción</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">height</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'400px'</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Altura del visor PDF</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">max-file-size</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">number</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">50</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Tamaño máximo de archivo en MB</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">show-progress</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">true</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Mostrar barra de progreso</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">show-file-list</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">true</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Mostrar lista de archivos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Uso del Componente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Uso del Componente</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Sintaxis para usar el componente PDF Viewer</p>
            </div>
            <div class="bg-gray-900 p-6 overflow-x-auto">
                <pre class="text-green-400 text-sm"><code>&lt;x-pdf-viewer 
    height="400px" 
    :max-file-size="50" 
    :show-progress="true" 
    :show-file-list="true" 
/&gt;

&lt;!-- Ejemplo con parámetros personalizados --&gt;
&lt;x-pdf-viewer 
    height="300px" 
    :max-file-size="25" 
    :show-progress="false" 
    :show-file-list="false" 
/&gt;</code></pre>
            </div>
        </div>
    </div>
</section>
