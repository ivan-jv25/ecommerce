@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">TEST FLOW</div>

                <div class="card-body">

                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="correo">correo</label>  
                        <div class="col-md-4">
                            <input id="correo" name="correo" type="text" placeholder="correo" class="form-control input-md">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="monto">monto</label>  
                        <div class="col-md-4">
                            <input id="monto" name="monto" type="text" placeholder="monto" class="form-control input-md">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label" for="comentario">comentario</label>  
                        <div class="col-md-4">
                            <input id="comentario" name="comentario" type="text" placeholder="comentario" class="form-control input-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button class="btn btn-primary" onclick="GenerarPago()">Generar URL</button>
                        </div>
                    </div>
                   
                </div>


            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">FLOW</div>

                <div class="card-body">
                <form id="form_test_flow">
                    <input type="text" name="token" id="token_flow" class="form-control">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Button</button>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="container">
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
    var URL_TEST_FLOW = "{{ route('ajax.generar.pago.flow') }}";
</script>
<script src="{{ asset('js/admin_panel_carga.js') }}"></script>

@endsection
