<?php
use App\Producto;
use App\Bodega;
use App\Sucursal;
use App\Familia;
use App\SubFamilia;
use App\Inventario;

use PHPMailer\PHPMailer;


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

function existen_inventario(){
    try {
        $existe = DB::table('inventarios')->select(DB::raw('count(id) as cantidad'))->first();
        
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

function getPrimerUltimoFecha(){
    $mes  = date('m');
    $anio = date('Y');
    $dia  = date("d", mktime(0, 0, 0, $mes + 1, 0, $anio));

    $ultimo  = date('Y-m-d', mktime(0, 0, 0, $mes, $dia, $anio));
    $primero = date('Y-m-d', mktime(0, 0, 0, $mes, 1, $anio));

    $respuesta = [
        'primero' => $primero,
        'ultimo'  => $ultimo,
    ];
    return $respuesta;
}

function ocultar_string($texto){
    $largo_instancia = (int)(strlen($texto) / 2);
    $texto           = substr($texto,0,$largo_instancia );
    for ($i=0; $i <=$largo_instancia ; $i++) { $texto.="*"; }
    
    return $texto;
}

function envio_correo(int $id_venta){

    try {
        $venta     = DB::table('ventas')->select('id', 'rut', 'folio', 'id_direccion', 'tipo_entrega', 'descuento', 'neto', 'neto_exento', 'iva', 'total_venta', 'tipo_documento', 'forma_pago', 'id_bodega', 'estado_pago', 'id_formapago', 'codigo_pago', 'created_at')->where('id',$id_venta)->first();

        //$detalle   = DB::table('detalle_ventas')->select('id', 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento',)->where('id_venta',$id_venta)->get();

        //dd($venta);

        $datos_cliente = datos_cliente($venta->rut);

        dd($datos_cliente);
    
        $informacion_correo = informacion_correo();
        $email = $datos_cliente['principal'];
        $email = $informacion_correo['copia'];
        $asunto = $informacion_correo['asunto'];

        $mensaje = '
        <p>Estimada/o : <h3>'.$empresa->razon_social.'</h3></p>
        
       
        
        
        ';

        dd($mensaje);
        

        $estado = send_mail($email,$asunto,$mensaje,$cc);
        dd($estado);

    } catch (\Throwable $th) {
        //throw $th;
        dd($th);
    }
    

   

   
}

function datos_cliente($rut){
    $empresa = DB::table('empresas')->select()->where('rut',$rut)->first();
    $user = DB::table('users')->select()->where('id_empresa',$empresa->id)->first();

    dd($empresa,$user);
}

function informacion_correo(){
    $datos = DB::table('tokens')->select('token')->where('tipo','correo')->first()->token;
    $datos = (array)json_decode($datos);
    return $datos;
}


function send_mail($email,$asunto,$mensaje,$cc = null){
    
    $respuesta = false;
    try {
        $mail = new PHPMailer\PHPMailer();
        $mail->isSMTP(); // tell to use smtp
        $mail->CharSet = "utf-8"; // set charset to utf8
        $mail->SMTPAuth = true;  // use smpt auth
        $mail->SMTPSecure = "ssl"; // or ssl
        $mail->Host = "mail.appnet.cl";
        $mail->Port = 465; // most likely something different for you. This is the mailtrap.io port i use for testing. 
        $mail->Username = "test@appnet.cl";
        $mail->Password = "J&uuU^EXW;K6";
        $mail->setFrom("info@appnet.cl", "Appnet Technology");
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body = $mensaje;
        $mail->addAddress($email, "Recipient Name");
        if($cc != null){ $mail->AddCC($cc, 'Person One'); }
        
        $mail->send();
        $respuesta = true;
    } catch (phpmailerException $e) {
        //dd("Error mail",$e);
        $respuesta = false;
    } catch (Exception $e) {
        //dd("Error php",$e);
        $respuesta = false;
    }
    ///die('success');
    return $respuesta;
}

function push_notification_android($device_id,$title,$message,$data){
    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';
    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
    $api_key = 'AAAAYmLcwEM:APA91bE-tllvCsWhxePeVSfgSrR_Ev-ffucFsA0m3y0YYxjil1QYhavHUaZ8npzTRBXoByfsmUKXNh4819CN5XK3PBay9886IWCBsdUgfftivzlQOGogEMyxE_KrEfzcrN1Xh7LqltlA';

    $fields = array (
        'to' => $device_id,
        'data' => array ("Json" => $data),
        'title' => $title,
        'body'  => $message
    );


    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
