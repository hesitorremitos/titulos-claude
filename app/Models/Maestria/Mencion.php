<?php

namespace App\Models\Maestria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    protected $table = 'menciones_maestria';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function maestrias(): HasMany
    {
        return $this->hasMany(Maestria::class, 'mencion_maestria_id');
    }
}
