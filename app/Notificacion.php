<?php

// app/Notificacion.php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'NOTIFICACIONES_PROVEEDORES'; // Nombre de la tabla
    protected $fillable = ['titulo', 'mensaje', 'user_id', 'visto'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'CODIGO');
    }
}

