<?php

namespace App\Models\Maestria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalidad extends Model
{
    protected $table = 'modalidades_maestria';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function maestrias(): HasMany
    {
        return $this->hasMany(Maestria::class, 'modalidad_maestria_id');
    }
}
