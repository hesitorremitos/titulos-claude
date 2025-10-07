<?php

namespace App\Models\Diplomado;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diplomado extends Model
{
    protected $table = 'diplomados';

    protected $fillable = [
        'ci',
        'nro_tpn',
        'mencion_tpn_id',
        'sexo',
        'nro_documento',
        'fojas',
        'libro',
        'fecha_emision',
        'mencion_diplomado_id',
        'gestion',
        'version',
        'modalidad_diplomado_id',
        'horas_creditos',
        'trabajo_final',
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
        'horas_creditos' => 'integer',
        'trabajo_final' => 'boolean',
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
        return $this->belongsTo(Mencion::class, 'mencion_diplomado_id');
    }

    public function mencionTpn(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TitulosProvisionNacional\Mencion::class, 'mencion_tpn_id');
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_diplomado_id');
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
