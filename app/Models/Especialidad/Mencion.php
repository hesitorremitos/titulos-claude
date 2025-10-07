<?php

namespace App\Models\Especialidad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    protected $table = 'menciones_especialidad';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function especialidades(): HasMany
    {
        return $this->hasMany(Especialidad::class, 'mencion_especialidad_id');
    }
}
