<?php
use App\Producto;
use App\Bodega;
use App\Sucursal;
use App\Familia;
use App\SubFamilia;
use App\Inventario;


function get_url_servidor(string $servidor ='local'){
    $servidores = [
        'productivo'=>'appnettech.cl',
        'pruebas'=>'192.168.0.2',
        'local'=>'localhost'
    ];
    return $servidores[$servidor];
}

function getUserTipo(){
    try {
        if (session()->get('tipo_usuario') == null) {
            session(['tipo_usuario' => Auth::user()->is_admin]);
            return getUserTipo();
        } else {
            return session()->get('tipo_usuario');
        }
    } catch (\Throwable $th) { return 0; }
}

function is_admin(){
    return (getUserTipo() == 1) ? true : false;
}

function WEB_SERVICE_LOGIN($login){
    $respuesta = false;
    try {
        $URL = get_url_servidor('local').'/api/login';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', $URL, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode(['username' => $login->username,'empresa' => $login->empresa,'password' => $login->password,]),
        ]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        
        
        $TOKEN = $resultado[0]->Token;
        $BODEGA = $resultado[0]->id_bodega;

        
        $respuesta = guardar_token($TOKEN);
        $respuesta = guardar_bodega($BODEGA);
        
    } catch (\Throwable $th) {
        //throw $th;
    }

    return $respuesta;
}

function WEB_SERVICE_PRODUCTOS(){
    
    $respuesta = false;
    try {
        Producto::truncate();
        $URL = get_url_servidor('local').'/api/productos';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);

        foreach ($resultado as $key => $value) {
            $array_aux = [ 'nombre' => $value->nombre, 'precio_venta' => $value->precio_venta, 'precio_venta_neto' => $value->precio_venta_neto, 'codigo' => $value->codigo, 'id_familia' => $value->id_familia, 'imagen' => ($value->imagen == null) ? 'Sin Imagen' : $value->imagen, 'exento' => ($value->excento === 'true') ? true : false, 'favorito' => false, ];
            $producto = new Producto($array_aux);
            $producto->save();
        }
        $respuesta = true;
        
    } catch (\Throwable $th) {
        //throw $th;
    }
    return $respuesta;
}

function WEB_SERVICE_BODEGA(){
    $respuesta = false;
    try {
        Bodega::truncate();
        $URL = get_url_servidor('local').'/api/bodega';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {
            
            $array_aux = [
                'id' =>$value->id,
                'nombre' =>$value->descripcion,
                'estado' =>1,
            ];
         
            $bodega = new Bodega($array_aux);
            $bodega->save();
        }
        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
        $respuesta = false;
    }
    return $respuesta;

}

function WEB_SERVICE_SUCURSAL(){
    $respuesta = false;
    try {
        Sucursal::truncate();
        $URL = get_url_servidor('local').'/api/sucursal';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {
            
            $array_aux =[
                'id'=>$value->id,
                'nombre'=>$value->nombre,
                'direccion'=>$value->direccion,
                'ciudad'=>$value->ciudad,
                'comuna'=>$value->comuna,
                'telefono'=>$value->telefono,
            ];
            $sucursal = new Sucursal($array_aux);
            $sucursal->save();
        }
        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
        $respuesta = false;
    }
    return $respuesta;

}

function WEB_SERVICE_FAMILIA(){
    $respuesta = false;
    try {
        Familia::truncate();
        $URL = get_url_servidor('local').'/api/familia';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {
            
            $array_aux =[
                'id'=>$value->id,
                'nombre'=>$value->nombre,
            ];
            $familia = new Familia($array_aux);
            $familia->save();
        }
        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
        $respuesta = false;
    }
    return $respuesta;

}

function WEB_SERVICE_SUBFAMILIA(){
    $respuesta = false;
    try {
        SubFamilia::truncate();
        $URL = get_url_servidor('local').'/api/subfamilia';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {
            
            $array_aux =[
                'id'=>$value->id,
                'nombre'=>$value->nombre,
                'id_familia'=>$value->id_familia,
            ];
            $subfamilia = new SubFamilia($array_aux);
            $subfamilia->save();
        }
        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
        $respuesta = false;
    }
    return $respuesta;
}

