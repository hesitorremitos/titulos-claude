<?php

namespace App\Models\DiplomasAcademicos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Importar clase del mismo namespace
use App\Models\DiplomasAcademicos\DiplomaAcademico;

class Modalidad extends Model
{
    protected $table = 'graduacion_da';

    protected $fillable = [
        'nombre',
        'medio_graduacion',
    ];

    protected $casts = [
        'medio_graduacion' => 'string',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function diplomasAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_id');
    }

    public function diplomas(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_id');
    }
}
