<!-- Notificaciones Toast -->
<section id="toasts" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Sistema de Notificaciones Toast</h2>
        <p class="text-gray-600 dark:text-gray-400">Notificaciones no intrusivas con diferentes variantes y configuraciones</p>
    </div>

    <div class="space-y-8">
        <!-- Descripción del Sistema -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Características del Sistema</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Tipos de Notificación</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Éxito (Success) - Operaciones completadas</li>
                        <li>• Error - Errores del sistema o validación</li>
                        <li>• Advertencia (Warning) - Atención requerida</li>
                        <li>• Información (Info) - Mensajes informativos</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Funcionalidades</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Auto-dismiss configurable</li>
                        <li>• Cierre manual por usuario</li>
                        <li>• Stack automático para múltiples toasts</li>
                        <li>• Animaciones suaves de entrada/salida</li>
                        <li>• Posicionamiento fijo (esquina superior derecha)</li>
                        <li>• Títulos estáticos por tipo de notificación</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Componente de Prueba del Toast -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Botón de Prueba Simple</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Un botón simple que emite eventos con parámetros configurables
                </p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Ejemplo básico -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Ejemplo Básico</h4>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <livewire:button-test />
                    </div>
                </div>

                <!-- Ejemplos con parámetros -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Ejemplos con Parámetros</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Toast de éxito -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Éxito:</p>
                            <livewire:button-test 
                                event="toast:success" 
                                label="Éxito" 
                                message="¡Operación completada!" />
                        </div>

                        <!-- Toast de error -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Error:</p>
                            <livewire:button-test 
                                event="toast:error" 
                                label="Error" 
                                message="Algo salió mal" />
                        </div>

                        <!-- Toast de advertencia -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Advertencia:</p>
                            <livewire:button-test 
                                event="toast:warning" 
                                label="Advertencia" 
                                message="Atención requerida" />
                        </div>

                        <!-- Toast de información -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Información:</p>
                            <livewire:button-test 
                                event="toast:info" 
                                label="Info" 
                                message="Información útil" />
                        </div>
                    </div>
                </div>

                <!-- Código de ejemplo -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Código de Ejemplo</h4>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <pre class="text-green-400 text-sm"><code>{{-- Uso básico --}}
&lt;livewire:button-test /&gt;

{{-- Con parámetros personalizados --}}
&lt;livewire:button-test 
    event="toast:success" 
    label="Guardar" 
    message="Datos guardados correctamente" /&gt;

{{-- Evento personalizado con datos extra --}}
&lt;livewire:button-test 
    event="custom-event" 
    label="Acción" 
    message="Evento disparado"
    :event-data="['extra' => 'data']" /&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentación de Uso -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Implementación</h3>
            
            <div class="space-y-6">
                <!-- Uso desde Livewire -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Desde Componentes Livewire</h4>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <pre class="text-sm text-gray-800 dark:text-gray-200"><code>// Notificación de éxito
$this->dispatch('toast:success', [
    'message' => 'Operación completada exitosamente',
    'duration' => 5000
]);

// Notificación de error
$this->dispatch('toast:error', [
    'message' => 'Error al procesar la solicitud'
]);

// Notificación persistente (sin auto-dismiss)
$this->dispatch('toast:info', [
    'message' => 'Información importante',
    'duration' => 0
]);</code></pre>
                    </div>
                </div>

                <!-- Uso desde JavaScript -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Desde JavaScript</h4>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <pre class="text-sm text-gray-800 dark:text-gray-200"><code>// Funciones globales disponibles
showSuccessToast('Mensaje de éxito');
showErrorToast('Mensaje de error', 8000);
showWarningToast('Advertencia', 3000);
showInfoToast('Información');

// Función genérica
showToast('success', 'Mensaje', 5000);</code></pre>
                    </div>
                </div>

                <!-- Eventos Disponibles -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Eventos Livewire</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800">
                                <code class="text-sm font-mono text-green-700 dark:text-green-300">toast:success</code>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded border border-red-200 dark:border-red-800">
                                <code class="text-sm font-mono text-red-700 dark:text-red-300">toast:error</code>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded border border-yellow-200 dark:border-yellow-800">
                                <code class="text-sm font-mono text-yellow-700 dark:text-yellow-300">toast:warning</code>
                            </div>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded border border-blue-200 dark:border-blue-800">
                                <code class="text-sm font-mono text-blue-700 dark:text-blue-300">toast:info</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parámetros -->
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Parámetros</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Parámetro</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Tipo</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Requerido</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Descripción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                <tr>
                                    <td class="px-4 py-3 font-mono text-gray-900 dark:text-white">message</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">string</td>
                                    <td class="px-4 py-3 text-green-600 dark:text-green-400">Sí</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Contenido del mensaje</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-mono text-gray-900 dark:text-white">duration</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">int|null</td>
                                    <td class="px-4 py-3 text-gray-500 dark:text-gray-500">No</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Duración en ms (0 = persistente)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mejores Prácticas -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-4">Mejores Prácticas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-blue-900 dark:text-blue-200 mb-2">Cuándo Usar</h4>
                    <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                        <li>• Confirmación de acciones exitosas</li>
                        <li>• Notificación de errores de validación</li>
                        <li>• Alertas de proceso en curso</li>
                        <li>• Información contextual no crítica</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-blue-900 dark:text-blue-200 mb-2">Consideraciones</h4>
                    <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                        <li>• Mensajes claros y concisos</li>
                        <li>• Duración apropiada según importancia</li>
                        <li>• No abusar de toasts persistentes</li>
                        <li>• Evitar múltiples toasts simultáneos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
