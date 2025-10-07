<?php

namespace App\Models\Diplomado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalidad extends Model
{
    protected $table = 'modalidades_diplomado';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function diplomados(): HasMany
    {
        return $this->hasMany(Diplomado::class, 'modalidad_diplomado_id');
    }
}
