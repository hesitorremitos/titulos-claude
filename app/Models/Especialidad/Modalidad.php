<?php

namespace App\Models\Especialidad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalidad extends Model
{
    protected $table = 'modalidades_especialidad';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function especialidades(): HasMany
    {
        return $this->hasMany(Especialidad::class, 'modalidad_especialidad_id');
    }
}
