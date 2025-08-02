<div class="space-y-4">
    <!-- Área de subida de archivo con drag and drop -->
    <div 
        class="border-2 border-dashed border-green-300 dark:border-green-600 rounded-lg p-6 text-center bg-white dark:bg-gray-800 transition-all duration-200 hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/10"
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
        :class="{ 'border-green-500 bg-green-100 dark:bg-green-900/20 scale-105': dragOver }"
    >
        <div class="space-y-4">
            <!-- Input de archivo -->
            <div>
                <input 
                    type="file" 
                    wire:model.live="pdfFile" 
                    accept=".pdf"
                    class="hidden" 
                    id="pdfFormFileInput"
                >
                <label 
                    for="pdfFormFileInput" 
                    class="cursor-pointer inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Seleccionar PDF del Diploma
                </label>
                
                <!-- Icono drag and drop -->
                <div class="mt-4">
                    <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium text-green-600">Arrastra tu archivo PDF aquí</span>
                        <br>o haz clic en el botón superior
                    </p>
                    <p class="text-xs text-gray-500 mt-1">PDF hasta 50MB</p>
                </div>
            </div>

            <!-- Nombre del archivo seleccionado -->
            @if($pdfFile && !$isProcessing)
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <p><strong>Archivo:</strong> {{ $pdfFile->getClientOriginalName() }}</p>
                    @if($extractedCi)
                        <p><strong>CI extraído:</strong> {{ $extractedCi }}</p>
                    @endif
                </div>
            @endif

            <!-- Indicador de procesamiento -->
            @if($isProcessing)
                <div class="text-green-600 dark:text-green-400">
                    <svg class="animate-spin h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2 text-sm font-medium">Procesando archivo y consultando API...</p>
                    @if($extractedCi)
                        <p class="text-xs">Buscando datos para CI: {{ $extractedCi }}</p>
                    @endif
                </div>
            @endif

            <!-- Indicador de carga para subida de archivo -->
            <div wire:loading wire:target="pdfFile" class="text-green-600 dark:text-green-400">
                <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm">Subiendo archivo...</p>
            </div>

            <!-- Mensaje de estado -->
            @if($uploadMessage)
                <div class="text-sm p-3 rounded-md {{ str_contains($uploadMessage, '✅') ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : (str_contains($uploadMessage, '⚠️') ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                    {!! $uploadMessage !!}
                </div>
            @endif

            <!-- Errores de validación -->
            @error('pdfFile')
                <div class="text-sm text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900 p-3 rounded-md">
                    {{ $message }}
                </div>
            @enderror

            <!-- Botón para limpiar -->
            @if($pdfFile && !$isProcessing)
                <button 
                    wire:click="clearUpload" 
                    class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline"
                >
                    Limpiar y seleccionar otro archivo
                </button>
            @endif
        </div>
    </div>

    <!-- Instrucciones adicionales -->
    <div class="text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
        <p><strong>💡 Consejos:</strong></p>
        <ul class="mt-1 space-y-1 list-disc list-inside">
            <li>Asegúrate de que el archivo tenga el formato: <code>[CI]-[nombre].pdf</code></li>
            <li>Ejemplo: <code>8631891-Juan Perez Lopez.pdf</code></li>
            <li>El CI debe estar al inicio del nombre, seguido de un guión</li>
            <li>Máximo 50MB por archivo</li>
        </ul>
    </div>
</div>