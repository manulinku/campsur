<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Palet extends Model
{
    protected $table = 'PALETS';
    protected $primaryKey = 'CODIGO';
    public $timestamps = false;
}
