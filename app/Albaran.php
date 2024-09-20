<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Albaran extends Model
{
    use HasRoles;
    
    // Especifica el nombre de la tabla en la base de datos
    protected $table = 'ALBARAN_PROV';

    // Si la columna `NUMERO` es la clave primaria, especifica esto
    protected $primaryKey = 'NUMERO';

    // Laravel por defecto espera que las claves primarias sean auto-incrementales y de tipo entero.
    // Si `NUMERO` no es auto-incremental, puedes especificarlo:
    public $incrementing = false;
    
    // Si `NUMERO` no es de tipo entero, especifica su tipo
    // protected $keyType = 'string';

    // Si la tabla no tiene columnas `created_at` y `updated_at`, desactiva los timestamps
    public $timestamps = false;

    public function lineas()
    {
        return $this->hasMany(LinAlbProv::class, 'NUMERO', 'NUMERO'); // Relaciona NUMERO de Albaran con NUMERO de LinAlbProv
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'NUMFAC', 'NUMERO'); // Relación con FACTURA_PROV
    }

    public function proveedor()
    {
        return $this->belongsTo(User::class, 'COD_PROV', 'CODIGO');
    }
}
