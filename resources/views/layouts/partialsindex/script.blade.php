
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>




<link src="{{ asset('datatable/dataTables.bootstrap4.css') }}"></link>
<link src="{{ asset('datatable/buttons.bootstrap4.css') }}"></link>
<link src="{{ asset('datatable/responsive.bootstrap4.css') }}"></link>
<script src="{{ asset('datatable/jszip.js') }}"></script>
<script src="{{ asset('datatable/pdfmake.js') }}"></script>
<script src="{{ asset('datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('datatable/dataTables.bootstrap4.js') }}"></script>


<script src="{{ asset('datatable/dataTables.buttons.js') }}"></script>
<script src="{{ asset('datatable/buttons.bootstrap4.js') }}"></script>
<script src="{{ asset('datatable/buttons.colVis.js') }}"></script>
<script src="{{ asset('datatable/buttons.html5.js') }}"></script>
<script src="{{ asset('datatable/buttons.print.js') }}"></script>
<script src="{{ asset('datatable/dataTables.responsive.js') }}"></script>
<script src="{{ asset('datatable/responsive.bootstrap4.js') }}"></script>

<script type="text/javascript">
$( "#cerrar-menu" ).click(function() { $("#menu").hide("slide", { direction: "right" }, 200); });
$( ".hamburguesa" ).click(function() { $("#menu").show("slide", { direction: "right" }, 200); });
$( ".ico-carro" ).click(function() { $(".seccion-02").fadeIn(); });
$( ".cerrar-carro" ).click(function() { $(".seccion-02").fadeOut(); });
$( "#cerrar-popup" ).click(function() { $(".pop-up").fadeOut(); });
$( "#abre-qr" ).click(function() { $(".pop-up").fadeIn(); });
$(".mas").click(function() { alert('agrega en carro'); });
$(".fa-trash").click(function() { alert('eliminar de carro'); });
function cerrar_menu(){$("#menu").hide("slide", { direction: "right" }, 200); }

var URL_PRODUCTOS_SIMPLE   = '{{ route('ajax.lista.productos.normal') }}';
var URL_PRODUCTOS_FAVORITO = '{{ route('ajax.lista.productos.favorito') }}';
var URL_CATEGORIA          = '{{ route('ajax.lista.categoria') }}';
var URL_BODEGA             = '{{ route('ajax.lista.bodega') }}';
var URL_INVENTARIO         = '{{ route('ajax.lista.inventario') }}';
var URL_COMPRAS            = '{{ route('ajax.obtener.lista.ventas.cliente') }}';
var URL_DATA_VENTA         = '{{ route('ajax.data.venta') }}';
var URL_ESTADO_PAGO        = '{{ route('ajax.generar.pago.estado') }}';
var URL_LISTA_DIRECCION    = '{{ route('ajax.lista.direccion') }}';
var URL_GUARDAR_DIRECCION  = '{{ route('ajax.guardar.direccion') }}';
var URL_GET_DATOS_EMPRESA  = '{{ route('ajax.obtener.empresa') }}';
var id_bodega_defecto      = parseInt('{{ obtener_id_bodega_defecto() }}');
var TokenVenta             = '{{ $TokenVenta }}';
var pagado                 = '{{ $pagado }}';
var token                  = '{{csrf_token()}}';
var is_auth                = @if (Auth::check()) true @else false @endif ;
    

$(document).ready(function(){
  get_storage();
  //carga_bodega2();
  get_inventario();
  get_categorias();
  carga_productos_favorito();
  carga_productos();
  

  if(TokenVenta == '0'){
    carga_bodega();
  }

 
  
  if(TokenVenta != '0'){
    get_datos_empresa();
    cargar_datos_venta();
  }
});
</script>

<script src="{{ asset('js/welcome.js') }}"></script>
<script src="{{ asset('js/lenguaje_datatable.js') }}"></script>