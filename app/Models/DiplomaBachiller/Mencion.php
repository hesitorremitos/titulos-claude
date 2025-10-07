<?php

namespace App\Models\DiplomaBachiller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mencion extends Model
{
    protected $table = 'menciones_db';

    protected $fillable = [
        'nombre',
    ];

    public function diplomas(): HasMany
    {
        return $this->hasMany(DiplomaBachiller::class, 'mencion_db_id');
    }
}
