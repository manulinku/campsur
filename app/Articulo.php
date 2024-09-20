<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'ARTICULOS'; // Nombre de la tabla

    public $timestamps = false;

    // Puedes definir una relación con LinAlbProv si es necesario
    public function lineas()
    {
        return $this->hasMany(LinAlbProv::class, 'CODIGO', 'COD_ART'); // Relación inversa
    }
}

