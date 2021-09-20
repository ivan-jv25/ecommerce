<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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

            }
        }
        return "termina el proceso";
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
}
