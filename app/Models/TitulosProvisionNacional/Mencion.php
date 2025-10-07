<?php

namespace App\Models\TitulosProvisionNacional;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Importar clase del mismo namespace
use App\Models\TitulosProvisionNacional\TituloProvisionNacional;
use App\Models\Carrera;

class Mencion extends Model
{
    protected $table = 'menciones_tpn';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'carrera_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function titulosProvisionNacional(): HasMany
    {
        return $this->hasMany(TituloProvisionNacional::class, 'mencion_tpn_id');
    }

    public function titulos(): HasMany
    {
        return $this->hasMany(TituloProvisionNacional::class, 'mencion_tpn_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
}