function WEB_SERVICE_INVENTARIO(){
    $respuesta = false;
    try {
        Inventario::truncate();
        $URL = get_url_servidor('local').'/api/inventario';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {
            
            $array_aux =[
                'id_bodega'=>$value->id_bodega,
                'id_producto'=>$value->id_producto,
                'stock'=>$value->stock,
            ];
            $inventario = new Inventario($array_aux);
            $inventario->save();
        }
        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
        $respuesta = false;
    }
    return $respuesta;
}

function WEB_SERVICE_VENTA($json){
    
    $URL = get_url_servidor('local').'/api/venta';

    $client = new \GuzzleHttp\Client();
    $response = $client->request('post', $URL, [
        'headers' => [
        'Content-Type' => 'application/json',
        'token' => obtener_token()
        ],
        'body' => $json                
        
    ]);
    $resultado = $response->getBody()->getContents();
    $resultado =json_decode($resultado);
    return $resultado;
}


function obtener_token(){
    $existe = DB::table('tokens')->select('token')->where('tipo','session')->first();
    return $existe->token;
}

function guardar_token(string $token){
    $respuesta = false;
    try {

        if(existe_token($token)){ DB::table('tokens')->where('tipo', 'session')->update(['token' => $token]);
        }else{ DB::table('tokens')->insert( ['tipo' => 'session', 'token' => $token] ); }

        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
    }
    return $respuesta;
}

function guardar_bodega(int $id_bodega){
    $respuesta = false;
    try {
        if(existe_bodega($id_bodega)){ DB::table('tokens')->where('tipo', 'bodega')->update(['token' => $id_bodega]);
        }else{ DB::table('tokens')->insert( ['tipo' => 'bodega', 'token' => $id_bodega] ); }

        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
    }
    return $respuesta;
}


function existe_token(string $token){
    $existe = DB::table('tokens')->select('id')->where('tipo','session')->first();
    return ($existe != null) ? true : false;
}
function existe_bodega(int $id_bodega){
    $existe = DB::table('tokens')->select('id')->where('tipo','bodega')->first();
    return ($existe != null) ? true : false;
}

function guardar_credenciales($login){
    
    $credenciales_json = json_encode($login);
    if(existe_credenciales()){ 
        DB::table('tokens')->where('tipo', 'credencial')->update(['token' => $credenciales_json]);
    }else{ 
        DB::table('tokens')->insert( ['tipo' => 'credencial', 'token' => $credenciales_json] ); 
    }
}

function existe_credenciales(){
    $existe = DB::table('tokens')->select()->where('tipo','credencial')->first();
    return ($existe != null) ? true : false;
}

function obtener_credenciales(){
    $existe = DB::table('tokens')->select('token')->where('tipo','credencial')->first();
    return $existe->token;
}

function obtener_id_bodega_defecto(){
    $respuesta = -1;
    try {
        $existe = DB::table('tokens')->select('token')->where('tipo','bodega')->first();
        $respuesta =  $existe->token;
    } catch (\Throwable $th) {
        //throw $th;
    }
    return $respuesta;
}

function existen_productos(){
    try {
        $existe = DB::table('productos')->select(DB::raw('count(id) as cantidad'))->first();
        $cantidad = $existe->cantidad;
    } catch (\Throwable $th) {
        //throw $th;
        $cantidad = 0;
    }
    return $cantidad;
}

function existen_bodegas(){
    try {
        $existe = DB::table('bodegas')->select(DB::raw('count(id) as cantidad'))->first();
        
        $cantidad = $existe->cantidad;
    } catch (\Throwable $th) {
        //throw $th;
        $cantidad = 0;
    }
    return $cantidad;
}

function existen_sucursal(){
    try {
        $existe = DB::table('sucursals')->select(DB::raw('count(id) as cantidad'))->first();
        
        $cantidad = $existe->cantidad;
    } catch (\Throwable $th) {
        //throw $th;
        $cantidad = 0;
    }
    return $cantidad;
}

function existen_familia(){
    try {
        $existe = DB::table('familias')->select(DB::raw('count(id) as cantidad'))->first();
        
        $cantidad = $existe->cantidad;
    } catch (\Throwable $th) {
        //throw $th;
        $cantidad = 0;
    }
    return $cantidad;
}

