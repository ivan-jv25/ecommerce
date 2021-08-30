@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Obtener Token de Conexion</div>

                <div class="card-body">
                    <div class="col-md-12">

                        <div class="form-inline">
                            <div class="form-group">
                                <label for="rut_empresa">Empresa</label>
                                <input type="text" class="form-control" id="rut_empresa" placeholder="Appnet Limitada" onchange="formato_rut();">
                            </div>
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input type="text" class="form-control" id="username" placeholder="Usuario">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="Contraseña">
                            </div>
                            <button type="submit" class="btn btn-default" onclick="obtener_token();">Send invitation</button>
                        </div>
                    </div>
                    <div class="col-md-12">

                       
                            <div class="row form-group">
                                <label for="rut_empresa">Token</label>
                                <input type="text" class="form-control" id="token" readonly  placeholder="Token Secreto">
                            </div>
                            
                       
                    </div>
                    

                   
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cargar Datos </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Seccion</th>
                                <th>Carga</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Productos</td>
                                <td><a onclick="carga_productos()" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_producto"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Sucursal</td>
                                <td><a onclick="carga_sucursal()" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_sucursal"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Bodegas</td>
                                <td><a onclick="carga_bodega()" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_bodega"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Inventario</td>
                                <td><a onclick="carga_inventario();" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_inventario"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Familias</td>
                                <td><a onclick="carga_familia()" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_familia"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Sub Familias</td>
                                <td><a onclick="carga_subfamilia()" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_subfamilia"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Lista de Precio</td>
                                <td><a href="#" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_lista_precio"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>
                            <tr>
                                <td>Forma de Pago</td>
                                <td><a href="#" class="btn btn-primary">Cargar Datos</a></td>
                                <td id="td_carga_formapago"></td>
                                <td><a class="btn btn-primary">Gestion</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                   

               
                   
                </div>
            </div>
        </div>
    </div>
</div>





    
<script src="{{ asset('js/obtenerToken.js') }}"></script>
<script src="{{ asset('js/admin_panel_carga.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
var URL_TOKEN             = "{{ route('ajax.obtener.token') }}";
var URL_CARGA             = "{{ route('ajax.obtener.carga') }}";
var URL_CARGA_PRODUCTOS   = "{{ route('ajax.obtener.carga.productos') }}";
var URL_CARGA_BODEGA      = "{{ route('ajax.obtener.carga.bodega') }}";
var URL_CARGA_SUCURSAL    = "{{ route('ajax.obtener.carga.sucursal') }}";
var URL_CARGA_FAMILIA     = "{{ route('ajax.obtener.carga.familia') }}";
var URL_CARGA_SUBFAMILIA  = "{{ route('ajax.obtener.carga.subfamilia') }}";
var URL_CARGA_INVENTARIO  = "{{ route('ajax.obtener.carga.inventario') }}";
var token                 = '{{csrf_token()}}';

$(document).ready(function(){
    carga_inicial();
    
    
});




</script>



@endsection
