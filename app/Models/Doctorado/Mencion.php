<?php

namespace App\Models\Doctorado;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    protected $table = 'menciones_doctorado';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function doctorados(): HasMany
    {
        return $this->hasMany(Doctorado::class, 'mencion_doctorado_id');
    }
}
