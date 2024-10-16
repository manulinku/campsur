<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    // Especifica el nombre de la tabla en la base de datos
    protected $table = 'PROVEEDORES';

    // Si la columna `CODIGO` es la clave primaria, especifica esto
    protected $primaryKey = 'CODIGO';

    // Laravel por defecto espera que las claves primarias sean auto-incrementales y de tipo entero.
    // Si `CODIGO` no es auto-incremental, puedes especificarlo:
    // public $incrementing = false;
    
    // Si `CODIGO` no es de tipo entero, especifica su tipo
    // protected $keyType = 'string';

    // Si la tabla no tiene columnas `created_at` y `updated_at`, desactiva los timestamps
    public $timestamps = false;

    // Especifica las columnas que pueden ser masivamente asignadas
    protected $fillable = [
        'NOMBRE', 
        'PAIS', 
        'TIPOPROV',
        'PUNTOVENTA',  
        'COD_UN', 
        'CIF', 
        'COD_UN2',
        'KMTOTAL', 
        'KMFRONTERA', 
        'PRKMINT',
        'PASSWORD',
        'role'
    ];

    // Si utilizas `PASSWORD` para la autenticación, es posible que desees protegerlo
    protected $hidden = [
        'PASSWORD',
    ];

    // Especifica el tipo de columna `PASSWORD` para ser gestionada correctamente (por ejemplo, bcrypt)
    public function setPasswordAttribute($password)
    {
        $this->attributes['PASSWORD'] = bcrypt($password);
    }

    public function hasRole($role)
    {
        return $this->rol === $role;
    }

    public function albaranes()
    {
        return $this->hasMany(Albaran::class, 'COD_PROV', 'CODIGO');
    }

    public function previsiones()
    {
        return $this->hasMany(Prevision::class, 'COD_PROV', 'CODIGO');
    }

    // Resto del código del modelo...
}
