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
        $URL = get_url_servidor('productivo').'/api/login';
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
        //Producto::truncate();
        $URL = get_url_servidor('productivo').'/api/productos';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);

        foreach ($resultado as $key => $value) {
            $existe = existe_producto($value->codigo);
            if($existe == -1){
                $array_aux = [ 'nombre' => $value->nombre, 'descripcion' => $value->descripcion, 'precio_venta' => $value->precio_venta, 'precio_venta_neto' => $value->precio_venta_neto, 'codigo' => $value->codigo, 'id_familia' => $value->id_familia, 'imagen' => ($value->imagen == null) ? 'Sin Imagen' : $value->imagen, 'exento' => ($value->excento === 'true') ? true : false, 'favorito' => false, ];
                $producto = new Producto($array_aux);
                $producto->save();
            }else{
                $producto = Producto::find($existe);

                $producto->nombre            = $value->nombre;
                $producto->descripcion       = $value->descripcion;
                $producto->precio_venta      = $value->precio_venta;
                $producto->precio_venta_neto = $value->precio_venta_neto;
                $producto->id_familia        = $value->id_familia;
                $producto->imagen            = ($value->imagen == null) ? 'Sin Imagen' : $value->imagen;
                $producto->exento            = ($value->excento === 'true') ? true : false;
                $producto->save();
            }
            
        }
        $respuesta = true;
        
    } catch (\Throwable $th) {
        //throw $th;
        //dd($th);
    }
    return $respuesta;
}

