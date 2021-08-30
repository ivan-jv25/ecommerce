<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Venta;
use DB;
use Yajra\Datatables\Datatables;

class IndexController extends Controller
{
    public function registro_usuario(Request $request){
        dd($request);
    }

    public function obtener_token(Request $request){
        $existe_empresa = $this->existe_empresa();
        if (!$existe_empresa) {
            
            $rut_empresa = $request->rut_empresa;
            $username    = $request->username;
            $password    = $request->password;
            
            $login=(object)[
                'empresa'  => $rut_empresa,
                'username' => $username,
                'password' => $password,
            ];
            
            guardar_credenciales($login);
        }else{
            $login = json_decode(obtener_credenciales());
        }
        
        WEB_SERVICE_LOGIN($login);

        return [
            'Token' => obtener_token()
        ];
    }
    public function carga_data_guardada(){
        $token = '';
        $credenciales = null;
        try { $token = obtener_token(); } catch (\Throwable $th) {}
        try { $credenciales = json_decode(obtener_credenciales()); } catch (\Throwable $th) { }

        $productos_cargado = (existen_productos() > 0) ? true : false;
        $bodegas_cargado = (existen_bodegas() > 0) ? true : false;
        $bodegas_sucursal = (existen_sucursal() > 0) ? true : false;
        $bodegas_familia = (existen_familia() > 0) ? true : false;
        $bodegas_subfamilia = (existen_subfamilia() > 0) ? true : false;

        $respuesta = [
            'Token' => $token,
            'Credenciales' => $credenciales,
            'Carga' => [
                'Producto' => $productos_cargado,
                'Sucursal' => null
            ],
            'Carga' => [
                ['Tipo' => 'Producto', 'Estado' => $productos_cargado, 'id'=>'td_carga_producto'],
                ['Tipo' => 'Sucursal', 'Estado' => $bodegas_sucursal, 'id'=>'td_carga_sucursal'],
                ['Tipo' => 'Bodega', 'Estado' => $bodegas_cargado, 'id'=>'td_carga_bodega'],
                ['Tipo' => 'Inventario', 'Estado' => null, 'id'=>'td_carga_inventario'],
                ['Tipo' => 'Familia', 'Estado' => $bodegas_familia, 'id'=>'td_carga_familia'],
                ['Tipo' => 'SubFamilia', 'Estado' => $bodegas_subfamilia, 'id'=>'td_carga_subfamilia'],
                ['Tipo' => 'ListaPrecio', 'Estado' => null, 'id'=>'td_carga_lista_precio'],
                ['Tipo' => 'FormaPago', 'Estado' => null, 'id'=>'td_carga_formapago'],
            ],
        ];
        


        return $respuesta;
        
    }

    public function obtener_productos(){
        $respuesta = WEB_SERVICE_PRODUCTOS();
        return [ 'Estado'=>$respuesta];
    }

    public function obtener_bodega(){
        $respuesta = WEB_SERVICE_BODEGA();
        return [ 'Estado'=>$respuesta];
    }
    public function obtener_sucursal(){
        $respuesta = WEB_SERVICE_SUCURSAL();
        return [ 'Estado'=>$respuesta];
    }

    public function obtener_familia(){
        $respuesta = WEB_SERVICE_FAMILIA();
        return [ 'Estado'=>$respuesta];
    }

    public function obtener_subfamilia(){
        $respuesta = WEB_SERVICE_SUBFAMILIA();
        return [ 'Estado'=>$respuesta];
    }

    public function obtener_inventario(){
        $respuesta = WEB_SERVICE_INVENTARIO();
        return [ 'Estado'=>$respuesta];
    }

    public function lista_producto_normal(){
        $lista = DB::table('productos')->select('nombre','codigo','precio_venta','id_familia','imagen','exento')->where('favorito',0)->get();
        return $lista;
    }

