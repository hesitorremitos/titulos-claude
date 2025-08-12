<?php

namespace App\Livewire;

use Livewire\Component;

class PdfViewerForm extends Component
{
    public $pdfUrl = null;

    public $fileName = '';

    public $fileSize = 0;

    public $isLoading = false;

    public $error = null;

    public $currentStep = 1;

    // Configuration
    public $height = '500px';

    protected $listeners = [
        'pdf-uploaded-with-success' => 'handlePdfUploadedWithSuccess',
        'pdf-uploaded-manual-entry' => 'handlePdfUploadedManualEntry',
        'step-changed' => 'handleStepChanged',
        'form-file-uploaded' => 'handleFormFileUploaded',
        'pdf-file-removed' => 'handlePdfFileRemoved',
        'pdf-file-selected' => 'handlePdfFileSelected',
    ];

    public function mount()
    {
        // Initialize with empty state
        $this->resetPdfState();
    }

    public function handlePdfUploadedWithSuccess($data)
    {
        $this->loadPdfFromTempPath($data['tempFilePath'], $data['originalFileName']);
        $this->dispatch('pdf-viewer-loaded', [
            'fileName' => $data['originalFileName'],
            'source' => 'auto-upload',
        ]);
    }

    public function handlePdfUploadedManualEntry($data)
    {
        $this->loadPdfFromTempPath($data['tempFilePath'], $data['originalFileName']);
        $this->dispatch('pdf-viewer-loaded', [
            'fileName' => $data['originalFileName'],
            'source' => 'manual-upload',
        ]);
    }

    public function handleFormFileUploaded($data)
    {
        try {
            $this->isLoading = true;
            $this->error = null;

            if (isset($data['file']) && $data['file']) {
                // Direct file object from manual upload in step 2
                $this->fileName = $data['fileName'];
                $this->fileSize = $data['file']->getSize();

                // Create base64 URL from the file
                $tempPath = $data['file']->getRealPath();
                $this->pdfUrl = 'data:application/pdf;base64,'.base64_encode(file_get_contents($tempPath));

                $this->dispatch('pdf-viewer-loaded', [
                    'fileName' => $data['fileName'],
                    'source' => 'manual-upload-step2',
                ]);

            } elseif (isset($data['tempFilePath']) && isset($data['fileName'])) {
                // Temp file path from step 1 upload
                $this->loadPdfFromTempPath($data['tempFilePath'], $data['fileName']);
                $this->dispatch('pdf-viewer-loaded', [
                    'fileName' => $data['fileName'],
                    'source' => 'form-upload',
                ]);
            }
        } catch (\Exception $e) {
            $this->error = 'Error al cargar el archivo PDF: '.$e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function handlePdfFileSelected($data)
    {
        try {
            $this->isLoading = true;
            $this->error = null;

            if (isset($data['file']) && $data['file']) {
                // Handle file object from manual upload in step 2
                $this->fileName = $data['fileName'];
                $this->fileSize = $data['fileSize'];

                // Create base64 URL from the file
                $tempPath = $data['file']->getRealPath();
                $this->pdfUrl = 'data:application/pdf;base64,'.base64_encode(file_get_contents($tempPath));

                $this->dispatch('pdf-viewer-loaded', [
                    'fileName' => $data['fileName'],
                    'source' => 'manual-upload-step2',
                ]);
            }
        } catch (\Exception $e) {
            $this->error = 'Error al cargar el archivo PDF: '.$e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function handlePdfFileRemoved()
    {
        $this->resetPdfState();
        $this->dispatch('pdf-viewer-cleared');
    }

    public function handleStepChanged($step)
    {
        $this->currentStep = $step;
    }

    public function loadPdfFromTempPath($tempPath, $originalFileName)
    {
        try {
            $this->isLoading = true;
            $this->error = null;

            $fullPath = storage_path('app/public/'.$tempPath);

            if (file_exists($fullPath)) {
                $this->fileName = $originalFileName;
                $this->fileSize = filesize($fullPath);
                $this->pdfUrl = 'data:application/pdf;base64,'.base64_encode(file_get_contents($fullPath));
            } else {
                $this->error = 'Archivo no encontrado en la ruta temporal.';
            }
        } catch (\Exception $e) {
            $this->error = 'Error al cargar el archivo PDF: '.$e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function removePdf()
    {
        $this->resetPdfState();
        $this->dispatch('pdf-file-removed');
    }

    private function resetPdfState()
    {
        $this->pdfUrl = null;
        $this->fileName = '';
        $this->fileSize = 0;
        $this->isLoading = false;
        $this->error = null;
    }

    public function render()
    {
        return view('livewire.pdf-viewer-form');
    }
}
