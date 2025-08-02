<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\UniversityApiService;
use Illuminate\Support\Str;

class PdfAutoUploadForm extends Component
{
    use WithFileUploads;

    public $pdfFile;
    public $uploadMessage = '';
    public $extractedCi = null;
    public $isProcessing = false;

    protected $rules = [
        'pdfFile' => 'required|file|mimes:pdf|max:51200', // 50MB máximo
    ];

    protected $messages = [
        'pdfFile.required' => 'Debe seleccionar un archivo PDF.',
        'pdfFile.mimes' => 'El archivo debe ser un PDF.',
        'pdfFile.max' => 'El archivo no puede ser mayor a 50MB.',
    ];

    public function updatedPdfFile()
    {
        $this->validate();
        
        if ($this->pdfFile) {
            $this->processPdfUpload();
        }
    }

    public function processPdfUpload()
    {
        try {
            $this->isProcessing = true;
            
            // Extraer CI del nombre del archivo
            $fileName = $this->pdfFile->getClientOriginalName();
            $ci = $this->extractCiFromFileName($fileName);

            if (!$ci) {
                $this->uploadMessage = "❌ No se pudo extraer el CI del nombre del archivo. Formato esperado: [CI]-[nombre].pdf";
                $this->isProcessing = false;
                return;
            }

            $this->extractedCi = $ci;

            // Buscar automáticamente en la API
            $this->searchInApi($ci);

        } catch (\Exception $e) {
            $this->uploadMessage = "❌ Error al procesar el archivo: " . $e->getMessage();
            $this->isProcessing = false;
        }
    }

    private function searchInApi($ci)
    {
        try {
            // Guardar el archivo temporalmente para el paso 2
            $filePath = $this->pdfFile->store('temp/diplomas', 'public');
            
            // Disparar búsqueda automática en API
            $apiService = new UniversityApiService;
            $result = $apiService->searchPersonByCi($ci);

            if ($result['success']) {
                $this->uploadMessage = "✅ CI extraído: {$ci}. Datos encontrados en el sistema universitario.";
                
                // Emitir evento al componente padre con los datos
                $this->dispatch('pdf-uploaded-with-success', [
                    'ci' => $ci,
                    'apiData' => $result['data'],
                    'tempFilePath' => $filePath,
                    'originalFileName' => $this->pdfFile->getClientOriginalName()
                ]);
            } else {
                $this->uploadMessage = "⚠️ CI extraído: {$ci}. No se encontraron datos en el sistema universitario. Deberá completar los datos manualmente.";
                
                // Emitir evento con CI para registro manual
                $this->dispatch('pdf-uploaded-manual-entry', [
                    'ci' => $ci,
                    'tempFilePath' => $filePath,
                    'originalFileName' => $this->pdfFile->getClientOriginalName()
                ]);
            }

        } catch (\Exception $e) {
            $this->uploadMessage = "❌ Error al consultar la API: " . $e->getMessage();
        } finally {
            $this->isProcessing = false;
        }
    }

    private function extractCiFromFileName($fileName)
    {
        // Remover la extensión .pdf
        $nameWithoutExtension = Str::replaceLast('.pdf', '', $fileName);
        
        // Buscar patrón CI al inicio del nombre (números seguidos de guión)
        if (preg_match('/^(\d+)-/', $nameWithoutExtension, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    public function clearUpload()
    {
        $this->reset(['pdfFile', 'uploadMessage', 'extractedCi']);
    }

    public function render()
    {
        return view('livewire.pdf-auto-upload-form');
    }
}