function WEB_SERVICE_BODEGA(){
    $respuesta = false;
    try {
        //Bodega::truncate();
        $URL = get_url_servidor('productivo').'/api/bodega';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {

            $existe = existe_registro_bodega($value->id);
            if(!$existe){
                $array_aux = ['id' =>$value->id,'nombre' =>$value->descripcion,'estado' =>1,];
                $bodega = new Bodega($array_aux);
                $bodega->save();
            }else{
                $bodega = Bodega::find($value->id);
                $bodega->nombre = $value->descripcion;
                $bodega->save();
            }
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
        $URL = get_url_servidor('productivo').'/api/sucursal';
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
        $URL = get_url_servidor('productivo').'/api/familia';
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
        $URL = get_url_servidor('productivo').'/api/subfamilia';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('get', $URL, ['headers' => ['Content-Type' => 'application/json','token' => obtener_token() ],]);
        $resultado = $response->getBody()->getContents();
        $resultado =json_decode($resultado);
        foreach ($resultado as $key => $value) {

            $existe = existe_registro_subfamilia($value->id);
            if(!$existe){
                $array_aux =[ 'id'=>$value->id, 'nombre'=>$value->nombre, 'id_familia'=>$value->id_familia, ];
                $subfamilia = new SubFamilia($array_aux);
                $subfamilia->save();
            }else{
                $subfamilia = SubFamilia::find($value->id);
                

                $subfamilia->nombre     = $value->nombre;
                $subfamilia->id_familia = $value->id_familia;
                $subfamilia->save();
            }
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
        $URL = get_url_servidor('productivo').'/api/inventario';
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
    
    $URL = get_url_servidor('productivo').'/api/venta';

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

function WEB_SERVICE_CLIENTE($json){
    $respuesta = false;
    try {
        $URL = get_url_servidor('productivo').'/api/createcliente';
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

        $respuesta = true;
    } catch (\Throwable $th) {
        //throw $th;
    }
    return $respuesta;
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
    //$url = 'https://sandbox.flow.cl/api';
    $url = URL_FLOW();
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
    //$url = 'https://sandbox.flow.cl/api';
    $url = URL_FLOW();
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
function URL_FLOW(){
    $token = DB::table('tokens')->select('token')->where('tipo','FLOW')->first()->token;
    return $token;
}
function API_KEY_FLOW(){
    $token = DB::table('tokens')->select('token')->where('tipo','API_KEY_FLOW')->first()->token;
    return $token;
    
}

function SECRET_KEY_FLOW(){
    $token = DB::table('tokens')->select('token')->where('tipo','SECRET_KEY_FLOW')->first()->token;
    return $token;
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
        $detalle   = DB::table('detalle_ventas')->select('id', 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento',)->where('id_venta',$id_venta)->get();

        $datos_cliente = datos_cliente($venta->rut);
    
        $informacion_correo = informacion_correo();
        $email  = $datos_cliente['email'];
        $cc     = $informacion_correo['principal'];
        $cc2    = $informacion_correo['copia'];
        $asunto = $informacion_correo['asunto'];

        $detalle_html = '';
        foreach ($detalle as $value) {
           
            $detalle_html.='
            <tr>
                    <td>'.$value->item.'</td>
                    <td>'.$value->nombre.'</td>
                    <td>'.$value->cantidad.'</td>
                    <td>$'.$value->total.'.-</td>
                  </tr>
            ';
        }

        $mensaje = '
       
        <html lang="es" dir="ltr">
          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=500, initial-scale=1">
            <title>Registro nuevo usuario Productor/Restaurante</title>
            <style media="screen">
              @font-face { font-family: "Titillium Web SemiBold"; src: url(fonts/TitilliumWeb-SemiBold.ttf); }
              @font-face { font-family: "Titillium Web Regular"; src: url(fonts/TitilliumWeb-Regular.ttf); }
              body{ background: #F7F7F7; font-size: 12px; padding: 0; margin: 0; }
              .contenido{ background: #FFF; width: 40%; margin: auto; padding: 5em; padding-left: 0px; padding-right: 0px; box-sizing: border-box; text-align: center; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 20px; padding-bottom: 8em; margin-bottom: 2em; min-width: 440px; }
              .cabecera{ width: 40%; margin: auto; padding-left: 0px; padding-right: 0px; box-sizing: border-box; text-align: center; border-radius: 20px; min-width: 440px; }
              .cabecera .columna{ width: 49%; display: inline-block; }
              .logo img{ max-width: 250px; }
              .contenido h2{ font-family: "Titillium Web SemiBold"; font-size: 3em; margin-top: .1em; margin-bottom: .1em; }
              .contenido p{ font-family: "Titillium Web Regular"; font-size: 1.5em; color: #424242; width: 90%; margin: auto; min-width: 370px; }
              .cabecera p{ font-family: "Titillium Web Regular"; font-size: 1.8em; color: #424242; width: 90%; text-align: right; margin: auto; min-width: 170px; }
              .contenido table{ font-family: "Titillium Web Regular"; font-size: 1.8em; color: #424242; width: 90%; margin: auto; min-width: 370px; }
              .contenido p a{ color: #BE1120; transition: 0.5s ease; -o-transition: 0.5s ease; -webkit-transition: 0.5s ease; }
              .contenido p a:hover{ opacity: .5; transition: 0.5s ease; -o-transition: 0.5s ease; -webkit-transition: 0.5s ease; } 
              .contenido p strong{ color: #2A244A; font-family: "Titillium Web SemiBold"; }
              .redes{ text-align: center; }
              .redes a{ margin: 0px 5px; transition: 0.5s ease; -o-transition: 0.5s ease; -webkit-transition: 0.5s ease; }
              .redes a:hover{ opacity: .5; transition: 0.5s ease; -o-transition: 0.5s ease; -webkit-transition: 0.5s ease; }
              .redes a img{ max-width: 40px; }
              .redes p{ font-family: "Titillium Web SemiBold"; color: #333333; font-size: 1.4em; margin-top: 0; letter-spacing: 1px; }
            </style>
          </head>
          <body>
            
            <div class="cabecera">
              <div class="columna">
                <div class="logo">
                  <a href="http://appnettech.cl" target="_blank">
                    <img src="http://appnettech.cl/appnettech/img/logo-black.png" alt="">
                  </a>
                </div>
              </div>
              <div class="columna">
                <div class="datos">
                  <p style="text-align:left; margin-bottom: 5px; padding-bottom: 5px; border-bottom:solid 1px #ccc;">RUT: 66666666-6</p>
                  <p style="text-align:left; margin-bottom: 5px; padding-bottom: 5px; border-bottom:solid 1px #ccc;">Razon social: DEMO</p>
                  <p style="text-align:left; margin-bottom: 5px; padding-bottom: 5px; border-bottom:solid 1px #ccc;">Direccion: VARAS Mena 980</p>
                  <p style="text-align:left; margin-bottom: 5px; padding-bottom: 5px; border-bottom:solid 1px #ccc;">Telefono: +569 123456789</p>
                </div>
              </div>
        
            </div>
            <div class="contenido">
              <h2>Hola! : '.$datos_cliente['name'].' </h2>
              <h2>'.$datos_cliente['rut'].' - '.$datos_cliente['razon_social'].'</h2>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
              <br>
             
              <br>
              <br>
              <table>
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  '. $detalle_html.'
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>$'.$venta->total_venta.'.-</th>
                  </tr>
                </tfoot>
              </table>
              <br>
             
            </div>
            <div class="redes">
             
              <p>Desarrollado por <a href="http://appnettech.cl" target="_blank">Appnet Technology Ltd.</a></p>
            </div>
          </body>
        </html>
        ';

        $estado = send_mail($email,$asunto,$mensaje,$cc,$cc2);
        
    } catch (\Throwable $th) {
        //throw $th;

    }
}

function datos_cliente($rut){
    $empresa = DB::table('empresas')->select()->where('rut',$rut)->first();
    $user = DB::table('users')->select()->where('id_empresa',$empresa->id)->first();

    $respuesta = [
        'rut' => $empresa->rut,
        'razon_social' => $empresa->razon_social,
        'name' => $user->name,
        'email' => $user->email,
    ];
    return $respuesta;
}

function informacion_correo(){
    $datos = DB::table('tokens')->select('token')->where('tipo','correo')->first()->token;
    $datos = (array)json_decode($datos);
    return $datos;
}


function send_mail($email,$asunto,$mensaje,$cc = null,$cc2 = null){
    
    $respuesta = false;
    try {

        $existe = DB::table('tokens')->select('token')->where('tipo','correo_configuracion')->first()->token;
        $json = json_decode($existe);

        $mail = new PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = $json->host;
        $mail->Port = $json->port;
        $mail->Username = $json->correo;
        $mail->Password = $json->password;
        $mail->setFrom($json->correo, "eCommerce");
        $mail->Subject = $asunto;
        $mail->isHTML(true);
        $mail->Body = $mensaje;
        $mail->addAddress($email, "Recipient Name");
        if($cc != null){ $mail->AddCC($cc, 'Copia 1'); }
        if($cc2 != null){ $mail->AddCC($cc2, 'Copia 2'); }
        
        $respuesta = $mail->send();
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

function get_api_key_firebase(){
    $firebase = DB::table('tokens')->select('token')->where('tipo','firebase')->first()->token;
    return $firebase;
}

function push_notification_android($device_id,$title,$message,$data){
    //API URL of FCM
    $url = 'https://fcm.googleapis.com/fcm/send';
    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
    
    $api_key = get_api_key_firebase();


    $fields = array (
        'to' => $device_id,
        'data' => array ("Json" => $data),
        'title' => $title,
        'body'  => $message,
        'mutable_content'  => true,
        'sound'  => "Tri-tone"
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
    return json_decode($result);
}


function push_notification_android2($device_id,$title,$message,$data){
    //API URL of FCM
    
    $URL = "https://fcm.googleapis.com/fcm/send";
    /*api_key available in:
    Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
    $api_key = 'AAAAJACnUx8:APA91bGfjtFr2bOpy5CpsXKqVoui84CxNbhwU_wrUrOBzNQtabGzPBknOPMsyzz4Z7Q-qlls9p1uJ3tluYrfVqiC0kP0AI8EKI4-X6zRb_-AgS2iaaZKyyju9J78FGbS4W4EBGci0z1a';

    $fields = array (
        'to' => $device_id,
        'data' => array ("Json" => $data),
        'title' => $title,
        'body'  => $message,
        'mutable_content'  => true,
        'sound'  => "Tri-tone"
    );

    $JSON = json_encode($fields);


    //header includes Content type and api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$api_key
    );


   

    $client = new \GuzzleHttp\Client();
    $response = $client->request('post', $URL, [
        'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'key='.$api_key
        ],
        'body' => $JSON                
        
    ]);
    $resultado = $response->getBody()->getContents();
    
    $resultado =json_decode($resultado);
}

function existe_producto($codigo){
    $existe = DB::table('productos')->select('id')->where('codigo',$codigo)->first();
    return ($existe == null) ? -1 : $existe->id;
}

function existe_registro_bodega($id){
    $existe = DB::table('bodegas')->select('id')->where('id',$id)->first();
    return ($existe == null) ?false : true;
}

function existe_registro_subfamilia($id){
    $existe = DB::table('sub_familias')->select('id')->where('id',$id)->first();
    return ($existe == null) ?false : true;
}

