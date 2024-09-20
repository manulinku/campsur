<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinAlbProv extends Model
{
    protected $table = 'LIN_ALB_PROV'; // Nombre de la tabla en la base de datos

    public $timestamps = false;

    // Define la relación con el modelo Albaran
    public function albaran()
    {
        return $this->belongsTo(Albaran::class, 'NUMERO', 'NUMERO'); // Relaciona NUMERO de LinAlbProv con NUMERO de Albaran
    }

    // Relación con el modelo Articulo
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'COD_ART', 'CODIGO'); // Relación con ARTICULOS
    }

    // Relación con el modelo Envase
    public function envase()
    {
        return $this->belongsTo(Envase::class, 'COD_ENV', 'CODIGO'); // Relación con ENVASES
    }
}
