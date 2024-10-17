<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinEnvProv extends Model
{
    protected $table = 'LIN_ENV_PROV';
    public $timestamps = false;

    // Relación con AlbaranProv (muchas líneas pertenecen a un albarán)
    public function albaran()
    {
        return $this->belongsTo(Albaran::class, 'NUMERO', 'NUMERO');
    }

    // Relación con Envases
    public function envase()
    {
        return $this->belongsTo(Envase::class, 'COD_ENV', 'CODIGO');
    }

    // Relación con Palets
    public function palet()
    {
        return $this->belongsTo(Palet::class, 'COD_PAL', 'CODIGO');
    }
}
