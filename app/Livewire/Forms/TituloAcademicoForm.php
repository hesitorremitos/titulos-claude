<?php

namespace App\Livewire\Forms;

use App\Models\TituloAcademico;

class TituloAcademicoForm extends BaseTituloForm
{
    // Campo específico de título académico
    public string $nro_diploma_academico = '';

    protected function rules(): array
    {
        return array_merge($this->commonRules(), [
            'nro_diploma_academico' => 'required|string|max:50',
        ]);
    }

    protected function messages(): array
    {
        return array_merge($this->commonMessages(), [
            'nro_diploma_academico.required' => 'El número de diploma académico es obligatorio',
            'nro_diploma_academico.max' => 'El número de diploma académico no puede exceder los 50 caracteres',
        ]);
    }

    public function checkDuplicates(string $ci): bool
    {
        $exists = TituloAcademico::where(function ($query) {
            $query->where('nro_documento', $this->nro_documento)
                ->where('fojas', $this->fojas)
                ->where('libro', $this->libro);
        })->orWhere(function ($query) use ($ci) {
            $query->where('ci', $ci)
                ->where('nro_diploma_academico', $this->nro_diploma_academico);
        })->exists();

        return $exists;
    }

    public function store(string $ci, int $userId): TituloAcademico
    {
        $this->validate();

        // Verificar duplicados
        if ($this->checkDuplicates($ci)) {
            throw new \Exception('Ya existe un título con estos datos de identificación o número de diploma académico para esta persona.');
        }

        $tituloData = array_merge($this->getCommonData($ci, $userId), [
            'nro_diploma_academico' => $this->nro_diploma_academico,
        ]);

        // Manejar archivo PDF
        $filePath = $this->handleFileStorage($ci, 'titulos');
        if ($filePath) {
            $tituloData['file_dir'] = $filePath;
        }

        return TituloAcademico::create($tituloData);
    }

    protected function resetSpecificFields(): void
    {
        $this->nro_diploma_academico = '';
    }
}
