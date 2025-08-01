<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'ci';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ci',
        'nombres',
        'paterno',
        'materno',
        'fecha_nacimiento',
        'genero',
        'pais',
        'departamento',
        'provincia',
        'localidad'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date'
    ];

    public function diplomasAcademicos(): HasMany
    {
        return $this->hasMany(DiplomaAcademico::class, 'ci', 'ci');
    }

    public function getNombreCompletoAttribute(): string
    {
        $nombres = [$this->nombres, $this->paterno, $this->materno];
        return implode(' ', array_filter($nombres));
    }
}
