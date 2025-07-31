<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';
    
    // La clave primaria es un campo char de 5 caracteres
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'programa',
        'direccion',
        'facultad_id',
    ];

    /**
     * Relación con facultad
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'facultad_id');
    }

    /**
     * Scope para búsqueda
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('programa', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('direccion', 'like', '%' . $search . '%');
    }

    /**
     * Scope para filtrar por facultad
     */
    public function scopeByFacultad($query, $facultadId)
    {
        if ($facultadId) {
            return $query->where('facultad_id', $facultadId);
        }
        return $query;
    }
}
