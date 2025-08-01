<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GraduacionDa extends Model
{
    protected $table = 'graduacion_da';

    protected $fillable = [
        'medio_graduacion'
    ];

    public function diplomasAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'graduacion_id');
    }
}
