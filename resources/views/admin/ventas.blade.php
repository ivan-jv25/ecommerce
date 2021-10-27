@extends('layouts.app')
@section('content')
<div class="container">
    <div class="anti-row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Listado de Ventas
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sel1">Desde :</label>
                            <input id="desde" name="desde" type="date" class="form-control input-md" value="{{getPrimerUltimoFecha()['primero']}}" onchange="ventas_totales();">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sel1">Hasta :</label>
                            <input id="hasta" name="hasta" type="date" class="form-control input-md" value="{{getPrimerUltimoFecha()['ultimo']}}" onchange="ventas_totales();">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sel1">Tipo de Ventas :</label>
                            <select class="form-control" id="tipo_venta" name="tipo_venta" onchange="ventas_totales();">
                                <option value = "1">Constituida</option>
                                <option value = "2">No Constituida</option>
                                <option value = "3">Todas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="sel1">Tipo de Recepción :</label>
                            <select class="form-control" id="tipo_recepcion" name="tipo_recepcion" onchange="ventas_totales();">
                                <option value = "3">Todas</option>
                                <option value = "1">Retiro</option>
                                <option value = "2">Despacho</option>
                            </select>
                        </div>
                    </div>
                  </div>



                </div>
            </div>


        </div>
    </div>
</div>

<section class="panel-vta">
  <table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Cliente</th>
        <th>Folio</th>
        <th>Recepción</th>
        <th>Dscto</th>
        <th>Afecto</th>
        <th>Exento</th>
        <th>IVA</th>
        <th>Total</th>
        <th>Dcto</th>
        <th>Forma Pago</th>
        <th>Fecha</th>
        <th>Acción</th>
      </tr>
    </thead>
  </table>
</section>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.css"/>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.js"></script>

<script src="{{ asset('js/lenguaje_datatable.js') }}"></script>
<script src="{{ asset('js/admin_venta.blade.js') }}"></script>


<script>

    var URL_VENTAS_TOTALES = "{{ route('ajax.obtener.lista.ventas.totales') }}";
    $(document).ready(function() {
        ventas_totales();
        $("li a").removeClass("active");
        $("#ventas").addClass("active");
    } );



</script>

@endsection