    public function lista_producto_datatable(){

        $lista = DB::table('productos')->select('nombre','codigo','precio_venta','id_familia');

        return Datatables::of($lista)->make(true);
    }

    public function lista_bodega(){
        $bodegas = DB::table('bodegas')->select('id','nombre')->where('estado',1)->get();
        return $bodegas;
    }
    public function lista_inventario(Request $request){
        //$id_bodega = ($request->id_bodega == null) ? obtener_id_bodega_defecto() : $request->id_bodega;
        $bodegas = DB::table('inventarios')->select('id_producto','stock','id_bodega')->get();
        return $bodegas;
    }

    public function genera_venta(Request $request){
        
        $id_empresa = Auth::user()->id_empresa;
        $empresa = get_empresa($id_empresa);
        $dato = 0;
        
        $array_venta=[
            'rut'            => $empresa->rut,
            'folio'          => $dato,
            'id_direccion'   => $dato,
            'tipo_entrega'   => $request->tipo_entrega,
            'descuento'      => 0,
            'neto'           => $request->id_neto,
            'neto_exento'    => 0,
            'iva'            => $request->id_iva,
            'total_venta'    => $request->id_total,
            'tipo_documento' => $request->options,
            'forma_pago'     => $request->options_pago,
            'id_bodega'      => ( $request->id_bodega != null) ?  $request->id_bodega : obtener_id_bodega_defecto(),
            'estado_pago'    => $dato,
            'id_formapago'   => $dato,
            'codigo_pago'    => $dato,
        ];
        
        $venta = new Venta($array_venta);
        $venta->save();
        dd($venta);


    }

    public function ajax_ventas_totales(){
        
        $libro = DB::table('ventas')->select('id','rut','folio','id_direccion','tipo_entrega','descuento','neto','neto_exento','iva','total_venta','tipo_documento','forma_pago','id_bodega','estado_pago','id_formapago','codigo_pago','created_at','updated_at');

        return Datatables::of($libro)
        ->editColumn('created_at', function ($libro) { return substr($libro->created_at,0,10); })
        ->editColumn('neto', function ($libro) { return "$" . number_format($libro->neto, 0, ",", "."); })
        ->editColumn('neto_exento', function ($libro) { return "$" . number_format($libro->neto_exento, 0, ",", "."); })
        ->editColumn('descuento', function ($libro) { return "$" . number_format($libro->descuento, 0, ",", "."); })
        ->editColumn('iva', function ($libro) { return "$" . number_format($libro->iva, 0, ",", "."); })
        ->editColumn('total_venta', function ($libro) { return "$" . number_format($libro->total_venta, 0, ",", "."); })
        ->make(true);

    }


    public function ajax_ventas_cliente(){

        $id_empresa = Auth::user()->id_empresa;
        $empresa = get_empresa($id_empresa);
        
        $libro = DB::table('ventas')->select('id','rut','folio','id_direccion','tipo_entrega','descuento','neto','neto_exento','iva','total_venta','tipo_documento','forma_pago','id_bodega','estado_pago','id_formapago','codigo_pago','created_at','updated_at')->where('rut',$empresa->rut);

        return Datatables::of($libro)
        ->editColumn('created_at', function ($libro) { return substr($libro->created_at,0,10); })
        ->editColumn('neto', function ($libro) { return "$" . number_format($libro->neto, 0, ",", "."); })
        ->editColumn('neto_exento', function ($libro) { return "$" . number_format($libro->neto_exento, 0, ",", "."); })
        ->editColumn('descuento', function ($libro) { return "$" . number_format($libro->descuento, 0, ",", "."); })
        ->editColumn('iva', function ($libro) { return "$" . number_format($libro->iva, 0, ",", "."); })
        ->editColumn('total_venta', function ($libro) { return "$" . number_format($libro->total_venta, 0, ",", "."); })
        ->make(true);

    }

    private function existe_empresa(){
        return existe_credenciales();
    }
}
