<!-- Formularios -->
<section id="forms" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Formularios</h2>
        <p class="text-gray-600 dark:text-gray-400">Componentes de formularios del sistema</p>
    </div>

    <div class="space-y-8">
        <!-- Inputs de Texto -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campos de Texto</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombre Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" 
                           placeholder="Ingrese su nombre completo"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                           required>
                </div>
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Carnet de Identidad
                    </label>
                    <div class="relative">
                        <span class="icon-[mdi--card-account-details] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                        <input type="text" id="ci" name="ci" 
                               placeholder="1234567 LP"
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <span class="icon-[mdi--email] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                        <input type="email" id="email" name="email" 
                               placeholder="usuario@correo.com"
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                </div>
                <div>
                    <label for="error_field" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Campo con Error
                    </label>
                    <input type="text" id="error_field" name="error_field" 
                           value="Valor incorrecto"
                           class="w-full px-3 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">Este campo contiene un error de validación</p>
                </div>
            </div>
        </div>

        <!-- Select -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Selectores</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="facultad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Facultad <span class="text-red-500">*</span>
                    </label>
                    <select id="facultad" name="facultad" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Seleccione una facultad</option>
                        <option value="1">Facultad de Ingeniería</option>
                        <option value="2">Facultad de Ciencias Económicas</option>
                        <option value="3">Facultad de Medicina</option>
                    </select>
                </div>
                <div>
                    <label for="carrera" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Carrera
                    </label>
                    <select id="carrera" name="carrera"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Seleccione una carrera</option>
                        <option value="1">Ingeniería de Sistemas</option>
                        <option value="2">Ingeniería Civil</option>
                        <option value="3">Ingeniería Industrial</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Estados de Validación -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estados de Validación</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campo Válido</label>
                    <input type="text" value="Dato correcto" class="w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-green-600 dark:text-green-400 text-sm mt-1">Campo validado correctamente</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campo con Error</label>
                    <input type="text" value="Dato incorrecto" class="w-full px-3 py-2 border border-red-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">Este campo es requerido</p>
                </div>
            </div>
        </div>

        <!-- Componente Form Field -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Componente Form Field</h3>
            <div class="space-y-6">
                <x-form-field label="Nombre Completo" name="nombre" required>
                    <input type="text" id="nombre" name="nombre" 
                           placeholder="Ingrese su nombre completo"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                </x-form-field>

                <x-form-field label="Email" name="email" required help="Introduzca un email válido para recibir notificaciones">
                    <input type="email" id="email" name="email" 
                           placeholder="usuario@ejemplo.com"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                </x-form-field>

                <x-form-field label="Contraseña" name="password" required error="La contraseña debe tener al menos 8 caracteres">
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                </x-form-field>
            </div>
            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                    &lt;x-form-field label="Nombre" name="nombre" required&gt;...&lt;/x-form-field&gt;
                </code>
            </div>
        </div>

        <!-- Componente Data Table -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Componente Data Table</h3>
            <x-data-table>
                <x-slot name="header">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            Juan Pérez
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            juan.perez@uatf.edu.bo
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Administrador
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <x-button variant="outline" size="sm" icon="icon-[mdi--pencil]">
                                    Editar
                                </x-button>
                                <x-button variant="danger" size="sm" icon="icon-[mdi--delete]">
                                    Eliminar
                                </x-button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            María García
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            maria.garcia@uatf.edu.bo
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Editor
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Pendiente
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <x-button variant="outline" size="sm" icon="icon-[mdi--pencil]">
                                    Editar
                                </x-button>
                                <x-button variant="danger" size="sm" icon="icon-[mdi--delete]">
                                    Eliminar
                                </x-button>
                            </div>
                        </td>
                    </tr>
                </x-slot>
            </x-data-table>
            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                    &lt;x-data-table&gt;&lt;x-slot name="header"&gt;...&lt;/x-slot&gt;&lt;x-slot name="body"&gt;...&lt;/x-slot&gt;&lt;/x-data-table&gt;
                </code>
            </div>
        </div>
    </div>
</section>
