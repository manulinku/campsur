<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    protected $table = 'COMUNICADOS';
    protected $fillable = ['titulo', 'contenido', 'fecha_publicacion'];
    public $timestamps = false;
}

