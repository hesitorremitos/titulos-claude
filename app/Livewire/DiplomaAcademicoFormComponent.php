<?php

namespace App\Livewire;

use App\Livewire\Forms\DiplomaAcademicoForm as DiplomaForm;

class DiplomaAcademicoFormComponent extends BaseTituloFormComponent
{
    public DiplomaForm $tituloForm;

    protected function handleCarreraSelection(string $carreraId): void
    {
        $this->tituloForm->loadMenciones($carreraId);
    }

    protected function resetTituloSpecificData(): void
    {
        $this->tituloForm->menciones = [];
    }

    protected function getSpecificListeners(): array
    {
        return [
            'pdf-file-selected' => 'handlePdfFileSelected',
            'pdf-file-removed' => 'handlePdfFileRemoved',
            'pdf-viewer-loaded' => 'handlePdfViewerLoaded'
        ];
    }

    public function handlePdfFileSelected($data)
    {
        // Update form with PDF file information if needed
        if (isset($data['file'])) {
            $this->tituloForm->pdfFile = $data['file'];
            $this->tituloForm->originalFileName = $data['fileName'];
            
            // Notify PDF viewer about manual upload in step 2
            $this->dispatch('form-file-uploaded', [
                'tempFilePath' => null, // Will use the actual file
                'fileName' => $data['fileName'],
                'file' => $data['file']
            ]);
        }
    }

    public function handlePdfFileRemoved()
    {
        // Clear PDF file from form
        $this->tituloForm->pdfFile = null;
        $this->tituloForm->originalFileName = null;
        $this->tituloForm->tempFilePath = null;
        
        // Notify PDF viewer to clear
        $this->dispatch('pdf-file-removed');
    }

    public function handlePdfViewerLoaded($data)
    {
        // PDF viewer has loaded a file, optionally show notification
        session()->flash('message', 'PDF cargado en el visor: ' . $data['fileName']);
    }



    // Handle manual PDF file upload in step 2
    public function updatedTituloFormPdfFile()
    {
        if ($this->tituloForm->pdfFile) {
            // Validate the file
            $this->validate([
                'tituloForm.pdfFile' => 'file|mimes:pdf|max:51200'
            ]);
            
            // Notify PDF viewer with the actual file
            $this->dispatch('pdf-file-selected', [
                'fileName' => $this->tituloForm->pdfFile->getClientOriginalName(),
                'fileSize' => $this->tituloForm->pdfFile->getSize(),
                'file' => $this->tituloForm->pdfFile
            ]);
        }
    }

    protected function getSuccessMessage(): string
    {
        return 'Diploma académico registrado exitosamente';
    }

    // Método de compatibilidad para el template existente
    public function saveDiploma()
    {
        $this->saveTitulo();
    }

    public function render()
    {
        return view('livewire.diploma-academico-form');
    }
}
