<div class="max-w-4xl mx-auto">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium {{ $currentStep >= 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                Datos Personales
            </span>
            <span class="text-sm font-medium {{ $currentStep >= 2 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                Datos del Título
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

    <form wire:submit.prevent="saveTitulo" class="space-y-6">
        <!-- Paso 1: Datos Personales -->
        @if($currentStep === 1)
            <x-card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paso 1: Datos Personales</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Buscar persona en API universitaria o ingresar manualmente</p>
                </x-slot:header>

                <!-- Opción 1: Subida de PDF con extracción automática -->
                <div class="mb-8 p-6 bg-blue-50 rounded-lg border border-blue-200 dark:bg-blue-900/10 dark:border-blue-800">
                    <h4 class="text-md font-medium text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                        <iconify-icon icon="material-symbols:upload-file" class="w-5 h-5 mr-2"></iconify-icon>
                        Opción 1: Cargar PDF (Recomendado)
                    </h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                        Suba el archivo PDF del título para extraer automáticamente el CI y consultar datos en la API universitaria.
                    </p>
                    <livewire:pdf-auto-upload-form />
                </div>

                <!-- Opción 2: Búsqueda manual en API -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200 dark:bg-gray-800/50 dark:border-gray-700">
                    <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <iconify-icon icon="material-symbols:search" class="w-5 h-5 mr-2"></iconify-icon>
                        Opción 2: Búsqueda por CI
                    </h4>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <x-form-field label="Carnet de Identidad">
                                <x-form-input-icon 
                                    type="text" 
                                    wire:model="searchCi" 
                                    placeholder="Ingrese CI para buscar"
                                    icon="material-symbols:badge-outline"
                                />
                            </x-form-field>
                        </div>
                        <div class="flex items-end">
                            <x-button 
                                type="button" 
                                wire:click="searchPersonInApi" 
                                variant="secondary"
                                :disabled="$isSearching"
                            >
                                @if($isSearching)
                                    <iconify-icon icon="material-symbols:progress-activity" class="w-4 h-4 animate-spin mr-2"></iconify-icon>
                                    Buscando...
                                @else
                                    <iconify-icon icon="material-symbols:search" class="w-4 h-4 mr-2"></iconify-icon>
                                    Buscar
                                @endif
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Formulario de datos personales -->
                <div class="grid md:grid-cols-2 gap-6">
                    <x-form-field label="Carnet de Identidad" required>
                        <input type="text" wire:model="personaForm.ci" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Ingrese CI" readonly>
                        @error('personaForm.ci') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Nombres Completos" required>
                        <input type="text" wire:model="personaForm.nombres" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Nombres completos">
                        @error('personaForm.nombres') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Apellido Paterno" required>
                        <input type="text" wire:model="personaForm.apellido_paterno" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Apellido paterno">
                        @error('personaForm.apellido_paterno') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Apellido Materno">
                        <input type="text" wire:model="personaForm.apellido_materno" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Apellido materno">
                        @error('personaForm.apellido_materno') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="País" required>
                        <input type="text" wire:model="personaForm.pais" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="País">
                        @error('personaForm.pais') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>
                </div>

                <!-- Selección de programa académico (si se encontraron datos en API) -->
                @if($personFound && !empty($apiData['programas']))
                    <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200 dark:bg-green-900/10 dark:border-green-800">
                        <h4 class="text-md font-medium text-green-900 dark:text-green-100 mb-4">
                            Programas Académicos Encontrados
                        </h4>
                        <p class="text-sm text-green-700 dark:text-green-300 mb-4">
                            Seleccione el programa académico correspondiente:
                        </p>
                        <div class="space-y-2">
                            @foreach($apiData['programas'] as $index => $programa)
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-green-100 dark:hover:bg-green-900/20 {{ $selectedProgramIndex === $index ? 'border-green-500 bg-green-100 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                                    <input type="radio" 
                                           wire:click="selectProgram({{ $index }})" 
                                           name="programa" 
                                           class="text-green-600 focus:ring-green-500" 
                                           {{ $selectedProgramIndex === $index ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $programa['programa'] }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $programa['facultad'] ?? 'Sin facultad' }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Navegación -->
                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-button 
                        type="button" 
                        wire:click="nextStep" 
                        variant="primary"
                        :disabled="!$this->getPersonDataComplete()"
                    >
                        Continuar
                        <iconify-icon icon="material-symbols:arrow-forward" class="w-4 h-4 ml-2"></iconify-icon>
                    </x-button>
                </div>
            </x-card>
        @endif

        <!-- Paso 2: Datos del Título -->
        @if($currentStep === 2)
            <x-card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paso 2: Datos del Título Académico</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Complete los datos específicos del título académico</p>
                </x-slot:header>

                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    <x-form-field label="Número de Documento" required>
                        <input type="number" min="1" wire:model="tituloForm.nro_documento" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Ej: 123">
                        @error('tituloForm.nro_documento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Fojas" required>
                        <input type="number" min="1" wire:model="tituloForm.fojas" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Ej: 45">
                        @error('tituloForm.fojas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Libro" required>
                        <input type="number" min="1" wire:model="tituloForm.libro" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Ej: 2">
                        @error('tituloForm.libro') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>
                </div>

                <!-- Campo específico del título académico -->
                <div class="mb-6">
                    <x-form-field label="Número de Diploma Académico" required>
                        <input type="text" wire:model="tituloForm.nro_diploma_academico" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Ej: DA-2024-001">
                        @error('tituloForm.nro_diploma_academico') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <x-form-field label="Modalidad de Graduación" required>
                        <select wire:model="tituloForm.graduacion_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Seleccione modalidad</option>
                            @foreach($tituloForm->graduaciones as $graduacion)
                                <option value="{{ $graduacion['id'] }}">{{ $graduacion['medio_graduacion'] }}</option>
                            @endforeach
                        </select>
                        @error('tituloForm.graduacion_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>

                    <x-form-field label="Fecha de Emisión">
                        <input type="date" wire:model="tituloForm.fecha_emision" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               max="{{ date('Y-m-d') }}">
                        @error('tituloForm.fecha_emision') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>
                </div>

                <div class="mb-6">
                    <x-form-field label="Observaciones">
                        <x-form-textarea wire:model="tituloForm.observaciones" 
                                         placeholder="Observaciones adicionales (opcional)" 
                                         rows="4" />
                        @error('tituloForm.observaciones') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </x-form-field>
                </div>

                <!-- Upload de archivo PDF -->
                <div class="mb-6">
                    <x-form-field label="Archivo PDF del Título">
                        @if($tituloForm->tempFilePath && $tituloForm->originalFileName)
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/10 dark:border-green-800">
                                <div class="flex items-center text-green-700 dark:text-green-300">
                                    <iconify-icon icon="material-symbols:check-circle" class="w-5 h-5 mr-2"></iconify-icon>
                                    <span class="text-sm font-medium">Archivo cargado: </span>
                                    <span class="text-sm ml-1">{{ $tituloForm->originalFileName }}</span>
                                </div>
                            </div>
                        @elseif($tituloForm->pdfFile)
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/10 dark:border-blue-800">
                                <div class="flex items-center text-blue-700 dark:text-blue-300">
                                    <iconify-icon icon="material-symbols:upload-file" class="w-5 h-5 mr-2"></iconify-icon>
                                    <span class="text-sm font-medium">Archivo seleccionado: </span>
                                    <span class="text-sm ml-1">{{ $tituloForm->pdfFile->getClientOriginalName() }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <input type="file" accept=".pdf" wire:model="tituloForm.pdfFile" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/20 dark:file:text-blue-300">
                        @error('tituloForm.pdfFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-sm text-gray-500">Archivo PDF, máximo 50MB</p>
                    </x-form-field>
                </div>

                <!-- Navegación -->
                <div class="flex justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-button type="button" wire:click="previousStep" variant="secondary">
                        <iconify-icon icon="material-symbols:arrow-back" class="w-4 h-4 mr-2"></iconify-icon>
                        Anterior
                    </x-button>
                    
                    <x-button type="submit" variant="primary">
                        <iconify-icon icon="material-symbols:save" class="w-4 h-4 mr-2"></iconify-icon>
                        Registrar Título Académico
                    </x-button>
                </div>
            </x-card>
        @endif
    </form>
</div>