<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GraduacionDa extends Model
{
    protected $table = 'graduacion_da';

    protected $fillable = [
        'nombre',
        'activo',
    ];
    
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function diplomaAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_da_id');
    }
}
