<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre','precio_venta','precio_venta_neto','codigo','id_familia','imagen','exento','favorito','descripcion'
    ];
}
