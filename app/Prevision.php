<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{

    // Define la tabla asociada
    protected $table = 'PREVISIONES';

    // Define la clave primaria
    protected $primaryKey = 'LINEA';

    // Si tu clave primaria no es autoincremental (si lo es, elimina esto):
    public $incrementing = false;

    // Si no estás usando timestamps (created_at, updated_at):
    public $timestamps = false;

    // Especificar los campos que se pueden llenar
    protected $fillable = ['FECHA', 'COD_PROV', 'COD_ART', 'CANTIDAD'];

    // Relación con el modelo de Articulos
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'COD_ART', 'CODIGO');
    }

    // Relación con el modelo de Proveedores (si lo tienes)
    public function proveedor()
    {
        return $this->belongsTo(User::class, 'COD_PROV', 'CODIGO');
    }
}
