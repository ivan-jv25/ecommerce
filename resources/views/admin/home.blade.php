@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
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
                            <button id="button2id" name="button2id" class="btn btn-success">Cambiar Datos</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<hr>

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
    var token = '{{csrf_token()}}';
    var URL_TEST_FLOW        = "{{ route('ajax.generar.pago.flow') }}";
    var URL_CARGA_DATOS_FLOW = "{{ route('ajax.carga.datos.flow') }}";
    var URL_GET_DATOS_FLOW   = "{{ route('ajax.get.datos.flow') }}";

    var URL_CARGA_CORREO   = "{{ route('ajax.carga.correo') }}";
    var URL_GET_CORREO   = "{{ route('ajax.get.correo') }}";

    $(document).ready(function(){
        get_datos_flow();
        get_correos();
    });
    
</script>
<script src="{{ asset('js/admin_panel_carga.js') }}"></script>



@endsection