function existen_subfamilia(){
    try {
        $existe = DB::table('sub_familias')->select(DB::raw('count(id) as cantidad'))->first();
        
        $cantidad = $existe->cantidad;
    } catch (\Throwable $th) {
        //throw $th;
        $cantidad = 0;
    }
    return $cantidad;
}

function get_empresa(int $id){
    $empresa = DB::table('empresas')->select('id', 'rut', 'razon_social', 'direccion', 'comuna', 'ciudad')->where([ ['id',$id] ])->first();
    return $empresa;
}

function generar_formato_venta(int $id_venta){

    $venta         = DB::table('ventas')->select()->where('id',$id_venta)->first();
    $detalle_venta = DB::table('detalle_ventas')->select()->where('id_venta',$id_venta)->get();


    $Detalle = [];

    $dia              = substr($venta->created_at, 8,2);
    $mes              = substr($venta->created_at, 5, 2);
    $anio             = substr($venta->created_at, 0, 4);

    $fecha_vencimiento = substr($venta->created_at, 0, 10);

   

    $Encabezado = [
        'Total' => $venta->total_venta,
        'IVA' => $venta->iva,
        'NetoExento' => $venta->neto_exento,
        'NetoAfecto' => $venta->neto,
        'Descuento' => $venta->descuento,
        'formapago' => $venta->id_formapago,
        'Documento' => $venta->tipo_documento,
        'Bodega' => $venta->id_bodega,

        'Dia' => $dia,
        'Mes' => $mes,
        'Anio' => $anio,
        'FechaVencimiento' => $fecha_vencimiento,

        'Cliente' => $venta->rut,
        'Estado' => 1,
        'Propina' => 0,
        'Observacion' => '',
    ];

    foreach ($detalle_venta as $key => $value) {
        $array_detalle = [
            'Item' => $value->item,
            'Codigo' => $value->codigo_producto,
            'Precio' => $value->valor_producto,
            'Cantidad' => $value->cantidad,
            'Descuento' => $value->valor_descuento,
            'Detallelargo' => $value->nombre,
        ];
        array_push($Detalle, $array_detalle);
    }

    $venta_json = [
        'Encabezado' =>$Encabezado,
        'Detalle' =>$Detalle,
        'Pago' =>[
            [
                'Formapago' => $venta->id_formapago,
                'Total'    => $venta->total_venta,
            ]
        ],
        
    ];


    $json =json_encode($venta_json);
    return $json;
}

function FLOW_PAY_CREATE($datos = null){
    
    
    $dato      = FLOW_PAY_SIGNATURE($datos);
    
    $params    = $dato['params'];
    $signature = $dato['signature'];
    
    $url = 'https://sandbox.flow.cl/api';
    $url = $url . '/payment/create';
    
    $params["s"] = $signature;

    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        if($response === false) {
            $error = curl_error($ch);
            throw new Exception($error, 1);
        } 
        $info = curl_getinfo($ch);
        
        
        return json_decode($response);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }

}

function FLOW_PAY_STATUS($datos = null){
    $url = 'https://sandbox.flow.cl/api';
    $url = $url . '/payment/getStatus';

    $dato      = FLOW_PAY_SIGNATURE($datos);
    
    $params    = $dato['params'];
    $signature = $dato['signature'];

    $params["s"] = $signature;

    $url = $url . "?" . http_build_query($params);
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        return json_decode($response);
    } catch (Exception $e) {
      echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
    }
}

function FLOW_PAY_SIGNATURE($datos = null){
    
    $params = array(  "apiKey" => API_KEY_FLOW(), ); 

    if($datos != null){ $params= array_merge($params,$datos); }
    
    $keys = array_keys($params);
    sort($keys);
    $toSign = "";
    
    foreach($keys as $key) { $toSign .= $key . $params[$key]; };
    
    $signature = hash_hmac('sha256', $toSign , SECRET_KEY_FLOW());

    $respuesta = [ 'params' => $params, 'signature' => $signature, ];
    return $respuesta;
}

function API_KEY_FLOW(){
    return '28F56082-BF69-41FF-AAC4-2FL575C8D8E6';
}

function SECRET_KEY_FLOW(){
    return 'f01f946ddc531e41da18507046f9419325c78269';
}

