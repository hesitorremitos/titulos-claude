<?php

namespace App\Models\Diplomado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    protected $table = 'menciones_diplomado';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function diplomados(): HasMany
    {
        return $this->hasMany(Diplomado::class, 'mencion_diplomado_id');
    }
}
