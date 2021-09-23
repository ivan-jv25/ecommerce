function ventas_totales(){

    let tipo_venta =  document.getElementById('tipo_venta').value;
    let tipo_recepcion =  document.getElementById('tipo_recepcion').value;
    let desde =  document.getElementById('desde').value;
    let hasta =  document.getElementById('hasta').value;
    
    let table2  = $('#example').DataTable();
    table2.destroy();
    let table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_VENTAS_TOTALES,
            data:{
                "tipo_venta"  : tipo_venta,
                "tipo_recepcion"  : tipo_recepcion,
                "desde"   : desde,
                "hasta"   : hasta,
            }
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
            { "data": "tipo_documento", name: 'documento.nombre'},
            { "data": "forma_pago", name: 'ventas.forma_pago'},
            { "data": "created_at", name: 'ventas.created_at'},
            {"data": 'accion', name: 'accion', orderable: false, searchable: false}
        ]
    });

}