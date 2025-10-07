<?php

namespace App\Models\TitulosProvisionNacional;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Importar clase del mismo namespace
use App\Models\TitulosProvisionNacional\TituloProvisionNacional;

class Modalidad extends Model
{
    protected $table = 'modalidades_tpn';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
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
        return $this->hasMany(TituloProvisionNacional::class, 'modalidad_tpn_id');
    }

    public function titulos(): HasMany
    {
        return $this->hasMany(TituloProvisionNacional::class, 'modalidad_tpn_id');
    }
}