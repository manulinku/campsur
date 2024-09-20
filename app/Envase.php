<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envase extends Model
{
    protected $table = 'ENVASES'; // Nombre de la tabla

    public $timestamps = false;

    // Relación inversa con LinAlbProv
    public function lineas()
    {
        return $this->hasMany(LinAlbProv::class, 'CODIGO', 'COD_ENV'); // Relación inversa
    }
}
