<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GraduacionDa extends Model
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

    public function diplomaAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_id');
    }

    public function diplomas(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_id');
    }
}
