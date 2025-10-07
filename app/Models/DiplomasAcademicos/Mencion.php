<?php

namespace App\Models\DiplomasAcademicos;

use App\Models\Carrera;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Importar clase del mismo namespace
use App\Models\DiplomasAcademicos\DiplomaAcademico;

class Mencion extends Model
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
