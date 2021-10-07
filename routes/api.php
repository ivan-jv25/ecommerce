<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) { return $request->user(); });


Route::post('Recibe/Integracion/Flow','API\IntegracionController@get_data_flow')->name('api.recibe.informacion.flow');

Route::post('Sincronizador/Notificacion','API\IntegracionController@sincronizar_firebase')->name('api.sincronizador.notificaciones');

Route::get('Consulta/Venta/{id}','API\IntegracionController@consulta_venta');
Route::get('Lista/Venta','API\IntegracionController@lista_venta');
Route::post('Estado/Venta','API\IntegracionController@cambio_estado_venta');