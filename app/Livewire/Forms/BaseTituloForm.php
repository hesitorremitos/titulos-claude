<?php

namespace App\Livewire\Forms;

use App\Models\GraduacionDa;
use Illuminate\Validation\Rules\File;
use Livewire\Form;

abstract class BaseTituloForm extends Form
{
    // Campos comunes a todos los títulos
    public int $nro_documento = 0;

    public int $fojas = 0;

    public int $libro = 0;

    public string $fecha_emision = '';

    public ?int $graduacion_id = null;

    public string $observaciones = '';

    // Campos para manejo de archivos
    public $pdfFile = null;

    public ?string $tempFilePath = null;

    public ?string $originalFileName = null;

    // Cache para opciones
    public array $graduaciones = [];

    protected function commonRules(): array
    {
        return [
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'graduacion_id' => 'required|exists:graduacion_da,id',
            'observaciones' => 'nullable|string|max:500',
            'pdfFile' => ['nullable', File::types(['pdf'])->max(50 * 1024)], // 50MB
        ];
    }

    protected function commonMessages(): array
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
            'graduacion_id.required' => 'La modalidad de graduación es obligatoria',
            'graduacion_id.exists' => 'La modalidad de graduación seleccionada no existe',
            'observaciones.max' => 'Las observaciones no pueden exceder los 500 caracteres',
            'pdfFile.max' => 'El archivo PDF no debe superar los 50MB',
            'pdfFile.mimes' => 'Solo se permiten archivos PDF',
        ];
    }

    public function loadGraduaciones(): void
    {
        $this->graduaciones = GraduacionDa::orderBy('medio_graduacion')
            ->get(['id', 'medio_graduacion'])
            ->toArray();
    }

    protected function getCommonData(string $ci, int $userId): array
    {
        return [
            'ci' => $ci,
            'nro_documento' => $this->nro_documento,
            'fojas' => $this->fojas,
            'libro' => $this->libro,
            'fecha_emision' => $this->fecha_emision ?: null,
            'graduacion_id' => $this->graduacion_id,
            'observaciones' => $this->observaciones,
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }

    protected function handleFileStorage(string $ci, string $folderName): ?string
    {
        if ($this->pdfFile) {
            $filename = $folderName.'_'.$ci.'_'.time().'.pdf';
            $path = $this->pdfFile->storeAs('diplomas/'.$folderName, $filename, 'public');

            return $path;
        } elseif ($this->tempFilePath) {
            // Mover archivo temporal al directorio final
            $filename = $folderName.'_'.$ci.'_'.time().'.pdf';
            $finalPath = 'diplomas/'.$folderName.'/'.$filename;

            \Storage::disk('public')->move($this->tempFilePath, $finalPath);

            return $finalPath;
        }

        return null;
    }

    public function reset(...$properties): void
    {
        $this->nro_documento = 0;
        $this->fojas = 0;
        $this->libro = 0;
        $this->fecha_emision = '';
        $this->graduacion_id = null;
        $this->observaciones = '';
        $this->pdfFile = null;
        $this->tempFilePath = null;
        $this->originalFileName = null;

        // Permitir reset de campos específicos
        $this->resetSpecificFields();
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract protected function rules(): array;

    abstract protected function messages(): array;

    abstract public function checkDuplicates(string $ci): bool;

    abstract public function store(string $ci, int $userId);

    abstract protected function resetSpecificFields(): void;
}
