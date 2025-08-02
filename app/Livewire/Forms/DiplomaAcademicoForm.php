<?php

namespace App\Livewire\Forms;

use App\Models\DiplomaAcademico;
use App\Models\GraduacionDa;
use App\Models\MencionDa;
use Illuminate\Validation\Rules\File;
use Livewire\Form;

class DiplomaAcademicoForm extends Form
{
    public int $nro_documento = 0;

    public int $fojas = 0;

    public int $libro = 0;

    public string $fecha_emision = '';

    public ?int $mencion_da_id = null;

    public ?int $graduacion_id = null;

    public string $observaciones = '';

    public $pdfFile = null;

    // Campos para manejo de archivo desde PDF upload
    public ?string $tempFilePath = null;
    public ?string $originalFileName = null;

    // Campos de cache para opciones
    public array $menciones = [];

    public array $graduaciones = [];

    protected function rules(): array
    {
        return [
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'mencion_da_id' => 'required|exists:menciones_da,id',
            'graduacion_id' => 'required|exists:graduacion_da,id',
            'observaciones' => 'nullable|string|max:500',
            'pdfFile' => ['nullable', File::types(['pdf'])->max(50 * 1024)], // 50MB
        ];
    }

    protected function messages(): array
    {
        return [
            'nro_documento.required' => 'El número de documento es obligatorio',
            'nro_documento.min' => 'El número de documento debe ser mayor a 0',
            'fojas.required' => 'Las fojas son obligatorias',
            'fojas.min' => 'Las fojas deben ser mayor a 0',
            'libro.required' => 'El libro es obligatorio',
            'libro.min' => 'El libro debe ser mayor a 0',
            'fecha_emision.date' => 'La fecha de emisión debe ser una fecha válida',
            'fecha_emision.before_or_equal' => 'La fecha de emisión no puede ser posterior a hoy',
            'mencion_da_id.required' => 'La mención es obligatoria',
            'mencion_da_id.exists' => 'La mención seleccionada no existe',
            'graduacion_id.required' => 'La modalidad de graduación es obligatoria',
            'graduacion_id.exists' => 'La modalidad de graduación seleccionada no existe',
            'observaciones.max' => 'Las observaciones no pueden exceder los 500 caracteres',
            'pdfFile.max' => 'El archivo PDF no debe superar los 50MB',
            'pdfFile.mimes' => 'Solo se permiten archivos PDF',
        ];
    }

    public function loadMenciones(?string $carreraId = null): void
    {
        if ($carreraId) {
            $this->menciones = MencionDa::where('carrera_id', $carreraId)
                ->orderBy('nombre')
                ->get(['id', 'nombre'])
                ->toArray();
        } else {
            $this->menciones = [];
        }

        // Reset mención seleccionada cuando cambia la carrera
        $this->mencion_da_id = null;
    }

    public function loadGraduaciones(): void
    {
        $this->graduaciones = GraduacionDa::orderBy('medio_graduacion')
            ->get(['id', 'medio_graduacion'])
            ->toArray();
    }

    public function checkDuplicates(string $ci): bool
    {
        $exists = DiplomaAcademico::where(function ($query) {
            $query->where('nro_documento', $this->nro_documento)
                ->where('fojas', $this->fojas)
                ->where('libro', $this->libro);
        })->orWhere(function ($query) use ($ci) {
            $query->where('ci', $ci)
                ->where('mencion_da_id', $this->mencion_da_id);
        })->exists();

        return $exists;
    }

    public function store(string $ci, int $userId): DiplomaAcademico
    {
        $this->validate();

        // Verificar duplicados
        if ($this->checkDuplicates($ci)) {
            throw new \Exception('Ya existe un diploma con estos datos de identificación o para esta persona y mención.');
        }

        $diplomaData = [
            'ci' => $ci,
            'nro_documento' => $this->nro_documento,
            'fojas' => $this->fojas,
            'libro' => $this->libro,
            'fecha_emision' => $this->fecha_emision ?: null,
            'mencion_da_id' => $this->mencion_da_id,
            'graduacion_id' => $this->graduacion_id,
            'observaciones' => $this->observaciones,
            'created_by' => $userId,
            'updated_by' => $userId,
        ];

        // Manejar archivo PDF
        if ($this->pdfFile) {
            $filename = 'diploma_'.$ci.'_'.time().'.pdf';
            $path = $this->pdfFile->storeAs('diplomas/academicos', $filename, 'public');
            $diplomaData['file_dir'] = $path;
        } elseif ($this->tempFilePath) {
            // Mover archivo temporal al directorio final
            $filename = 'diploma_'.$ci.'_'.time().'.pdf';
            $finalPath = 'diplomas/academicos/'.$filename;
            
            \Storage::disk('public')->move($this->tempFilePath, $finalPath);
            $diplomaData['file_dir'] = $finalPath;
        }

        return DiplomaAcademico::create($diplomaData);
    }

    public function reset(...$properties): void
    {
        $this->nro_documento = 0;
        $this->fojas = 0;
        $this->libro = 0;
        $this->fecha_emision = '';
        $this->mencion_da_id = null;
        $this->graduacion_id = null;
        $this->observaciones = '';
        $this->pdfFile = null;
        $this->tempFilePath = null;
        $this->originalFileName = null;
    }
}
