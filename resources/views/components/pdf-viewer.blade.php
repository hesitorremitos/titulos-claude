@props([
    'height' => '400px',
    'maxFileSize' => 50, // MB
    'showProgress' => true,
    'showFileList' => true,
    'id' => 'pdf-viewer-' . uniqid()
])

<div x-data="pdfViewer('{{ $id }}', {{ $maxFileSize }})" class="w-full">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upload Section -->
        <div>
            <!-- Drop Zone -->
            <div 
                @dragover.prevent="isDragOver = true"
                @dragleave.prevent="isDragOver = false"
                @drop.prevent="handleDrop($event)"
                @click="openFileDialog()"
                :class="{
                    'border-primary-500 bg-primary-50 dark:bg-primary-900/20': isDragOver,
                    'border-gray-300 dark:border-gray-600': !isDragOver
                }"
                class="relative border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-all duration-200 hover:border-primary-400 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                
                <div class="space-y-3">
                    <div class="flex justify-center">
                        <span class="icon-[mdi--file-pdf-box] w-12 h-12 text-primary-500"></span>
                    </div>
                    
                    <div>
                        <p class="text-base font-medium text-gray-900 dark:text-white">
                            Arrastra tu archivo PDF aquí
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            o <span class="text-primary-600 dark:text-primary-400 font-medium">haz clic para seleccionar</span>
                        </p>
                    </div>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Archivos PDF de hasta {{ $maxFileSize }}MB
                    </p>
                </div>
                
                <!-- Overlay when dragging -->
                <div x-show="isDragOver" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="absolute inset-0 bg-primary-500/10 rounded-lg flex items-center justify-center">
                    <p class="text-primary-700 dark:text-primary-300 font-medium">
                        Suelta el archivo aquí
                    </p>
                </div>
            </div>
            
            <!-- Hidden File Input -->
            <input x-ref="fileInput"
                type="file"
                accept=".pdf"
                @change="handleFileSelect($event)"
                class="hidden">
            
            <!-- Upload Progress -->
            @if($showProgress)
            <div x-show="isUploading" x-transition class="mt-4">
                <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-primary-600 h-2 rounded-full transition-all duration-300 ease-out"
                        :style="`width: ${uploadProgress}%`"></div>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 text-center">
                    Procesando... <span x-text="Math.round(uploadProgress)"></span>%
                </p>
            </div>
            @endif
            
            <!-- File List -->
            @if($showFileList)
            <div x-show="files.length > 0" x-transition class="mt-4 space-y-2">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Archivo:</h4>
                
                <template x-for="(file, index) in files" :key="index">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center space-x-3">
                            <span class="icon-[mdi--file-pdf-box] w-6 h-6 text-red-500"></span>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="file.name"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatFileSize(file.size)"></p>
                            </div>
                        </div>
                        
                        <button @click="removeFile(index)"
                            class="text-gray-400 hover:text-red-500 transition-colors p-1">
                            <span class="icon-[mdi--close] w-4 h-4"></span>
                        </button>
                    </div>
                </template>
            </div>
            @endif
        </div>
        
        <!-- PDF Viewer Section -->
        <div>
            <!-- PDF Container -->
            <div x-show="pdfLoaded" x-transition class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Vista Previa</h4>
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        Viewer nativo
                    </div>
                </div>
                
                <!-- PDF Embedded Container -->
                <div :id="containerId" 
                    class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-white"
                    style="height: {{ $height }};">
                </div>
            </div>
            
            <!-- Empty State -->
            <div x-show="!pdfLoaded" class="flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700"
                 style="height: {{ $height }};">
                <div class="text-center">
                    <span class="icon-[mdi--file-document-outline] w-8 h-8 text-gray-400 mx-auto mb-2"></span>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sube un PDF para visualizar</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function pdfViewer(containerId, maxFileSize) {
    return {
        isDragOver: false,
        files: [],
        isUploading: false,
        uploadProgress: 0,
        pdfLoaded: false,
        containerId: containerId,
        maxFileSizeMB: maxFileSize,
        
        async handleDrop(e) {
            this.isDragOver = false;
            const droppedFiles = Array.from(e.dataTransfer.files);
            this.processFiles(droppedFiles);
        },
        
        async handleFileSelect(e) {
            const selectedFiles = Array.from(e.target.files);
            this.processFiles(selectedFiles);
        },
        
        processFiles(fileList) {
            const validFiles = fileList.filter(file => {
                const isValidType = file.type === 'application/pdf';
                const isValidSize = file.size <= this.maxFileSizeMB * 1024 * 1024;
                
                if (!isValidType) {
                    this.showToast('error', 'Solo se permiten archivos PDF');
                    return false;
                }
                
                if (!isValidSize) {
                    this.showToast('error', `El archivo no debe superar ${this.maxFileSizeMB}MB`);
                    return false;
                }
                
                return true;
            });
            
            if (validFiles.length > 0) {
                this.files = validFiles;
                this.loadPdfEmbed(validFiles[0]);
                this.simulateUpload();
            }
        },
        
        loadPdfEmbed(file) {
            try {
                const fileURL = URL.createObjectURL(file);
                const container = document.getElementById(this.containerId);
                
                if (!container) {
                    this.showToast('error', 'Contenedor no encontrado');
                    return;
                }
                
                container.innerHTML = '';
                
                const iframe = document.createElement('iframe');
                iframe.src = fileURL;
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.border = 'none';
                iframe.title = 'Visor PDF';
                
                iframe.onload = () => {
                    this.pdfLoaded = true;
                    this.showToast('success', 'PDF cargado correctamente');
                };
                
                iframe.onerror = () => {
                    this.showToast('error', 'Error al cargar el PDF');
                };
                
                container.appendChild(iframe);
                
            } catch (error) {
                console.error('Error loading PDF:', error);
                this.showToast('error', 'Error al procesar el archivo PDF');
            }
        },
        
        simulateUpload() {
            this.isUploading = true;
            this.uploadProgress = 0;
            
            const interval = setInterval(() => {
                this.uploadProgress += Math.random() * 40;
                
                if (this.uploadProgress >= 100) {
                    this.uploadProgress = 100;
                    this.isUploading = false;
                    clearInterval(interval);
                }
            }, 100);
        },
        
        removeFile(index) {
            this.files.splice(index, 1);
            this.uploadProgress = 0;
            this.isUploading = false;
            this.pdfLoaded = false;
            
            const container = document.getElementById(this.containerId);
            if (container) {
                const iframe = container.querySelector('iframe');
                if (iframe && iframe.src) {
                    URL.revokeObjectURL(iframe.src);
                }
                container.innerHTML = '';
            }
        },
        
        openFileDialog() {
            this.$refs.fileInput.click();
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        
        showToast(type, message) {
            window.dispatchEvent(new CustomEvent('toast:' + type, {
                detail: { message: message }
            }));
        }
    }
}
</script>