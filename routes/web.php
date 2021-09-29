<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () { return view('welcome'); })->name('welcome');
Route::get('/', 'IndexController@index')->name('welcome');
Route::post('Registro/Usuario/', 'IndexController@registro_usuario')->name('registro.usuario');

Auth::routes();


Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('Generar/Venta/', 'IndexController@genera_venta')->name('generar.venta');


    Route::group(['middleware' => 'admin'], function () {

        Route::get('Admin/Panel/Carga', function () { return view('admin.panel_carga');})->name('admin.panel.carga');
        Route::get('Admin/Panel/Ventas', function () { return view('admin.ventas');})->name('admin.ventas');


        Route::post('Ajax/Obtener/Token', 'IndexController@obtener_token')->name('ajax.obtener.token');
        Route::get('Ajax/Obtener/Carga', 'IndexController@carga_data_guardada')->name('ajax.obtener.carga');

        Route::get('Ajax/Obtener/Carga/Productos', 'IndexController@obtener_productos')->name('ajax.obtener.carga.productos');
        Route::get('Ajax/Obtener/Carga/Bodega', 'IndexController@obtener_bodega')->name('ajax.obtener.carga.bodega');
        Route::get('Ajax/Obtener/Carga/Sucursal', 'IndexController@obtener_sucursal')->name('ajax.obtener.carga.sucursal');
        Route::get('Ajax/Obtener/Carga/Familia', 'IndexController@obtener_familia')->name('ajax.obtener.carga.familia');
        Route::get('Ajax/Obtener/Carga/SubFamilia', 'IndexController@obtener_subfamilia')->name('ajax.obtener.carga.subfamilia');
        Route::get('Ajax/Obtener/Carga/Inventario', 'IndexController@obtener_inventario')->name('ajax.obtener.carga.inventario');



        Route::get('Ajax/Obtener/Lista/Ventas/Totales', 'IndexController@ajax_ventas_totales')->name('ajax.obtener.lista.ventas.totales');




        Route::get('Ajax/Obtener/Lista/Productos', 'IndexController@lista_productos')->name('ajax.lista.productos');
        Route::get('Ajax/Producto/Cambio/Favorito', 'IndexController@cambiar_favorito_producto')->name('ajax.producto.cambio.favorito');
        Route::get('Ajax/Producto/Cambio/Estado', 'IndexController@cambiar_estado_producto')->name('ajax.producto.cambio.estado');


        Route::get('Ajax/Obtener/Lista/SubFamilia', 'IndexController@lista_subfamilia')->name('ajax.lista.subfamilia');
        Route::get('Ajax/SubFamilia/Cambio/Estado', 'IndexController@cambiar_estado_subfamilia')->name('ajax.subfamilia.cambio.estado');


        Route::get('Ajax/Obtener/Lista/Bodega', 'IndexController@lista_bodega_panel')->name('ajax.lista.panel.bodega');
        Route::get('Ajax/Bodega/Cambio/Estado', 'IndexController@cambiar_estado_bodega')->name('ajax.bodega.cambio.estado');


        Route::post('Ajax/Carga/Correo', 'IndexController@carga_correo_aviso')->name('ajax.carga.correo');
        Route::get('Ajax/Get/Correo', 'IndexController@get_correo_aviso')->name('ajax.get.correo');



        /*TEST FLOW*/

        Route::post('Ajax/Carga/Datos/FLOW', 'IndexController@carga_datos_flow')->name('ajax.carga.datos.flow');
        Route::get('Ajax/Get/Datos/FLOW', 'IndexController@get_datos_flow')->name('ajax.get.datos.flow');

        Route::get('Ajax/Generar/Pago/FLOW', 'IndexController@pago_flow_test')->name('ajax.generar.pago.flow');
        Route::post('Ajax/Generar/Pago/FLOW/Confirmacion', 'IndexController@pago_flow_test_configuracion')->name('ajax.generar.pago.flow.confirmacion');
        Route::get('Ajax/Generar/Pago/FLOW/estado', 'IndexController@pago_flow_status_test')->name('ajax.generar.pago.flow.estado');


        


        
        
    });

});


Route::get('Ajax/Lista/Productos/Normal', 'IndexController@lista_producto_normal')->name('ajax.lista.productos.normal');
Route::get('Ajax/Lista/Productos/Favorito', 'IndexController@lista_producto_favorito')->name('ajax.lista.productos.favorito');
Route::get('Ajax/Lista/Bodega', 'IndexController@lista_bodega')->name('ajax.lista.bodega');
Route::get('Ajax/Lista/Inventario', 'IndexController@lista_inventario')->name('ajax.lista.inventario');
Route::get('Ajax/Obtener/Lista/Ventas/Cliente', 'IndexController@ajax_ventas_cliente')->name('ajax.obtener.lista.ventas.cliente');
Route::get('Ajax/Lista/Categoria', 'IndexController@lista_categoria')->name('ajax.lista.categoria');
Route::get('Ajax/Data/Venta', 'IndexController@datos_venta')->name('ajax.data.venta');

Route::get('Ajax/Generar/Pago/Estado', 'IndexController@estado_pago')->name('ajax.generar.pago.estado');

Route::get('Generar/PDF', 'IndexController@generar_pdf')->name('generar.pdf');


