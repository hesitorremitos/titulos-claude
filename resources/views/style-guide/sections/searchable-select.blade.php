<!-- Select Buscable -->
<section id="searchable-select" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Select Buscable con Alpine.js</h2>
        <p class="text-gray-600 dark:text-gray-400">Componente select con búsqueda integrada, navegación por teclado y accesibilidad completa</p>
    </div>

    <div class="space-y-8">
        <!-- Ejemplo Básico -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ejemplo Básico</h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="max-w-md">
                    @php
                    $careers = [
                        ['id' => 1, 'name' => 'Ingeniería de Sistemas'],
                        ['id' => 2, 'name' => 'Ingeniería Civil'],
                        ['id' => 3, 'name' => 'Medicina'],
                        ['id' => 4, 'name' => 'Derecho'],
                        ['id' => 5, 'name' => 'Arquitectura'],
                        ['id' => 6, 'name' => 'Ingeniería Industrial'],
                        ['id' => 7, 'name' => 'Psicología'],
                        ['id' => 8, 'name' => 'Contaduría Pública']
                    ];
                    @endphp
                    
                    <x-searchable-select 
                        :options="$careers"
                        label="Seleccionar Carrera"
                        placeholder="Seleccionar una carrera..."
                        search-placeholder="Buscar carrera..."
                        name="career_id"
                        :required="true"
                    />
                </div>
            </div>
        </div>

        <!-- Ejemplo con Datos Personalizados -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Con Claves Personalizadas</h3>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="max-w-md">
                    @php
                    $customOptions = [
                        ['codigo' => 'ING-SIS', 'descripcion' => 'Ingeniería de Sistemas'],
                        ['codigo' => 'ING-CIV', 'descripcion' => 'Ingeniería Civil'],
                        ['codigo' => 'MED', 'descripcion' => 'Medicina'],
                        ['codigo' => 'DER', 'descripcion' => 'Derecho']
                    ];
                    @endphp
                    
                    <x-searchable-select 
                        :options="$customOptions"
                        label="Seleccionar con Claves Personalizadas"
                        placeholder="Seleccionar opción..."
                        value-key="codigo"
                        label-key="descripcion"
                        name="custom_field"
                    />
                </div>
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
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">options</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">array</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">[]</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Array de opciones disponibles</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">selected</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">mixed</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Opción preseleccionada</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">placeholder</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'Seleccionar opción'</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Texto cuando no hay selección</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">label</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Etiqueta del campo</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">name</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Nombre del campo para formularios</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">required</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">false</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Campo obligatorio</td>
                        </tr>
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">value-key</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'id'</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Clave para el valor de cada opción</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">label-key</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'name'</td>
                            <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Clave para la etiqueta de cada opción</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Uso del Componente -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Uso del Componente</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Sintaxis para usar el componente Select Buscable</p>
            </div>
            <div class="bg-gray-900 p-6 overflow-x-auto">
                <pre class="text-green-400 text-sm"><code>&lt;!-- Uso básico --&gt;
&lt;x-searchable-select 
    :options="$options"
    label="Seleccionar Opción"
    name="field_name"
    :required="true"
/&gt;

&lt;!-- Con claves personalizadas --&gt;
&lt;x-searchable-select 
    :options="$customOptions"
    label="Campo Personalizado"
    placeholder="Elegir una opción..."
    value-key="codigo"
    label-key="descripcion"
    name="custom_field"
/&gt;

&lt;!-- Con valor preseleccionado --&gt;
&lt;x-searchable-select 
    :options="$options"
    :selected="$selectedOption"
    label="Con Preselección"
    name="preselected_field"
/&gt;

&lt;!-- Escuchar cambios con Alpine.js --&gt;
&lt;div @select-changed="handleSelectChange($event.detail)"&gt;
    &lt;x-searchable-select :options="$options" /&gt;
&lt;/div&gt;</code></pre>
            </div>
        </div>

        <!-- Funcionalidades -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Funcionalidades</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Interacción</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Búsqueda en tiempo real</li>
                        <li>• Navegación por teclado (↑↓)</li>
                        <li>• Selección con Enter</li>
                        <li>• Cerrar con Escape</li>
                        <li>• Click outside para cerrar</li>
                        <li>• Focus automático en búsqueda</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Características</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Totalmente accesible</li>
                        <li>• Compatible con formularios</li>
                        <li>• Validación integrada</li>
                        <li>• Eventos personalizados</li>
                        <li>• Claves configurables</li>
                        <li>• Responsive design</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
