<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'rut', 'folio', 'id_direccion', 'tipo_entrega', 'descuento', 'neto', 'neto_exento', 'iva', 'total_venta', 'tipo_documento', 'forma_pago', 'id_bodega', 'estado_pago', 'id_formapago', 'codigo_pago', 
    ];
}
