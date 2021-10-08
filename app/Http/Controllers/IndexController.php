<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Venta;
use App\DetalleVenta;
use App\Empresa;
use App\Producto;
use App\SubFamilia;
use App\Bodega;
use DB;
use PDF;
use Yajra\Datatables\Datatables;

class IndexController extends Controller
{
    public function index(Request $request){
        $token_venta = ($request->TokenVenta == null) ? 0 : $request->TokenVenta;
        $pagado = ($request->pago == null) ? 0 : $request->pago;

        return view('welcome')->with('TokenVenta',$token_venta)->with('pagado',$pagado);
    }
    public function registro_usuario(Request $request){
        

        $nombre = (string) $request->nombre;
        $correo = (string) $request->correo;
        $telefono = (string) $request->telefono;
        $password = (string) $request->password;

        $rut_empresa = (string) $request->rut_empresa;
        $razon_social = (string) $request->razon_social;
        $giro = (string) $request->giro;
        $direccion = (string) $request->direccion;
        $comuna = (string) $request->comuna;
        $ciudad = (string) $request->ciudad;

        $empresa = new Empresa();
        
        $empresa->rut          = $rut_empresa;
        $empresa->razon_social = $razon_social;
        $empresa->giro         = $giro;
        $empresa->direccion    = $direccion;
        $empresa->comuna       = $comuna;
        $empresa->ciudad       = $ciudad;
        $empresa->save();

        //dd($empresa,$request);

        $user = new user();
        $user->name       = $nombre;
        $user->email      = $correo;
        $user->password   = Hash::make($password);
        $user->is_admin   = 0;
        $user->id_empresa = $empresa->id;
        $user->save();

        $credenciales['email']    = $correo;
        $credenciales['password'] = $password;
        if (Auth::attempt($credenciales)) {
            $envio_cliente = [
                'Cliente' => [
                    'Rut'         => $rut_empresa,
                    'Razonsocial' => $razon_social,
                    'Giro'        => $giro,
                    'Direccion'   => $direccion,
                    'Comuna'      => $comuna,
                    'Correo'      => $correo,
                    'Ciudad'      => $ciudad,
                    'Telefono'    => $telefono,
                ]
            ];
        
            $envio_cliente = json_encode($envio_cliente);
            WEB_SERVICE_CLIENTE($envio_cliente);

        }
        
        
        return redirect()->route('welcome');


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

        $productos_cargado  = (existen_productos() > 0) ? true : false;
        $bodegas_cargado    = (existen_bodegas() > 0) ? true : false;
        $bodegas_sucursal   = (existen_sucursal() > 0) ? true : false;
        $bodegas_familia    = (existen_familia() > 0) ? true : false;
        $bodegas_subfamilia = (existen_subfamilia() > 0) ? true : false;
        $bodegas_inventario = (existen_inventario() > 0) ? true : false;

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
                ['Tipo' => 'Inventario', 'Estado' => $bodegas_inventario, 'id'=>'td_carga_inventario'],
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

    public function lista_producto_normal(Request $request){
        $id_bodega = $request->id;
        $lista = DB::table('inventarios')->join('productos','productos.codigo','=','inventarios.id_producto')->select('productos.nombre','productos.codigo','productos.precio_venta','productos.id_familia','productos.imagen','productos.exento')->where('productos.estado',1)->where('inventarios.id_bodega',$id_bodega)->get();
        return $lista;
    }

    public function lista_producto_favorito(){
        $lista = DB::table('productos')->select('nombre','codigo','precio_venta','id_familia','imagen','exento')->where('favorito',1)->where('estado',1)->get();
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
        $email      = Auth::user()->email;
        $empresa    = get_empresa($id_empresa);
        $dato       = 0;
        $dataForm   = $request->all();
        
        $array_venta=[
            'rut'            => $empresa->rut,
            'folio'          => $dato,
            'id_direccion'   => ($request->id_direccion==null)? 0 : $request->id_direccion,
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
            'observacion'    => $request->observacion,
        ];

        $venta = new Venta($array_venta);
        $venta->save();
        $id_venta = $venta->id;

        for ($i=0; $i < count($dataForm['item']); $i++) { 
            $item            = (int)$dataForm['item'][$i];
            $codigo          = (string)$dataForm['codigo'][$i];
            $cantidad        = (int)$dataForm['cantidad'][$i];
            $precio_unitario = (int)$dataForm['precio_unitario'][$i];
            $precio_total    = (int)$dataForm['precio_total'][$i];
            
            $detalle =[
                'id_venta'        => $id_venta,
                'item'            => $item,
                'codigo_producto' => $codigo,
                'nombre'          => $codigo,
                'cantidad'        => $cantidad,
                'valor_producto'  => $precio_unitario,
                'total'           => $precio_total, 'valor_descuento' => 0, 
            ];
            $dv = new DetalleVenta($detalle);
            $dv->save();
        }

        $Base64 = base64_encode($id_venta);

        switch ($request->options_pago) {
            case 'flow':

                $datos = [
                    'amount'        => $request->id_total,
                    'email'         => $email,
                    'commerceOrder' => $empresa->rut.'-'.$id_venta,
                    'subject'       => 'Compra a Atravez de Ecommerce',
                    'token'         => $request->_token,
                    'TokenVenta'    => $Base64,
                ];

                $respuesta = $this->pago_flow($datos);
                
                DB::table('venta_flows')->insert( ['id_venta' => $id_venta, 'token' => $respuesta['token'],'url' => $respuesta['url'],'flowOrder' => $respuesta['flowOrder'],'estado' => 1 ] ); 
                
                break;
            
            default:
                # code...
                break;
        }

        

        return redirect()->route('welcome', ['TokenVenta' => $Base64]);

    }

    public function ajax_ventas_totales(Request $request){
        $tipo_venta = $request->tipo_venta;
        $tipo_recepcion = $request->tipo_recepcion;
        
        $desde = $request->desde;
        $hasta = $request->hasta;

        $libro = DB::table('ventas')
        ->join('documento','documento.tipo','=','ventas.tipo_documento')
        ->select('ventas.id','ventas.rut','ventas.folio','ventas.id_direccion','ventas.tipo_entrega','ventas.descuento','ventas.neto','ventas.neto_exento','ventas.iva','ventas.total_venta','documento.nombre as tipo_documento','ventas.forma_pago','ventas.id_bodega','ventas.estado_pago','ventas.id_formapago','ventas.codigo_pago','ventas.created_at','ventas.updated_at')
        ->whereBetween(DB::raw('SUBSTRING(created_at, 1,10)'), [$desde, $hasta]);

        if($tipo_venta == 1){ $libro->where('ventas.folio','!=',0); }else if($tipo_venta == 2){ $libro->where('ventas.folio','=',0); }
        if($tipo_recepcion == 1){ $libro->where('ventas.tipo_entrega','=','retiro'); }else if($tipo_recepcion == 2){ $libro->where('ventas.tipo_entrega','=','despacho'); }

        return Datatables::of($libro)
        ->editColumn('created_at', function ($libro) { return substr($libro->created_at,0,10); })
        ->editColumn('neto', function ($libro) { return "$" . number_format($libro->neto, 0, ",", "."); })
        ->editColumn('neto_exento', function ($libro) { return "$" . number_format($libro->neto_exento, 0, ",", "."); })
        ->editColumn('descuento', function ($libro) { return "$" . number_format($libro->descuento, 0, ",", "."); })
        ->editColumn('iva', function ($libro) { return "$" . number_format($libro->iva, 0, ",", "."); })
        ->editColumn('total_venta', function ($libro) { return "$" . number_format($libro->total_venta, 0, ",", "."); })
        ->editColumn('accion', function ($libro) { return '<a href="'. route('generar.pdf',['TokenVenta'=> base64_encode($libro->id)]) .'" target="_blank" class="btn btn-block btn-warning">Ver Ticket</a>'; })
        ->rawColumns(['created_at', 'neto', 'neto_exento', 'descuento', 'iva', 'total_venta', 'accion'])
        ->make(true);

    }


    public function ajax_ventas_cliente(Request $request){

        

        $id_empresa = Auth::user()->id_empresa;
        $empresa = get_empresa($id_empresa);

        $desde = $request->desde;
        $hasta = $request->hasta;

        
        
        $libro = DB::table('ventas')
        ->join('documento','documento.tipo','=','ventas.tipo_documento')
        ->select('ventas.id','ventas.rut','ventas.folio','ventas.id_direccion','ventas.tipo_entrega','ventas.descuento','ventas.neto','ventas.neto_exento','ventas.iva','ventas.total_venta','documento.nombre as tipo_documento','ventas.forma_pago','ventas.id_bodega','ventas.estado_pago','ventas.id_formapago','ventas.codigo_pago','ventas.created_at','ventas.updated_at')
        ->where('ventas.rut',$empresa->rut)
        ->where('ventas.folio','!=',0)
        ->whereBetween(DB::raw('SUBSTRING(ventas.created_at, 1,10)'), [$desde, $hasta]);

        return Datatables::of($libro)
        ->editColumn('created_at', function ($libro) { return substr($libro->created_at,0,10); })
        ->editColumn('neto', function ($libro) { return "$" . number_format($libro->neto, 0, ",", "."); })
        ->editColumn('neto_exento', function ($libro) { return "$" . number_format($libro->neto_exento, 0, ",", "."); })
        ->editColumn('descuento', function ($libro) { return "$" . number_format($libro->descuento, 0, ",", "."); })
        ->editColumn('iva', function ($libro) { return "$" . number_format($libro->iva, 0, ",", "."); })
        ->editColumn('total_venta', function ($libro) { return "$" . number_format($libro->total_venta, 0, ",", "."); })
        ->editColumn('accion', function ($libro) { return '<a href="'. route('generar.pdf',['TokenVenta'=> base64_encode($libro->id)]) .'" target="_blank" class="btn btn-block btn-warning">Ver Ticket</a>'; })
        ->rawColumns(['created_at', 'neto', 'neto_exento', 'descuento', 'iva', 'total_venta', 'accion'])
        ->make(true);

    }

    public function lista_categoria(){
        
        $categoria = DB::table('sub_familias')->select('id','nombre','estado')->where('estado',1)->get();
        return $categoria;
    }

    public function lista_productos(){

        $producto = DB::table('productos')
        ->join('sub_familias','sub_familias.id','=','productos.id_familia')
        ->select('productos.id','productos.nombre','productos.codigo','productos.precio_venta','sub_familias.nombre as subfamilia','productos.favorito','productos.estado');

        return Datatables::of($producto)
        ->editColumn('precio_venta', function ($producto) { return "$" . number_format($producto->precio_venta, 0, ",", "."); })
        ->editColumn('favorito', function ($producto) { 
            $favorito = ($producto->favorito == 1) ? 'SI':'NO';
            return '<a onclick="cambiar_favorito_producto('.$producto->id.')" class="btn btn-primary btn-warning">'.$favorito.'</a>'; 
        })
        ->editColumn('estado', function ($producto) { 
            $estado = ($producto->estado == 1) ? 'SI':'NO';
            return '<a onclick="cambiar_estado_producto('.$producto->id.')" class="btn btn-primary btn-warning">'.$estado.'</a>'; 
        })
        ->rawColumns(['precio_venta', 'favorito', 'estado'])
        ->make(true);
        

    }


    public function lista_subfamilia(){

        $producto = DB::table('sub_familias')->select('id','nombre','estado');

        return Datatables::of($producto)
        ->editColumn('estado', function ($producto) { 
            $estado = ($producto->estado == 1) ? 'SI':'NO';
            return '<a onclick="cambiar_estado_subfamilia('.$producto->id.')" class="btn btn-primary btn-warning">'.$estado.'</a>'; 
        })
        ->rawColumns([ 'estado'])
        ->make(true);
        

    }

    public function lista_bodega_panel(){

        $bodega = DB::table('bodegas')->select('id','nombre','estado');

        return Datatables::of($bodega)
        ->editColumn('estado', function ($bodega) { 
            $estado = ($bodega->estado == 1) ? 'SI':'NO';
            return '<a onclick="cambiar_estado_bodega('.$bodega->id.')" class="btn btn-primary btn-warning">'.$estado.'</a>'; 
        })
        ->rawColumns([ 'estado'])
        ->make(true);
    }


    public function cambiar_favorito_producto(Request $request){
        $id_producto = (int)$request->id;
        $respuesta['respuesta'] = false;
        $producto = Producto::find($id_producto);
        if($producto != null){

            $estado_actual = ($producto->favorito == 1) ? true : false;
            $nuevo_estado  = ($estado_actual) ? false : true;

            $producto->favorito = $nuevo_estado;
            $producto->save();
            $respuesta['respuesta'] = true;
        }
        return $respuesta;
    }

    public function cambiar_estado_producto(Request $request){
        $id_producto = (int)$request->id;
        $respuesta['respuesta'] = false;
        $producto = Producto::find($id_producto);
        if($producto != null){

            $estado_actual = ($producto->estado == 1) ? true : false;
            $nuevo_estado  = ($estado_actual) ? false : true;

            $producto->estado = $nuevo_estado;
            $producto->save();
            $respuesta['respuesta'] = true;
        }
        return $respuesta;
    }

    public function cambiar_estado_subfamilia(Request $request){
        $id = (int)$request->id;
        $respuesta['respuesta'] = false;
        $sub_familia = SubFamilia::find($id);
        if($sub_familia != null){

            $estado_actual = ($sub_familia->estado == 1) ? true : false;
            $nuevo_estado  = ($estado_actual) ? false : true;

            $sub_familia->estado = $nuevo_estado;
            $sub_familia->save();
            $respuesta['respuesta'] = true;
        }
        return $respuesta;
    }

    public function cambiar_estado_bodega(Request $request){
        $id = (int)$request->id;
        $respuesta['respuesta'] = false;
        $bodega = Bodega::find($id);
        if($bodega != null){

            $estado_actual = ($bodega->estado == 1) ? true : false;
            $nuevo_estado  = ($estado_actual) ? false : true;

            $bodega->estado = $nuevo_estado;
            $bodega->save();
            $respuesta['respuesta'] = true;
        }
        return $respuesta;
    }

    public function datos_venta(Request $request){
        $token    = $request->TokenVenta;
        $id_venta = base64_decode($token);

        $pago = [ 'Flow' => null, 'Match' => null, ];
        $direccion = null;
        

        $venta     = DB::table('ventas')->select('id', 'rut', 'folio', 'id_direccion', 'tipo_entrega', 'descuento', 'neto', 'neto_exento', 'iva', 'total_venta', 'tipo_documento', 'forma_pago', 'id_bodega', 'estado_pago', 'id_formapago', 'codigo_pago', 'created_at','observacion')->where('id',$id_venta)->first();
        
        $detalle   = DB::table('detalle_ventas')->select('id', 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento',)->where('id_venta',$id_venta)->get();

        

        if($venta->id_direccion != 0){
            $direccion = DB::table('direccions')->select()->where('id',$venta->id_direccion)->first();
        }
        

        switch ($venta->forma_pago) {
            case 'flow':
                $pago_flow = DB::table('venta_flows')->select('url','token','flowOrder','log_pago','estado')->where('id_venta',$id_venta)->first();
                $pago['Flow'] = $pago_flow;
                break;
            
            default:
                # code...
                break;
        }
        

        
        $respuesta = [
            'Venta'=>$venta,
            'Detalle'=>$detalle,
            'Pago'=>$pago,
            'Direccion'=>$direccion,
        ];

        return $respuesta;
    }

    public function estado_pago(Request $request){

        $token     = $request->TokenVenta;
        $id_venta  = base64_decode($token);
        $formapago = $request->formapago;

        $respuesta = [
            'estado' => false,
            'pago' => [
                'Flow' => null,
                'Match' => null,
            ],
        ];


        switch ($formapago) {
            case 'flow':
                $venta_flow = DB::table('venta_flows')->select('id','token')->where('id_venta',$id_venta)->first();

                $token = $venta_flow->token;

                $estado_flow = $this->pago_flow_status($token);
                

                $respuesta['estado'] = true;
                $respuesta['pago']['Flow'] = $estado_flow;


                //DB::table('venta_flows')->where('id', $venta_flow->id)->update(['estado' => $estado_flow->status]);
                


                break;
            
            default:
                # code...
                break;
        }

       

        return $respuesta;

    }

    public function generar_pdf(Request $request){
        
        $token    = $request->TokenVenta;
        $id_venta = (int)base64_decode($token);


        
        

        if($id_venta == 0){
            dd("PDF no Existe");
        }
        
        

        $venta     = DB::table('ventas')->select('id', 'rut', 'folio', 'id_direccion', 'tipo_entrega', 'descuento', 'neto', 'neto_exento', 'iva', 'total_venta', 'tipo_documento', 'forma_pago', 'id_bodega', 'estado_pago', 'id_formapago', 'codigo_pago', 'created_at')->where('id',$id_venta)->first();
        
        $detalle   = DB::table('detalle_ventas')->select('id', 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento',)->where('id_venta',$id_venta)->get();



        

        $pdf = PDF::loadView('pdf.ticket', compact('venta', 'detalle'), ['name' => 'data']);
        $pdf->setPaper('A6', 'legal');
        return $pdf->stream("factura_".$id_venta.".pdf");


    }

    /*TEST FLOW*/

    public function pago_flow_test(Request $request){

        $correo = $request->correo;
        $monto  = (int)$request->monto;
        $comentario = $request->comentario;
        $token_sesion=$request->_token;
        $return_url= route("ajax.generar.pago.flow.confirmacion",['_token'=>$token_sesion]);
        $return_url_confirmacion =  'http://appnettech.cl/api/guargarjson';


        $datos = [
            'currency'        => 'CLP',
            'amount'          => $monto,
            'email'           => $correo,
            'commerceOrder'   => 'CLP7',
            'urlConfirmation' => $return_url_confirmacion,
            'urlReturn'       => $return_url,
            'subject'         => $comentario,

        ];
        
        return (array)FLOW_PAY_CREATE($datos);
    }

    public function pago_flow_status_test(){
        $datos = [
            'apiKey'        => API_KEY_FLOW(),
            'token'          => 'EC31F74F9D6175FE01EFDC34E9686D69558CEF4D',
        ];
        
        $respuesta =FLOW_PAY_STATUS($datos);
        dd($respuesta->status,$respuesta);
    }

    public function pago_flow_test_configuracion(Request $request){
        $TokenVenta     = $request->query('TokenVenta');
        $pago_procesado = 1;
        return redirect()->route('welcome', ['TokenVenta' => $TokenVenta, 'pago' => $pago_procesado]);
    }

    /*Fin TEST FLOW*/

    public function carga_datos_flow(Request $request){
        $respuesta = ['respuesta'=>false];
        $API_KEY_FLOW    = ($request->API_KEY_FLOW == null) ? '' : $request->API_KEY_FLOW;
        $SECRET_KEY_FLOW = ($request->API_KEY_FLOW == null) ? '' : $request->SECRET_KEY_FLOW;

        try {
            $existe_api_key    = $this->existe_api_key_flow();
            $existe_secret_key = $this->existe_secret_key_flow();

            if($existe_api_key){
                DB::table('tokens')->where('tipo', 'API_KEY_FLOW')->update(['token' => $API_KEY_FLOW]);
            }else{
                DB::table('tokens')->insert( ['tipo' => 'API_KEY_FLOW', 'token' => $API_KEY_FLOW] );
            }

            if($existe_secret_key){
                DB::table('tokens')->where('tipo', 'SECRET_KEY_FLOW')->update(['token' => $SECRET_KEY_FLOW]);
            }else{
                DB::table('tokens')->insert( ['tipo' => 'SECRET_KEY_FLOW', 'token' => $SECRET_KEY_FLOW] );
            }

            $respuesta['respuesta'] = true;
            
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $respuesta;
    }

    public function get_datos_flow(){
        
        $API_KEY_FLOW    = DB::table('tokens')->select('token')->where('tipo','API_KEY_FLOW')->first();
        $SECRET_KEY_FLOW = DB::table('tokens')->select('token')->where('tipo','SECRET_KEY_FLOW')->first();

        $API_KEY_FLOW    = ($API_KEY_FLOW == null) ? '' : $API_KEY_FLOW->token;
        $SECRET_KEY_FLOW = ($SECRET_KEY_FLOW == null) ? '' : $SECRET_KEY_FLOW->token;

        $API_KEY_FLOW    = ($API_KEY_FLOW == '') ? '' :  ocultar_string($API_KEY_FLOW);
        $SECRET_KEY_FLOW = ($SECRET_KEY_FLOW == '') ? '' :  ocultar_string($SECRET_KEY_FLOW);


        return [
            'API_KEY_FLOW'    => $API_KEY_FLOW,
            'SECRET_KEY_FLOW' => $SECRET_KEY_FLOW ,
        ];
    }

    public function carga_correo_aviso(Request $request){
        $respuesta        = ['respuesta'=>false];
        try {
            $correo_principal = $request->correo_principal;
            $correo_copia     = $request->correo_copia;
            $correo_asunto    = $request->correo_asunto;

            $obj_correo = (object)[ 'principal' => $correo_principal, 'copia' => $correo_copia, 'asunto' => $correo_asunto, ];
            $obj_correo = json_encode($obj_correo);
            $existe     = $this->existe_correo();

            if($existe){
                DB::table('tokens')->where('tipo', 'correo')->update(['token' => $obj_correo]);
            }else{
                DB::table('tokens')->insert( ['tipo' => 'correo', 'token' => $obj_correo] );
            }
            $respuesta['respuesta'] = true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $respuesta;
    }

    public function get_correo_aviso(){
        $datos = DB::table('tokens')->select('token')->where('tipo','correo')->first()->token;
        $datos = (array)json_decode($datos);
        return $datos;
    }

    public function get_configuracion_correo(){
        $datos = DB::table('tokens')->select('token')->where('tipo','correo_configuracion')->first()->token;
        $datos = (array)json_decode($datos);
        return $datos;
    }

    public function carga_configuracion_correo(Request $request){
        $respuesta        = ['respuesta'=>false];
        try {
            $host     = $request->host;
            $port     = $request->port;
            $correo   = $request->correo;
            $password = $request->password;

            $obj_correo = (object)[ 'host' =>$host,'port' =>$port,'correo' =>$correo,'password' =>$password, ];
            $obj_correo = json_encode($obj_correo);
            $existe     = $this->existe_configuracion_correo();

            if($existe){
                DB::table('tokens')->where('tipo', 'correo_configuracion')->update(['token' => $obj_correo]);
            }else{
                DB::table('tokens')->insert( ['tipo' => 'correo_configuracion', 'token' => $obj_correo] );
            }
            $respuesta['respuesta'] = true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $respuesta;
    }

    public function guardar_direccion(Request $request){
        
        $respuesta['respuesta'] = false;
        $respuesta['id'] = 0;
        
        $id_empresa = Auth::user()->id_empresa;
        $empresa    = get_empresa($id_empresa);

        $direccion   = strtoupper((string)$request->direccion);
        $ciudad      = strtoupper((string)$request->ciudad);
        $comuna      = strtoupper((string)$request->comuna);
        $observacion = strtoupper((string)$request->observacion);

        $existe = $this->existe_direccion($empresa->rut,$direccion);

        if(!$existe){
            try {
               $id =  DB::table('direccions')->insertGetId( [ 'direccion' => $direccion, 'rut' => $empresa->rut, 'ciudad' => $ciudad, 'comuna' => $comuna, 'observacion' => $observacion, ] );
                $respuesta['respuesta'] = true;
                $respuesta['id'] = $id;
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return $respuesta;
    }

    public function lista_direccion(){
        $lista = DB::table('direccions')->select('id','direccion','ciudad','comuna');

        return Datatables::of($lista)
        ->editColumn('accion', function ($lista) { 
            
            return '<a class="btn btn-primary btn-warning" onclick="seleccion_direccion('.$lista->id.')">Seleccionar</a>'; 
        })
        ->rawColumns([ 'accion'])
        ->make(true);
    }





    private function existe_empresa(){
        return existe_credenciales();
    }

    private function pago_flow($data){
        $token_sesion=$data['token'];
        $return_url= route("ajax.generar.pago.flow.confirmacion",['_token'=>$token_sesion, 'TokenVenta'=>$data['TokenVenta']]);
        $return_url_confirmacion =  route("api.recibe.informacion.flow");
        
        $datos = [
            'currency'        => 'CLP',
            'amount'          => $data['amount'],
            'email'           => $data['email'],
            'commerceOrder'   => $data['commerceOrder'],
            'urlConfirmation' => $return_url_confirmacion,
            'urlReturn'       => $return_url,
            'subject'         => $data['subject'],

        ];
        
        return (array)FLOW_PAY_CREATE($datos);

    }

    private function pago_flow_status($token){
        $datos = [
            'apiKey' => API_KEY_FLOW(),
            'token'  => $token,
        ];
        
        $respuesta = FLOW_PAY_STATUS($datos);
        return $respuesta;
    }

    private function existe_api_key_flow(){
        $existe = DB::table('tokens')->select('id')->where('tipo','API_KEY_FLOW')->first();
        return ($existe == null) ? false : true;
    }
    private function existe_secret_key_flow(){
        $existe = DB::table('tokens')->select('id')->where('tipo','SECRET_KEY_FLOW')->first();
        return ($existe == null) ? false : true;
    }

    private function existe_correo(){
        $existe = DB::table('tokens')->select('id')->where('tipo','correo')->first();
        return ($existe == null) ? false : true;
    }

    private function existe_configuracion_correo(){
        $existe = DB::table('tokens')->select('id')->where('tipo','correo_configuracion')->first();
        return ($existe == null) ? false : true;
    }

    private function existe_direccion($rut,$direccion){
        $existe = DB::table('direccions')->select('id')->where('rut',$rut)->where('direccion',$direccion)->first();
        return ($existe == null) ? false : true;
    }
}

