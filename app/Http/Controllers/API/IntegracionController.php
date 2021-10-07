<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class IntegracionController extends Controller
{
    public function get_data_flow(Request $request){

        $contenido = (string)$request->getContent();
        
        $token = str_replace("token=","",$contenido);
        $venta_flow = DB::table('venta_flows')->select('id','id_venta','token')->where('token',$token)->first();
        
        
        $estado_flow = $this->pago_flow_status($token);
        $log_pago = json_encode($estado_flow);
        
        
        $respuesta = DB::table('venta_flows')->where('id', $venta_flow->id)->update(['estado' => $estado_flow->status,'log_pago' => $log_pago]);

        if($estado_flow->status == 2){
            $tiene_folio = $this->tiene_folio($venta_flow->id_venta);

            if($tiene_folio == -1){
                return "no procesar";
            }elseif($tiene_folio == 1){
                $json = generar_formato_venta($venta_flow->id_venta);
                $respuesta =  WEB_SERVICE_VENTA($json);
                
                DB::table('ventas')->where('id', $venta_flow->id_venta)->update(['folio' => $respuesta->numVenta]);

                envio_correo($venta_flow->id_venta);


                try {
                    $device_id = "f7cUz7sJXYM:APA91bEUacKEJAJ4heV3kKx_XF1lREAk31MpjKpzhoF8P8G8cdVkCzi_AR78pwedcEd1602jJrU5G1HsBhVStq_M-NEF5nrsUXuVMpt20s_NEEWjifIGFe8Z3vy0yhjTjdZUtqDhtuzH";
                    $title = 'Prueba';
                    $message = 'Algun mensaje';
        
                    $json      = (object)[
                        'url' => 'www.google.cl',
                        'dl'   => $venta_flow->id_venta,
                    ];
        
                    $json = json_encode($json);
                    $data = $json;

                    push_notification_android2($device_id,$title,$message,$data);

                } catch (\Throwable $th) {
                    //throw $th;
                    
                }

            }
        }
        return "termina el proceso";
    }

    public function sincronizar_firebase(Request $request){
        $datos   = $request->json()->all();
        $respuesta = false;
        $reglas = [
            'id_bodega' => 'required|integer',
            'firebase'  => 'required',
        ];
        $valido = $this->ValidarArray($datos,$reglas);
        if(is_array($valido)){
            return $this->Respuesta($valido);
        }
        try {
            $datos         = (object)$datos;
            $existe = $this->existe_id_bodega($datos->id_bodega);
        
            if($existe){
                DB::table('firebase')->where('id_bodega', $datos->id_bodega)->update(['token' =>  $datos->firebase]);
            }else{
                DB::table('firebase')->insert( ['id_bodega' => $datos->id_bodega, 'token' => $datos->firebase] );
            }

            $respuesta = true;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $this->Respuesta($respuesta);
    }

    public function consulta_venta(Request $request, int $id){

        $token   = $request->header('token');
        $id_venta = $id;
        $firebase = $this->valida_token($token);
        if (is_null($firebase)) { return $this->Respuesta('Token Invalido'); }

        $direccion = null;

        $venta     = DB::table('ventas')->select('id', 'rut', 'folio', 'id_direccion', 'tipo_entrega', 'descuento', 'neto', 'neto_exento', 'iva', 'total_venta', 'tipo_documento', 'forma_pago', 'id_bodega', 'estado_pago', 'id_formapago', 'codigo_pago', 'created_at','observacion')->where('id',$id_venta)->first();
        $detalle   = DB::table('detalle_ventas')->select('id', 'id_venta', 'item', 'codigo_producto', 'nombre', 'cantidad', 'valor_producto', 'total', 'valor_descuento',)->where('id_venta',$id_venta)->get();

        if($venta->id_direccion != 0){
            $direccion = DB::table('direccions')->select()->where('id',$venta->id_direccion)->first();
        }

        $respuesta = [
            'Venta'=>$venta,
            'Detalle'=>$detalle,
            'Direccion'=>$direccion,
        ];

        return $respuesta;
    }

    public function lista_venta(Request $request){

        $token   = $request->header('token');
        $firebase = $this->valida_token($token);
        if (is_null($firebase)) { return $this->Respuesta('Token Invalido'); }
        
        $id_bodega = $firebase->id_bodega;
        $libro = DB::table('ventas')->join('documento','documento.tipo','=','ventas.tipo_documento')->select('ventas.id','ventas.rut','ventas.folio','ventas.id_direccion','ventas.tipo_entrega','ventas.descuento','ventas.neto','ventas.neto_exento','ventas.iva','ventas.total_venta','documento.nombre as tipo_documento','ventas.forma_pago','ventas.id_bodega','ventas.estado_pago','ventas.id_formapago','ventas.codigo_pago','ventas.created_at','ventas.updated_at')->where('ventas.folio','!=',0)->where('ventas.estado_entrega','=',0)->where('ventas.id_bodega','=',$id_bodega)->get();

        return $libro;
    }

    public function cambio_estado_venta(Request $request){
        $token   = $request->header('token');
        $firebase = $this->valida_token($token);
        if (is_null($firebase)) { return $this->Respuesta('Token Invalido'); }
        $datos   = $request->json()->all();
        $respuesta = false;
        $reglas = [
            'id_venta' => 'required|integer',
            'estado'   => 'required|integer',
        ];
        $valido = $this->ValidarArray($datos,$reglas);
        if(is_array($valido)){
            return $this->Respuesta($valido);
        }

        try {
            $datos = (object)$datos;
            DB::table('ventas')->where('id', $datos->id_venta)->update(['estado_entrega' => $datos->estado]);
            $respuesta = true;
        } catch (\Throwable $th) { /*throw $th;*/ }


        return $this->Respuesta($respuesta);
    }

    private function pago_flow_status($token){
        $datos = [
            'apiKey' => API_KEY_FLOW(),
            'token'  => $token,
        ];
        
        $respuesta = FLOW_PAY_STATUS($datos);
        return $respuesta;
    }

    private function tiene_folio($id_venta){

        $venta = DB::table('ventas')->select('folio')->where('id',$id_venta)->first();
        if($venta == null){return -1;}
        return ($venta->folio == 0) ? 1 : 0;
    }

    /**
     * Validador de un array deacuerdo a un listado de reglas
     * @param Array $array
     * @param Array $reglas
     * @return Bollean TRUE de estar correcto ó @return ArrayList de los parametros que no estan segun sus reglas
     */
    private function ValidarArray($array,$reglas){
        $respuesta = [];
        try {
            $valido = Validator::make($array,$reglas);

            if($valido->fails()){
                $validador = $valido->errors()->messages();
                $count = 0;
                foreach ($validador as $key => $value) {
                    $respuesta['error'][$count] = $value[0];
                    $count++;
                }
            }else{
                $respuesta = true;
            }

        } catch (\Throwable $th) {
            //throw $th;
            $respuesta['error'] ="Error";
        }
        return $respuesta;
    }

    /**
     * Metodo para enviar respuestas centralizadas
     * @param T $mensjae, este Valor puede ser de cualquier tipo
     */
    private function Respuesta($mensaje){
        $respuesta['Respuesta'] = $mensaje;
        return response()->json($respuesta);
    }

    private function existe_id_bodega(int $id_bodega){
        $existe = DB::table('firebase')->select('id')->where('id_bodega',$id_bodega)->first();
        return ($existe != null) ? true : false;
    }

    private function valida_token($token){
        if (is_null($token)) { return $token; }
        $existe = DB::table('firebase')->select('id_bodega')->where('token',$token)->first();
        return $existe;
    }
}
