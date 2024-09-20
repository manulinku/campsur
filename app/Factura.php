<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'FACTURA_PROV'; // Nombre de la tabla

    public $timestamps = false;

    // Puedes definir una relación con Albaran si es necesario
    public function albaranes()
    {
        return $this->hasMany(Albaran::class, 'NUMERO', 'NUMFAC'); // Relación inversa si se necesita
    }

    public function proveedor()
    {
        return $this->belongsTo(User::class, 'COD_PROV', 'CODIGO');
    }
}
