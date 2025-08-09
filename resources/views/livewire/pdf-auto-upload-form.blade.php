<div class="space-y-4">
    <!-- Área de subida de archivo con drag and drop -->
    <div 
        class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center bg-white dark:bg-gray-800 transition-all duration-200 hover:border-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50"
        x-data="{ 
            dragOver: false,
            handleDrop(e) {
                e.preventDefault();
                this.dragOver = false;
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type === 'application/pdf') {
                    // Simular click en el input file
                    const inputFile = document.getElementById('pdfFormFileInput');
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[0]);
                    inputFile.files = dataTransfer.files;
                    
                    // Disparar evento change
                    const event = new Event('change', { bubbles: true });
                    inputFile.dispatchEvent(event);
                }
            },
            handleDragOver(e) {
                e.preventDefault();
                this.dragOver = true;
            },
            handleDragLeave(e) {
                e.preventDefault();
                this.dragOver = false;
            }
        }"
        @drop="handleDrop"
        @dragover="handleDragOver"
        @dragleave="handleDragLeave"
        :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 scale-105': dragOver }"
    >
        <div class="space-y-4">
            <!-- Input de archivo estilo guía de estilos -->
            <div class="relative">
                <input 
                    type="file" 
                    wire:model.live="pdfFile" 
                    accept=".pdf"
                    class="hidden" 
                    id="pdfFormFileInput"
                >
                
                <!-- Icono y área principal -->
                <div class="space-y-3">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    
                    <div>
                        <label 
                            for="pdfFormFileInput" 
                            class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                        >
                            <span class="icon-[mdi--file-pdf-box] w-5 h-5 mr-2 text-red-500"></span>
                            Seleccionar PDF
                        </label>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Arrastra el archivo aquí o haz clic para seleccionar
                    </p>
                    <p class="text-xs text-gray-500">PDF hasta 50MB</p>
                </div>
            </div>

            <!-- Nombre del archivo seleccionado -->
            @if($pdfFile && !$isProcessing)
                <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-center space-x-2">
                        <span class="icon-[mdi--file-pdf-box] w-4 h-4 text-red-500 flex-shrink-0"></span>
                        <p class="font-medium">{{ $pdfFile->getClientOriginalName() }}</p>
                    </div>
                    @if($extractedCi)
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="icon-[mdi--card-account-details] w-4 h-4 text-primary-500 flex-shrink-0"></span>
                            <p><strong>CI extraído:</strong> {{ $extractedCi }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Indicador de procesamiento -->
            @if($isProcessing)
                <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <svg class="animate-spin h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <div>
                            <p class="text-primary-700 dark:text-primary-300 font-medium text-sm">Procesando archivo...</p>
                            @if($extractedCi)
                                <p class="text-primary-600 dark:text-primary-400 text-xs">Consultando CI: {{ $extractedCi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Indicador de carga para subida de archivo -->
            <div wire:loading wire:target="pdfFile" class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-3">
                <div class="flex items-center space-x-3">
                    <svg class="animate-spin h-4 w-4 text-primary-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-primary-700 dark:text-primary-300 text-sm font-medium">Subiendo archivo...</p>
                </div>
            </div>

            <!-- Mensaje de estado -->
            @if($uploadMessage)
                <div class="text-sm p-3 rounded-lg {{ str_contains($uploadMessage, '✅') ? 'bg-green-50 text-green-800 border border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800' : (str_contains($uploadMessage, '⚠️') ? 'bg-yellow-50 text-yellow-800 border border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800' : 'bg-red-50 text-red-800 border border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800') }}">
                    {!! $uploadMessage !!}
                </div>
            @endif

            <!-- Errores de validación -->
            @error('pdfFile')
                <div class="text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 rounded-lg">
                    {{ $message }}
                </div>
            @enderror

            <!-- Botón para limpiar -->
            @if($pdfFile && !$isProcessing)
                <button 
                    wire:click="clearUpload" 
                    class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline transition-colors"
                >
                    Limpiar y seleccionar otro archivo
                </button>
            @endif
        </div>
    </div>

    <!-- Instrucciones mejoradas -->
    <div class="text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
        <p class="flex items-center space-x-1 font-medium">
            <span class="icon-[mdi--lightbulb-on] w-4 h-4 text-yellow-500"></span>
            <span>Formato requerido:</span>
        </p>
        <div class="mt-2 space-y-1">
            <p class="flex items-center space-x-1">
                <span class="icon-[mdi--check-circle] w-3 h-3 text-green-500"></span>
                <span>Nombre: <code>[CI]-[nombre].pdf</code></span>
            </p>
            <p class="flex items-center space-x-1">
                <span class="icon-[mdi--check-circle] w-3 h-3 text-green-500"></span>
                <span>Ejemplo: <code>8631891-Juan-Perez.pdf</code></span>
            </p>
            <p class="flex items-center space-x-1">
                <span class="icon-[mdi--check-circle] w-3 h-3 text-green-500"></span>
                <span>Máximo 50MB</span>
            </p>
        </div>
    </div>
</div>
