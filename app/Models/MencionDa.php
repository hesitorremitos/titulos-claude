<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MencionDa extends Model
{
    protected $table = 'menciones_da';

    protected $fillable = [
        'nombre',
        'carrera_id',
    ];

    protected $casts = [
        //
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id');
    }

    public function diplomasAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'mencion_da_id');
    }

    public function diplomas(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'mencion_da_id');
    }
}
