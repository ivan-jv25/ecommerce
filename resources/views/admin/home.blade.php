@extends('layouts.app')

@section('content')


<form action="{{ route('ajax.carga.datos.logo') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
@csrf
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cargar Logo eCommerce</div>

                <div class="card-body">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-6 control-label" for="filebutton">Seleccion de Logo</label>
                            <div class="col-md-6">
                                <input id="filebutton" name="filebutton" class="input-file" type="file" accept="image/x-png">
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-md-4">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Cargar Logo</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="img/logo.png" id="img1" class="logo" alt="Logo Appnet" style="max-width: 50%;">
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
</form>
<hr>

<div class="container">
    <div class="row justify-content">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">CONEXION FLOW</div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="API_KEY_FLOW">API_KEY_FLOW</label>  
                        <div class="col-md-12">
                            <input id="API_KEY_FLOW" name="API_KEY_FLOW" type="text" placeholder="API_KEY_FLOW" class="form-control input-md">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="SECRET_KEY_FLOW">SECRET_KEY_FLOW</label>  
                        <div class="col-md-12">
                            <input id="SECRET_KEY_FLOW" name="SECRET_KEY_FLOW" type="text" placeholder="SECRET_KEY_FLOW" class="form-control input-md">
                        </div>
                    </div>
                   
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="button1id"></label>
                        <div class="col-md-8">
                            <button onclick="carga_datos_flow()" id="grabar_flow" class="btn btn-primary">Grabar</button>
                            <button onclick="cambiar_datos_flow()" class="btn btn-success">Cambiar KEY</button>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Correo Destino Alerta</div>

                <div class="card-body">
                    
                    <div class="form-group" id="div_correo_principal">
                        <label class="col-md-4 control-label" for="correo_principal">Correo Principal</label>  
                        <div class="col-md-8">
                            <input id="correo_principal" name="correo_principal" type="email" placeholder="Correo Principal" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>
                    <div class="form-group" id="div_correo_copia">
                        <label class="col-md-4 control-label" for="correo_copia">Correo Con Copia</label>  
                        <div class="col-md-8">
                            <input id="correo_copia" name="correo_copia" type="email" placeholder="Correo Copia" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group" id="div_correo_asunto">
                        <label class="col-md-4 control-label" for="correo_asunto">Asunto Correo</label>  
                        <div class="col-md-8">
                            <input id="correo_asunto" name="correo_asunto" type="text" placeholder="Asunto Correo" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="button1id"></label>
                        <div class="col-md-8">
                            <button id="button1id" onclick="cargar_correos();" class="btn btn-primary">Grabar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
    </div>
</div>



<hr>


<div class="container">
    <div class="row justify-content">
     
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Configuracion Correo</div>

                <div class="card-body">
                    
                    <div class="form-group" id="div_email_host">
                        <label class="col-md-4 control-label" for="email_host">Host</label>  
                        <div class="col-md-8">
                            <input id="email_host" type="email" placeholder="Host" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>
                    <div class="form-group" id="div_email_port">
                        <label class="col-md-4 control-label" for="email_port">Port</label>  
                        <div class="col-md-8">
                            <input id="email_port" type="email" placeholder="Port" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group" id="div_email_correo">
                        <label class="col-md-4 control-label" for="email_correo">Correo</label>  
                        <div class="col-md-8">
                            <input id="email_correo" type="text" placeholder="Asunto Correo" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group" id="div_email_password">
                        <label class="col-md-4 control-label" for="email_password">Password</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="email_password" class="form-control" placeholder="Contraseña" type="password" onchange="clar_error(this);">
                                <div class="input-group-text"  onmousedown="mouseDown()" onmouseup="mouseUp()"><img src="img/visibility_off_black_24dp.svg" id="svg_eye" class="ico-ingresa" ></div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="button1id"></label>
                        <div class="col-md-8">
                            <button id="button1id" onclick="guardar_configuracion_correo();" class="btn btn-primary">Grabar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Datos Empresa</div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="nombre_empresa">Nombre Empresa</label>  
                        <div class="col-md-8">
                            <input id="nombre_empresa" type="text" placeholder="Nombre Empresa" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="direccion">Direccion</label>  
                        <div class="col-md-8">
                            <input id="direccion" type="text" placeholder="Direccion" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="ciudad">Ciudad</label>  
                        <div class="col-md-8">
                            <input id="ciudad" type="text" placeholder="Ciudad" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="comuna">Comuna</label>  
                        <div class="col-md-8">
                            <input id="comuna" type="text" placeholder="Comuna" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="telefono">Telefono</label>  
                        <div class="col-md-8">
                            <input id="telefono" type="text" placeholder="Telefono" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="correo">Correo</label>  
                        <div class="col-md-8">
                            <input id="correo"  type="email" placeholder="Correo" class="form-control input-md" onchange="clar_error(this);">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button  class="btn btn-primary" onclick="guardar_datos_empresa();">Grabar</button>
                        </div>
                    </div>
                    
                    

                </div>
            </div>
        </div>

        
    </div>
</div>



<div class="container" hidden>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var token                          = '{{csrf_token()}}';
    var URL_TEST_FLOW                  = "{{ route('ajax.generar.pago.flow') }}";
    var URL_CARGA_DATOS_FLOW           = "{{ route('ajax.carga.datos.flow') }}";
    var URL_GET_DATOS_FLOW             = "{{ route('ajax.get.datos.flow') }}";
    var URL_CARGA_CORREO               = "{{ route('ajax.carga.correo') }}";
    var URL_GET_CORREO                 = "{{ route('ajax.get.correo') }}";
    var URL_CARGA_CONFIGURACION_CORREO = "{{ route('ajax.configuracion.carga.correo') }}";
    var URL_GET_CONFIGURACION_CORREO   = "{{ route('ajax.get.correo.configuracion') }}";
    var URL_CARGA_DATOS_EMPRESA        = "{{ route('ajax.carga.datos.empresa') }}";
    var URL_GET_DATOS_EMPRESA          = "{{ route('ajax.obtener.empresa') }}";

    $(document).ready(function(){
        get_datos_flow();
        get_correos();
        get_correos_configuracion();
        get_datos_empresa();
    });

    function init() {
        var inputFile = document.getElementById('filebutton');
        inputFile.addEventListener('change', mostrarImagen, false);
    }
    function mostrarImagen(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(event) {
            var img = document.getElementById('img1');
            img.src= event.target.result;
        }
        reader.readAsDataURL(file);
    }
    window.addEventListener('load', init, false);
    
</script>
<script src="{{ asset('js/admin_panel_carga.js') }}"></script>



@endsection
