@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Listado de Ventas</div>

                <div class="card-body">


                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Folio</th>
                                    <th>Resepcion</th>
                                    <th>Descuento</th>
                                    <th>Afecto</th>
                                    <th>Exento</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Documento</th>
                                    <th>Forma Pago</th>
                                    <th>Fecha</th>
                                
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
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


<script>

    var URL_VENTAS_TOTALES = "{{ route('ajax.obtener.lista.ventas.totales') }}";
    $(document).ready(function() {
        ventas_totales();
    } );

    function ventas_totales(){
        
        let table2  = $('#example').DataTable();
        table2.destroy();
        let table = $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                url : URL_VENTAS_TOTALES,
            },
            "initComplete": function() {
                var $searchInput = $('div.dataTables_filter input');
                $searchInput.unbind();
				$searchInput.bind('keyup', function(e) {
					if(this.value.length >= 3 || this.value.length == 0) {
						table.search( this.value ).draw();
					}
				});
			},
            "language": lenguaje_datatable,
            "columns":[
                { "data": "rut" , name: 'ventas.rut'},
                { "data": "folio", name: 'ventas.folio'},
                { "data": "tipo_entrega", name: 'ventas.tipo_entrega'},
                { "data": "descuento", name: 'ventas.descuento'},
                { "data": "neto", name: 'ventas.neto'},
                { "data": "neto_exento", name: 'ventas.neto_exento'},
                { "data": "iva", name: 'ventas.iva'},
                { "data": "total_venta", name: 'ventas.total_venta'},
                { "data": "tipo_documento", name: 'ventas.tipo_documento'},
                { "data": "forma_pago", name: 'ventas.forma_pago'},
                { "data": "created_at", name: 'ventas.created_at'}
            ]
        });

    }
</script>

@endsection
