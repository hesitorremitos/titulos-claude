<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class DiplomaAcademico extends Model
{
    protected $table = 'diploma_academicos';

    protected $fillable = [
        'ci',
        'nro_documento',
        'fojas',
        'libro',
        'fecha_emision',
        'mencion_da_id',
        'observaciones',
        'graduacion_id',
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
        return $this->belongsTo(MencionDa::class, 'mencion_da_id');
    }

    public function graduacion(): BelongsTo
    {
        return $this->belongsTo(GraduacionDa::class, 'graduacion_id');
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
