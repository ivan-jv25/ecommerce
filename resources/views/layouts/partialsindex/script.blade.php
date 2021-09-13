
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>


<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>




<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap4.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.css"/>
 

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



<script type="text/javascript">
$( "#cerrar-menu" ).click(function() {
  $("#menu").hide("slide", { direction: "right" }, 200);
});
$( ".hamburguesa" ).click(function() {
  $("#menu").show("slide", { direction: "right" }, 200);
});
$( ".ico-carro" ).click(function() {
  $(".seccion-02").fadeIn();
});
$( ".cerrar-carro" ).click(function() {
  $(".seccion-02").fadeOut();
});
$( "#cerrar-popup" ).click(function() {
  $(".pop-up").fadeOut();
});
$( "#abre-qr" ).click(function() {
  $(".pop-up").fadeIn();
});
$(".mas").click(function() {
  alert('agrega en carro');
});
$(".fa-trash").click(function() {
  alert('eliminar de carro');
});

function cerrar_menu(){
  $("#menu").hide("slide", { direction: "right" }, 200);
}

var URL_PRODUCTOS_SIMPLE = '{{ route('ajax.lista.productos.normal') }}';
var URL_PRODUCTOS_FAVORITO = '{{ route('ajax.lista.productos.favorito') }}';
var URL_CATEGORIA        = '{{ route('ajax.lista.categoria') }}';
var URL_BODEGA           = '{{ route('ajax.lista.bodega') }}';
var URL_INVENTARIO       = '{{ route('ajax.lista.inventario') }}';
var URL_COMPRAS          = '{{ route('ajax.obtener.lista.ventas.cliente') }}';
var id_bodega_defecto    = parseInt('{{ obtener_id_bodega_defecto() }}');

$(document).ready(function(){
  carga_productos();
  get_storage();
  get_inventario();
  get_categorias();
  carga_productos_favorito();
});
</script>

<script src="{{ asset('js/welcome.js') }}"></script>
<script src="{{ asset('js/lenguaje_datatable.js') }}"></script>

