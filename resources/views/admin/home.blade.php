@extends('layouts.app')

@section('content')


<form action="{{ route('ajax.carga.datos.logo') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
@csrf
<div class="container">
  <div class="">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Cargar Logo</a>
        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Conexión Flow</a>
        <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Correo de Alertas</a>
        <a class="nav-link" id="nav-cuatro-tab" data-toggle="tab" href="#nav-cuatro" role="tab" aria-controls="nav-cuatro" aria-selected="false">Configuración de Correo</a>
        <a class="nav-link" id="nav-cinco-tab" data-toggle="tab" href="#nav-cinco" role="tab" aria-controls="nav-cinco" aria-selected="false">Datos de Empresa</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="card text-center">
            <div class="card-body">
                <div class="anti-row">
                  <div class="form-group">
                    <label class="control-label" for="filebutton">Selección de Logo</label>
                    <div class="col-12">
                        <input id="filebutton" name="filebutton" class="input-file" type="file" accept="image/x-png">
                    </div>
                  </div>
                  <img src="img/logo/logo.png" id="img1" class="logo" alt="Logo">
                </div>
            </div>
            <div class="card-footer">
              <button id="singlebutton" name="singlebutton" class="btn btn-success">Cargar Logo</button>
            </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="card text-center">
            <div class="card-body">
                <div class="form-group">
                    <label class="control-label" for="API_KEY_FLOW">API KEY</label>
                    <div class="">
                        <input id="API_KEY_FLOW" name="API_KEY_FLOW" type="text" placeholder="API_KEY_FLOW" class="form-control input-md">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="SECRET_KEY_FLOW">SECRET KEY</label>
                    <div class="">
                        <input id="SECRET_KEY_FLOW" name="SECRET_KEY_FLOW" type="text" placeholder="SECRET_KEY_FLOW" class="form-control input-md">
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <button onclick="carga_datos_flow()" id="grabar_flow" class="btn btn-success">Grabar</button>
              <button onclick="cambiar_datos_flow()" class="btn btn-secondary">Cambiar KEY</button>
            </div>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="card text-center">

            <div class="card-body">

                <div class="form-group" id="div_correo_principal">
                    <label class="control-label" for="correo_principal">Correo Principal</label>
                    <div class="">
                        <input id="correo_principal" name="correo_principal" type="email" placeholder="Correo Principal" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>
                <div class="form-group" id="div_correo_copia">
                    <label class="control-label" for="correo_copia">Correo Con Copia</label>
                    <div class="">
                        <input id="correo_copia" name="correo_copia" type="email" placeholder="Correo Copia" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group" id="div_correo_asunto">
                    <label class="control-label" for="correo_asunto">Asunto Correo</label>
                    <div class="">
                        <input id="correo_asunto" name="correo_asunto" type="text" placeholder="Asunto Correo" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

            </div>
            <div class="card-footer">
              <button id="button1id" onclick="cargar_correos();" class="btn btn-success">Grabar</button>
            </div>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-cuatro" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="card text-center">

            <div class="card-body">

                <div class="form-group" id="div_email_host">
                    <label class="control-label" for="email_host">Host</label>
                    <div class="">
                        <input id="email_host" type="email" placeholder="Host" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>
                <div class="form-group" id="div_email_port">
                    <label class="control-label" for="email_port">Port</label>
                    <div class="">
                        <input id="email_port" type="email" placeholder="Port" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group" id="div_email_correo">
                    <label class="control-label" for="email_correo">Correo</label>
                    <div class="">
                        <input id="email_correo" type="text" placeholder="Asunto Correo" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group" id="div_email_password">
                    <label class="control-label" for="email_password">Password</label>
                    <div class="inputojo">
                      <input id="email_password" class="form-control" placeholder="Contraseña" type="password" onchange="clar_error(this);">
                      <div class="ojo"  onmousedown="mouseDown()" onmouseup="mouseUp()"><img src="img/visibility_off_black_24dp.svg" id="svg_eye" class="ico-ingresa" ></div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
              <button id="button1id" onclick="guardar_configuracion_correo();" class="btn btn-success">Grabar</button>
            </div>
        </div>


      </div>

      <div class="tab-pane fade" id="nav-cinco" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="card text-center">

            <div class="card-body">
                <div class="form-group">
                    <label class="control-label" for="nombre_empresa">Nombre Empresa</label>
                    <div class="">
                        <input id="nombre_empresa" type="text" placeholder="Nombre Empresa" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="direccion">Direccion</label>
                    <div class="">
                        <input id="direccion" type="text" placeholder="Direccion" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="ciudad">Ciudad</label>
                    <div class="">
                        <input id="ciudad" type="text" placeholder="Ciudad" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="comuna">Comuna</label>
                    <div class="">
                        <input id="comuna" type="text" placeholder="Comuna" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="telefono">Telefono</label>
                    <div class="">
                        <input id="telefono" type="text" placeholder="Telefono" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="correo">Correo</label>
                    <div class="">
                        <input id="correo"  type="email" placeholder="Correo" class="form-control input-md" onchange="clar_error(this);">
                    </div>
                </div>

            </div>
            <div class="card-footer">
              <button  class="btn btn-success" onclick="guardar_datos_empresa();">Grabar</button>
            </div>
        </div>

      </div>

    </div>
  </div>

</div>
</form>



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
        $("li a").removeClass("active");
        $("#inicio").addClass("active");
    });



</script>

<script src="{{ asset('js/admin_panel_carga.js') }}"></script>



@endsection
