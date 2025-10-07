<?php

namespace App\Models;

use App\Models\Especialidad\Especialidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Universidad extends Model
{
    protected $table = 'universidades';

    protected $fillable = [
        'nombre',
        'sigla',
    ];

    public function especialidades(): HasMany
    {
        return $this->hasMany(Especialidad::class);
    }
}
