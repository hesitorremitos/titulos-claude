<?php

namespace App\Models\Doctorado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalidad extends Model
{
    protected $table = 'modalidades_doctorado';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function doctorados(): HasMany
    {
        return $this->hasMany(Doctorado::class, 'modalidad_doctorado_id');
    }
}
