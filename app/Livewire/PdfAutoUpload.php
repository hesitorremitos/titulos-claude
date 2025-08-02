<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DiplomaAcademico;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfAutoUpload extends Component
{
    use WithFileUploads;

    public $pdfFile;
    public $uploadMessage = '';
    public $foundDiploma = null;
    public $searchPerformed = false;

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
            // Extraer CI del nombre del archivo
            $fileName = $this->pdfFile->getClientOriginalName();
            $ci = $this->extractCiFromFileName($fileName);

            if (!$ci) {
                $this->uploadMessage = "❌ No se pudo extraer el CI del nombre del archivo. Formato esperado: [CI]-[nombre].pdf";
                return;
            }

            // Buscar diploma por CI
            $diploma = DiplomaAcademico::whereHas('persona', function($query) use ($ci) {
                $query->where('ci', $ci);
            })->with('persona', 'mencion.carrera.facultad')->first();

            if (!$diploma) {
                $this->uploadMessage = "❌ No se encontró ningún diploma académico registrado para el CI: {$ci}";
                $this->foundDiploma = null;
                $this->searchPerformed = true;
                return;
            }

            // Verificar permisos de edición
            if (!$this->canEditDiploma($diploma)) {
                $this->uploadMessage = "❌ No tienes permisos para actualizar este diploma.";
                return;
            }

            // Subir archivo
            $filePath = $this->uploadPdfFile($ci, $fileName);
            
            // Actualizar diploma con la ruta del archivo
            $diploma->update([
                'file_dir' => $filePath,
                'updated_by' => auth()->id(),
            ]);

            $this->foundDiploma = $diploma;
            $this->searchPerformed = true;
            $this->uploadMessage = "✅ PDF subido exitosamente y asociado al diploma de {$diploma->persona->nombre_completo}";
            
            // Limpiar el archivo después de procesar
            $this->reset('pdfFile');
            
            // Emitir evento para refrescar la lista si es necesario
            $this->dispatch('diploma-updated');

        } catch (\Exception $e) {
            $this->uploadMessage = "❌ Error al procesar el archivo: " . $e->getMessage();
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

    private function canEditDiploma($diploma)
    {
        $user = auth()->user();
        
        // Administrador puede editar cualquier diploma
        if ($user->hasRole('Administrador')) {
            return true;
        }
        
        // Personal solo puede editar diplomas que registró
        if ($user->hasRole('Personal') && $diploma->created_by === $user->id) {
            return true;
        }
        
        return false;
    }

    private function uploadPdfFile($ci, $originalFileName)
    {
        // Crear nombre único para el archivo
        $extension = $this->pdfFile->getClientOriginalExtension();
        $fileName = $ci . '_diploma_academico_' . time() . '.' . $extension;
        
        // Subir a storage/app/public/diplomas/academicos/
        $filePath = $this->pdfFile->storeAs('diplomas/academicos', $fileName, 'public');
        
        return $filePath;
    }

    public function clearSearch()
    {
        $this->reset(['foundDiploma', 'searchPerformed', 'uploadMessage']);
    }

    public function render()
    {
        return view('livewire.pdf-auto-upload');
    }
}