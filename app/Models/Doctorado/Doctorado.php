<?php

namespace App\Models\Doctorado;

use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctorado extends Model
{
    protected $table = 'doctorados';

    protected $fillable = [
        'ci',
        'nro_tpn',
        'mencion_tpn_id',
        'nro_documento',
        'fojas',
        'libro',
        'fecha_emision',
        'mencion_doctorado_id',
        'gestion_inicial',
        'gestion_final',
        'version',
        'modalidad_doctorado_id',
        'horas_creditos',
        'file_dir',
        'verificado',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'verificado' => 'boolean',
        'gestion_inicial' => 'integer',
        'gestion_final' => 'integer',
        'version' => 'integer',
        'horas_creditos' => 'string',
        'fojas' => 'integer',
        'libro' => 'integer',
        'nro_documento' => 'integer',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'ci', 'ci');
    }

    public function mencionTpn(): BelongsTo
    {
        return $this->belongsTo(MencionTpn::class, 'mencion_tpn_id');
    }

    public function mencion(): BelongsTo
    {
        return $this->belongsTo(Mencion::class, 'mencion_doctorado_id');
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_doctorado_id');
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
