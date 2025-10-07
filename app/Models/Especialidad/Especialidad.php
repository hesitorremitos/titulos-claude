<?php

namespace App\Models\Especialidad;

use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Models\Universidad;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Especialidad extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'ci',
        'nro_tpn',
        'mencion_tpn_id',
        'sexo',
        'nro_documento',
        'fojas',
        'libro',
        'fecha_emision',
        'mencion_especialidad_id',
        'gestion',
        'version',
        'modalidad_especialidad_id',
        'horas_academicas',
        'promedio_final',
        'universidad_id',
        'file_dir',
        'verificado',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'verificado' => 'boolean',
        'gestion' => 'integer',
        'version' => 'integer',
        'promedio_final' => 'boolean',
        'fojas' => 'integer',
        'libro' => 'integer',
        'nro_documento' => 'integer',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'ci', 'ci');
    }

    public function mencion(): BelongsTo
    {
        return $this->belongsTo(Mencion::class, 'mencion_especialidad_id');
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_especialidad_id');
    }

    public function mencionTpn(): BelongsTo
    {
        return $this->belongsTo(MencionTpn::class, 'mencion_tpn_id');
    }

    public function universidad(): BelongsTo
    {
        return $this->belongsTo(Universidad::class, 'universidad_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected function estado(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file_dir ? 'Digitalizado' : 'Pendiente de digitalización'
        );
    }
}
