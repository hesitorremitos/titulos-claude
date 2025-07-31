<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    use HasFactory;

    protected $table = 'facultades';

    protected $fillable = [
        'nombre',
        'direccion',
    ];

    /**
     * Relación con carreras
     */
    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'facultad_id');
    }

    /**
     * Scope para búsqueda
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('direccion', 'like', '%' . $search . '%');
    }

    /**
     * Obtener cantidad de carreras
     */
    public function getCarrerasCountAttribute()
    {
        return $this->carreras()->count();
    }
}
