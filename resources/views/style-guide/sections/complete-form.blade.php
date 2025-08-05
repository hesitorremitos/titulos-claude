<!-- Formulario Completo -->
<section id="complete-form" class="mb-16">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Formulario Completo</h2>
        <p class="text-gray-600 dark:text-gray-400">Ejemplo de formulario completo para registro de diplomas académicos</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-8">
        <form class="space-y-8">
            <!-- Header del Formulario -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Registro de Diploma Académico</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete la información del diploma académico a registrar</p>
            </div>

            <!-- Información Personal -->
            <div>
                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información Personal</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ci2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Carnet de Identidad <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="icon-[mdi--card-account-details] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                            <input type="text" id="ci2" name="ci" placeholder="1234567 LP" required
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                    </div>
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombres <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nombres" name="nombres" placeholder="Juan Carlos" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Apellido Paterno <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" placeholder="Mamani" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="apellido_materno" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Apellido Materno
                        </label>
                        <input type="text" id="apellido_materno" name="apellido_materno" placeholder="Condori"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Nacimiento <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="lugar_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lugar de Nacimiento
                        </label>
                        <input type="text" id="lugar_nacimiento" name="lugar_nacimiento" placeholder="Potosí, Bolivia"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div>
                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información Académica</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="facultad_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Facultad <span class="text-red-500">*</span>
                        </label>
                        <select id="facultad_id" name="facultad_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Seleccione una facultad</option>
                            <option value="1">Facultad de Ingeniería</option>
                            <option value="2">Facultad de Ciencias Económicas</option>
                            <option value="3">Facultad de Medicina</option>
                            <option value="4">Facultad de Derecho</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="carrera_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Carrera <span class="text-red-500">*</span>
                        </label>
                        <select id="carrera_id" name="carrera_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Seleccione una carrera</option>
                            <option value="1">Ingeniería de Sistemas</option>
                            <option value="2">Ingeniería Civil</option>
                            <option value="3">Ingeniería Industrial</option>
                        </select>
                    </div>

                    <div>
                        <label for="mencion_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mención
                        </label>
                        <select id="mencion_id" name="mencion_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Sin mención específica</option>
                            <option value="1">Sistemas de Información</option>
                            <option value="2">Redes y Telecomunicaciones</option>
                            <option value="3">Desarrollo de Software</option>
                        </select>
                    </div>

                    <div>
                        <label for="graduacion_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Modalidad de Graduación <span class="text-red-500">*</span>
                        </label>
                        <select id="graduacion_id" name="graduacion_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Seleccione modalidad</option>
                            <option value="1">Tesis de Grado</option>
                            <option value="2">Proyecto de Grado</option>
                            <option value="3">Trabajo Dirigido</option>
                            <option value="4">Examen de Grado</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Información del Diploma -->
            <div>
                <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información del Diploma</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="libro" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número de Libro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="libro" name="libro" placeholder="001" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="fojas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número de Fojas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="fojas" name="fojas" placeholder="123" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="nro_documento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número de Documento <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nro_documento" name="nro_documento" placeholder="D-2024-001" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="fecha_emision" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Emisión <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="fecha_emision" name="fecha_emision" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="gestion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Gestión Académica <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="gestion" name="gestion" placeholder="2024" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="estado" name="estado" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Seleccione estado</option>
                            <option value="digitalizado">Digitalizado</option>
                            <option value="pendiente">Pendiente de digitalización</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- Observaciones -->
            <div>
                <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Observaciones
                </label>
                <textarea 
                    id="observaciones" 
                    name="observaciones" 
                    rows="4" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Ingrese cualquier observación adicional sobre el diploma..."
                ></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <x-button variant="outline" type="button" icon="icon-[mdi--close]">
                    Cancelar
                </x-button>
                <x-button variant="secondary" type="button" icon="icon-[mdi--content-save]">
                    Guardar Borrador
                </x-button>
                <x-button variant="primary" type="submit" icon="icon-[mdi--check]">
                    Registrar Diploma
                </x-button>
            </div>
        </form>
    </div>
</section>
