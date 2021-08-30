<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $fillable = [
         'id_bodega', 'id_producto',  'stock',
    ];
}
