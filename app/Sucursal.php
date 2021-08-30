<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $fillable = [
        'id','nombre','direccion','ciudad','comuna','telefono',
    ];
}
