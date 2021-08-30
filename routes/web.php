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

Route::get('/', function () {
    return view('welcome');
});

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


        
        
    });

});


Route::get('Ajax/Lista/Productos/Normal', 'IndexController@lista_producto_normal')->name('ajax.lista.productos.normal');
Route::get('Ajax/Lista/Bodega', 'IndexController@lista_bodega')->name('ajax.lista.bodega');
Route::get('Ajax/Lista/Inventario', 'IndexController@lista_inventario')->name('ajax.lista.inventario');
Route::get('Ajax/Obtener/Lista/Ventas/Cliente', 'IndexController@ajax_ventas_cliente')->name('ajax.obtener.lista.ventas.cliente');


