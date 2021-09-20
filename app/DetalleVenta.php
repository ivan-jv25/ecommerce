<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $fillable = [ 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento', ];
}
