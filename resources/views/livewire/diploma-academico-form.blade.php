<div class="max-w-4xl mx-auto">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium {{ $currentStep >= 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                Datos Personales
            </span>
            <span class="text-sm font-medium {{ $currentStep >= 2 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                Datos del Diploma
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300 ease-out" 
                 style="width: {{ ($currentStep / 2) * 100 }}%"></div>
        </div>
    </div>

    <!-- Messages -->
    @if (session('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:bg-green-900/20 dark:border-green-600 dark:text-green-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg dark:bg-red-900/20 dark:border-red-600 dark:text-red-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:bg-green-900/20 dark:border-green-600 dark:text-green-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Step 1: Datos Personales -->
    @if($currentStep === 1)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Paso 1: Datos Personales
                </h3>
                <p class="text-blue-100 text-sm mt-1">Busca en el sistema universitario o registra manualmente</p>
            </div>

            <div class="p-6 space-y-8">
                <!-- Sección 1: Búsqueda por CI -->
                <div class="border border-blue-200 dark:border-blue-600 rounded-lg p-4 bg-blue-50 dark:bg-blue-900/20">
                    <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Opción 1: Búsqueda por Cédula de Identidad
                    </h4>
                    <p class="text-blue-800 dark:text-blue-200 text-sm mb-4">
                        Busca automáticamente los datos del estudiante en el sistema universitario
                    </p>
                    
                    <div class="mb-6">
                        <label for="searchCi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cédula de Identidad
                        </label>
                        <div class="flex space-x-3">
                            <div class="flex-1 relative">
                                <input 
                                    type="text" 
                                    id="searchCi"
                                    wire:model="searchCi"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white {{ $isSearching ? 'bg-gray-100 dark:bg-gray-600' : '' }}"
                                    placeholder="Ej: 8631891"
                                    {{ $isSearching ? 'disabled' : '' }}
                                >
                                @if($isSearching)
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                @endif
                                @error('searchCi') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button 
                                type="button"
                                wire:click="searchPersonInApi"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center transition-all duration-200"
                                {{ $isSearching ? 'disabled' : '' }}
                            >
                                @if($isSearching)
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Buscando...
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Buscar
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Divisor -->
                <div class="text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-medium">O</span>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Subida de PDF -->
                <div class="border border-green-200 dark:border-green-600 rounded-lg p-4 bg-green-50 dark:bg-green-900/20">
                    <h4 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Opción 2: Subida Automática de PDF
                    </h4>
                    <p class="text-green-800 dark:text-green-200 text-sm mb-4">
                        Sube un archivo PDF con formato: <code class="bg-green-100 dark:bg-green-800 px-2 py-1 rounded text-xs">[CI]-[nombre completo].pdf</code>
                        <br>El sistema extraerá automáticamente el CI y buscará los datos del estudiante
                    </p>
                    
                    @livewire('pdf-auto-upload-form')
                </div>

                <!-- Indicador de carga visible -->
                @if($isSearching)
                    <div class="border-2 border-blue-200 dark:border-blue-600 rounded-lg p-6 bg-blue-50 dark:bg-blue-900/20 mb-6">
                        <div class="flex items-center justify-center">
                            <div class="flex items-center space-x-3">
                                <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <div>
                                    <p class="text-blue-700 dark:text-blue-300 font-medium">Consultando API Universitaria...</p>
                                    <p class="text-blue-600 dark:text-blue-400 text-sm">Buscando información para CI: {{ $searchCi }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Barra de progreso animada -->
                        <div class="mt-4">
                            <div class="w-full bg-blue-200 dark:bg-blue-800 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Resultado de la búsqueda -->
                @if($personFound && !empty($apiData))
                    <div class="border-2 border-green-200 dark:border-green-600 rounded-lg p-6 bg-green-50 dark:bg-green-900/20 mb-6">
                        <h4 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Persona Encontrada
                        </h4>
                        
                        <!-- Datos personales -->
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nombre completo:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $personaForm->nombres }} {{ $personaForm->paterno }} {{ $personaForm->materno }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">CI:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $personaForm->ci }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de nacimiento:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $personaForm->fecha_nacimiento }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Género:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $personaForm->genero === 'M' ? 'Masculino' : ($personaForm->genero === 'F' ? 'Femenino' : 'Otro') }}
                                </p>
                            </div>
                        </div>

                        <!-- Programas académicos -->
                        @if(!empty($apiData['programas']))
                            <div>
                                <h5 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Programas Académicos Encontrados:</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <span class="font-medium">{{ count($apiData['programas']) }} programa(s) encontrado(s).</span>
                                    @if(count($apiData['programas']) > 1)
                                        <span class="text-red-600 font-medium">*</span> Seleccione obligatoriamente el programa para el cual desea generar el título.
                                    @else
                                        Este programa ha sido seleccionado automáticamente.
                                    @endif
                                </p>
                                <div class="space-y-3">
                                    @foreach($apiData['programas'] as $index => $programa)
                                        <div 
                                            class="border rounded-lg p-4 cursor-pointer transition-all duration-200 {{ $selectedProgramIndex === $index ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-2 ring-blue-200 dark:ring-blue-800' : 'border-gray-200 dark:border-gray-600 hover:border-blue-300' }}"
                                            wire:click="selectProgram({{ $index }})"
                                        >
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $programa['programa'] }}</p>
                                                        @if($selectedProgramIndex === $index)
                                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                                                Seleccionado
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $programa['facultad'] }}</p>
                                                    @if($programa['modalidad_graduacion'] !== 'SIN DATOS')
                                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Modalidad: {{ $programa['modalidad_graduacion'] }}</p>
                                                    @endif
                                                </div>
                                                @if($selectedProgramIndex === $index)
                                                    <svg class="w-5 h-5 text-blue-600 ml-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @error('selectedProgramIndex')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Formulario manual si no se encuentra en API -->
                @if(!$personFound && !empty($searchCi))
                    <div class="border-2 border-orange-200 dark:border-orange-600 rounded-lg p-6 bg-orange-50 dark:bg-orange-900/20">
                        <h4 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Registro Manual
                        </h4>
                        <p class="text-orange-700 dark:text-orange-300 mb-4">
                            No se encontraron datos en el sistema universitario. Complete la información manualmente.
                        </p>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CI <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.ci"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                @error('personaForm.ci') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombres <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.nombres"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                @error('personaForm.nombres') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Apellido Paterno
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.paterno"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                @error('personaForm.paterno') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Apellido Materno
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.materno"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                @error('personaForm.materno') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Nacimiento
                                </label>
                                <input 
                                    type="date" 
                                    wire:model="personaForm.fecha_nacimiento"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                @error('personaForm.fecha_nacimiento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Género
                                </label>
                                <select 
                                    wire:model="personaForm.genero"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                    <option value="">Seleccionar...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                    <option value="O">Otro</option>
                                </select>
                                @error('personaForm.genero') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    País
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.pais"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Ej: Bolivia"
                                >
                                @error('personaForm.pais') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Departamento
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.departamento"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Ej: Potosí"
                                >
                                @error('personaForm.departamento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Provincia
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.provincia"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Ej: Tomás Frías"
                                >
                                @error('personaForm.provincia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Localidad/Ciudad
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="personaForm.localidad"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Ej: Potosí"
                                >
                                @error('personaForm.localidad') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botones de navegación -->
                <div class="flex justify-end mt-6">
                    <button 
                        type="button"
                        wire:click="nextStep"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                        {{ !$this->getPersonDataComplete() ? 'disabled' : '' }}
                    >
                        Continuar
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Step 2: Datos del Diploma -->
    @if($currentStep === 2)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Paso 2: Datos del Diploma Académico
                </h3>
                <p class="text-green-100 text-sm mt-1">Complete la información específica del diploma</p>
            </div>

            <div class="p-6">
                <!-- Resumen de la persona -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Resumen:</h4>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Persona:</h5>
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $personaForm->nombres }} {{ $personaForm->paterno }} {{ $personaForm->materno }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">CI: {{ $personaForm->ci }}</p>
                            @if($personaForm->fecha_nacimiento)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Nacimiento: {{ \Carbon\Carbon::parse($personaForm->fecha_nacimiento)->format('d/m/Y') }}
                                </p>
                            @endif
                            @if($personaForm->departamento || $personaForm->provincia || $personaForm->localidad)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    📍 {{ collect([$personaForm->localidad, $personaForm->provincia, $personaForm->departamento])->filter()->implode(', ') }}
                                </p>
                            @endif
                        </div>
                        
                        @if($selectedProgramName)
                            <div>
                                <h5 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Programa Académico:</h5>
                                <p class="text-gray-700 dark:text-gray-300">{{ $selectedProgramName }}</p>
                                @if($selectedCarreraId)
                                    <p class="text-sm text-green-600 dark:text-green-400">✓ Carrera encontrada en el sistema</p>
                                @else
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400">⚠ Carrera no encontrada en el sistema</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Formulario de diploma -->
                <div class="space-y-6">
                    <!-- Sección: Identificación del Documento -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <h5 class="font-semibold text-blue-900 dark:text-blue-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Identificación del Documento
                        </h5>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nro. Documento <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="diplomaForm.nro_documento"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    min="1"
                                    placeholder="123"
                                >
                                @error('diplomaForm.nro_documento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fojas <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="diplomaForm.fojas"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    min="1"
                                    placeholder="45"
                                >
                                @error('diplomaForm.fojas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Libro <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="diplomaForm.libro"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    min="1"
                                    placeholder="7"
                                >
                                @error('diplomaForm.libro') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            💡 Estos datos identifican de manera única el diploma en el registro físico
                        </p>
                    </div>

                    <!-- Sección: Información Académica -->
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
                        <h5 class="font-semibold text-green-900 dark:text-green-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                            Información Académica
                        </h5>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mención <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="diplomaForm.mencion_da_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                    <option value="">Seleccionar mención...</option>
                                    @foreach($diplomaForm->menciones as $mencion)
                                        <option value="{{ $mencion['id'] }}">
                                            {{ $mencion['nombre'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('diplomaForm.mencion_da_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                @if(empty($diplomaForm->menciones))
                                    <p class="mt-1 text-sm text-yellow-600">
                                        ⚠ No hay menciones disponibles. Selecciona un programa académico en el paso anterior.
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Modalidad de Graduación <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="diplomaForm.graduacion_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                >
                                    <option value="">Seleccionar modalidad...</option>
                                    @foreach($diplomaForm->graduaciones as $graduacion)
                                        <option value="{{ $graduacion['id'] }}">
                                            {{ $graduacion['medio_graduacion'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('diplomaForm.graduacion_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección: Fecha y Observaciones -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-4">
                        <h5 class="font-semibold text-purple-900 dark:text-purple-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Fecha y Observaciones
                        </h5>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Emisión
                                </label>
                                <input 
                                    type="date" 
                                    wire:model="diplomaForm.fecha_emision"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    max="{{ date('Y-m-d') }}"
                                >
                                @error('diplomaForm.fecha_emision') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Observaciones
                                </label>
                                <textarea 
                                    wire:model="diplomaForm.observaciones"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Observaciones adicionales, notas especiales..."
                                ></textarea>
                                @error('diplomaForm.observaciones') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload de PDF -->
                    <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h5 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Archivo PDF del Diploma
                        </h5>

                        @if($diplomaForm->tempFilePath && $diplomaForm->originalFileName)
                            <!-- Archivo ya subido desde paso 1 -->
                            <div class="border-2 border-green-300 dark:border-green-600 rounded-lg p-6 bg-green-50 dark:bg-green-900/20">
                                <div class="flex items-center justify-center space-x-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                            ✅ Archivo PDF ya subido en paso anterior
                                        </p>
                                        <p class="text-xs text-green-700 dark:text-green-300">
                                            {{ $diplomaForm->originalFileName }}
                                        </p>
                                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                            El archivo se asociará automáticamente al diploma al guardar
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($diplomaForm->pdfFile)
                            <!-- Archivo subido manualmente en paso 2 -->
                            <div class="border-2 border-blue-300 dark:border-blue-600 rounded-lg p-6 bg-blue-50 dark:bg-blue-900/20">
                                <div class="flex items-center justify-center space-x-3">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                            📄 Archivo PDF seleccionado
                                        </p>
                                        <p class="text-xs text-blue-700 dark:text-blue-300">
                                            {{ $diplomaForm->pdfFile->getClientOriginalName() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Área de upload manual -->
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                                <input 
                                    type="file" 
                                    wire:model="diplomaForm.pdfFile"
                                    accept=".pdf"
                                    class="hidden"
                                    id="pdfUpload"
                                >
                                <label for="pdfUpload" class="cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-blue-600 hover:text-blue-500">Haz clic para subir</span>
                                            o arrastra el archivo aquí
                                        </p>
                                        <p class="text-xs text-gray-500">PDF hasta 50MB (opcional)</p>
                                    </div>
                                </label>
                            </div>
                        @endif
                        
                        @error('diplomaForm.pdfFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Botones de navegación -->
                <div class="flex justify-between mt-8">
                    <button 
                        type="button"
                        wire:click="previousStep"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Anterior
                    </button>

                    <button 
                        type="button"
                        wire:click="saveDiploma"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Diploma
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>