<?php

namespace App\Models\TitulosProvisionNacional;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Persona;
use App\Models\User;

class TituloProvisionNacional extends Model
{
    protected $table = 'titulo_provision_nacional';

    protected $fillable = [
        'ci',
        'nro_documento',
        'fojas',
        'libro',
        'fecha_emision',
        'observaciones',
        'mencion_tpn_id',
        'modalidad_tpn_id',
        'file_dir',
        'verificado',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'verificado' => 'boolean',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'ci', 'ci');
    }

    public function mencion(): BelongsTo
    {
        return $this->belongsTo(Mencion::class, 'mencion_tpn_id');
    }

    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_tpn_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getEstadoAttribute(): string
    {
        return $this->file_dir ? 'Digitalizado' : 'Pendiente de digitalización';
    }
}