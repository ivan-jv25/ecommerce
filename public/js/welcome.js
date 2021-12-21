var lista_productos          = null;
var lista_productos_favorito = null
var lista_carro              = [];
var lista_inventario         = null;
var lista_bodega             = [];

var datos_empresa = null;

var neto  = 0;
var IVA   = 0;
var Total = 0;

var aux_index = null;
var KEY = 'ecommerce.lista';
document.getElementById('id_bodega').value = id_bodega_defecto;
const formulario = document.querySelector('#formulario');

const filtrar = () =>{
    let new_array = [];
    const texto = formulario.value.toLocaleLowerCase();
    for (let producto of lista_productos) {
        let nombre = producto.nombre.toLocaleLowerCase();
        if(nombre.indexOf(texto) !== -1){ new_array.push(producto); }
    }
    mostrar_lista_producto(new_array);
}

formulario.addEventListener("keyup", filtrar);


function carga_productos(){
    $.ajax({
        url: URL_PRODUCTOS_SIMPLE,
        data:{
            id:id_bodega_defecto,
        },
        success: function(respuesta) {
            lista_productos = respuesta;
            mostrar_lista_producto(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_productos_favorito(){
    $.ajax({
        url: URL_PRODUCTOS_FAVORITO,
        success: function(respuesta) {
            lista_productos_favorito = respuesta;
            if(lista_productos_favorito.length != 0){
                $("body").removeClass("unacol");
                mostrar_lista_producto_favorito(respuesta);
            }

        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_bodega(){
    $.ajax({
        url: URL_BODEGA,
        success: function(respuesta) {
            lista_bodega = respuesta;
            mostrar_bodegas(respuesta);
            mostrar_bodegas2();
            seleccion_bodega(lista_bodega)
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_bodega2(){
    $.ajax({
        url: URL_BODEGA,
        success: function(respuesta) {
            lista_bodega = respuesta;
            mostrar_bodegas2(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function mostrar_bodegas(bodegas){
    let lista = '<option value="">Seleccione una Tienda</option>';
    for (let i = 0; i < bodegas.length; i++) {
        const element = bodegas[i];
        let selected = (element.id == id_bodega_defecto) ? 'selected' : '';
        lista +='<option value="'+element.id+'" '+selected+'>'+element.nombre+'</option>';

    }
    document.getElementById('id_tienda_retiro').innerHTML= lista;

}

function mostrar_bodegas2(){
    let lista = '<option value="">Seleccione una Tienda</option>';
    for (let i = 0; i < lista_bodega.length; i++) {
        const element = lista_bodega[i];
        let selected = (element.id == id_bodega_defecto) ? 'selected' : '';
        lista +='<option value="'+element.id+'" '+selected+'>'+element.nombre+'</option>';

    }
    document.getElementById('id_tienda_retiro2').innerHTML= lista;

}

function mostrar_lista_producto(lista){
    let lista_productos = '';
    for (let i = 0; i < lista.length; i++) {
        const element = lista[i];
        let imagen = (element.imagen == 'Sin Imagen') ? 'img/no-imagen.png' : element.imagen;

        lista_productos +='<div class="prod">'+
        '<div class="zoom">zoom</div>'+
        '<img class="thumb" async  src="'+imagen+'" onclick="AbreProd('+i+',false)" alt="" onError="this.onerror=null;this.src=`img/no-imagen.png`;">'+
        '<div class="detal">'+
        '<h5 title="'+element.nombre+'">'+element.nombre.substring(0,30)+'</h5>'+
        '<p class="lead" title="'+element.codigo+'">Código: '+element.codigo.substring(0,10)+'</p>'+
        '<div class="nuevo" onclick="add_producto_simple(`'+element.codigo+'`);">en Stock</div>'+
        '</div>'+
        '<div class="mas" onclick="add_producto_simple(`'+element.codigo+'`);" ><i class="fa fa-plus fa-lg"></i></div>'+
        '<div class="precio">$'+formatonumero(element.precio_venta)+'</div>'+
        '</div>';
    }

    document.getElementById('lista_col2').innerHTML= lista_productos;
}
function mostrar_lista_producto_favorito(lista){
    let lista_productos = '';
    for (let i = 0; i < lista.length; i++) {
        const element = lista[i];
        let imagen = (element.imagen == 'Sin Imagen') ? 'img/no-imagen.png' : element.imagen;

        lista_productos +='<div class="prod">'+
        '<div class="zoom">zoom</div>'+
        '<img class="thumb" async  src="'+imagen+'" onclick="AbreProd('+i+',true)"  alt="" onError="this.onerror=null;this.src=`img/no-imagen.png`;">'+
        '<div class="detal">'+
        '<h5 title="'+element.nombre+'">'+element.nombre.substring(0,30)+'</h5>'+
        '<p class="lead" title="'+element.codigo+'">Código: '+element.codigo.substring(0,10)+'</p>'+
        '<div class="nuevo" onclick="add_producto_favorito(`'+element.codigo+'`);">en Stock</div>'+
        '</div>'+
        '<div class="mas" onclick="add_producto_favorito(`'+element.codigo+'`);" ><i class="fa fa-plus fa-lg"></i></div>'+
        '<div class="precio">$'+formatonumero(element.precio_venta)+'</div>'+
        '</div>';
    }

    document.getElementById('lista_col1').innerHTML= lista_productos;
}

function add_producto_simple(codigo){
    let producto    = obtener_producto_simple(codigo);
    let obj_detalle = { codigo : producto.codigo, nombre : producto.nombre, precio : producto.precio_venta, cantidad : 1, total : producto.precio_venta, ID_CATEGORIA: producto.id_familia,imagen: producto.imagen };
    add_carrito(obj_detalle);
}

function add_producto_simpleModal(){
    let codigo = document.getElementById('Modal_CodigoProd').innerHTML;
    let producto    = obtener_producto_simple(codigo);
    let obj_detalle = { codigo : producto.codigo, nombre : producto.nombre, precio : producto.precio_venta, cantidad : 1, total : producto.precio_venta, ID_CATEGORIA: producto.id_familia,imagen: producto.imagen };
    add_carrito(obj_detalle);
}

function add_producto_favoritoModal(){
    let codigo = document.getElementById('Modal_CodigoProd').innerHTML;
    let producto    = obtener_producto_simple(codigo);
    let obj_detalle = { codigo : producto.codigo, nombre : producto.nombre, precio : producto.precio_venta, cantidad : 1, total : producto.precio_venta, ID_CATEGORIA: producto.id_familia,imagen: producto.imagen };
    add_carrito(obj_detalle);
}

function add_producto_favorito(codigo){
    let producto    = obtener_producto_favorito(codigo);
    let obj_detalle = { codigo : producto.codigo, nombre : producto.nombre, precio : producto.precio_venta, cantidad : 1, total : producto.precio_venta, ID_CATEGORIA: producto.id_familia,imagen: producto.imagen };
    add_carrito(obj_detalle);
}

function obtener_producto_simple(codigo){
    let producto = lista_productos.filter(producto => producto.codigo == codigo);
    return producto[0];
}
function obtener_producto_favorito(codigo){
    let producto = lista_productos_favorito.filter(producto => producto.codigo == codigo);
    return producto[0];
}

function add_carrito(producto){
    if(existe_producto(producto)){
        let index = aux_index;
        lista_carro[index].cantidad ++;
        lista_carro[index].total = lista_carro[index].cantidad * lista_carro[index].precio;
    }else{
        lista_carro.unshift(producto);
    }

    toastr.info("Producto :"+producto.nombre+". Agregado ", '', {timeOut: 1000})
    mostrar_lista_carro();
    calculo_monto();
}

function existe_producto(producto){
    for (let i = 0; i < lista_carro.length; i++) {
        const element = lista_carro[i];
        if (element.codigo == producto.codigo) {
            aux_index = i;
            return true;
        }
    }
    return false;
}

function mostrar_lista_carro(){
    let lista = '';
    let lista_data = '';

    if(lista_carro.length > 0){
        document.getElementById("singlebutton").disabled = false;
    }else{
        document.getElementById("singlebutton").disabled = true;
    }


    for (let i = 0; i < lista_carro.length; i++) {

        const element = lista_carro[i];
        let imagen = (element.imagen == 'Sin Imagen') ? 'img/no-imagen.png' : element.imagen;
        lista +='<tr>'+
            '<td>'+
                '<img class="thumb" async  src="'+imagen+'"  alt="" onError="this.onerror=null;this.src=`img/no-imagen.png`;">'+
                '<span>'+element.nombre.substring(0,30)+'</span>'+
            '</td>'+
            '<td>'+
                '<div class="menos"><i class="fa fa-minus fa-lg" onclick="disminuir_cantidad('+i+')"></i></div>'+
                element.cantidad+
                '<div class="mas"><i class="fa fa-plus fa-lg" onclick="aumenta_cantidad('+i+')"></i></div>'+
            '</td>'+
            '<td>$'+formatonumero(element.total)+'</td>'+
            '<td><i class="fa fa-trash fa-lg" onclick="elimina_item('+i+')"></i></td>'+
            '</tr>';
            lista_data +='<tr>'+
            '<td><input type="text" name="item[]"  value="'+(i+1)+'"></td>'+
            '<td><input type="text" name="codigo[]"  value="'+element.codigo+'"></td>'+
            '<td><input type="text" name="cantidad[]"  value="'+element.cantidad+'"></td>'+
            '<td><input type="text" name="precio_unitario[]" value="'+element.precio+'"></td>'+
            '<td><input type="text" name="precio_total[]" value="'+element.total+'"></td>'+
            '</tr>';
    }
    set_storage();
    document.getElementById('tb_lista_carro').innerHTML = lista;
    document.getElementById('tb_lista_carro_datos').innerHTML = lista_data;

    document.getElementById('dv_carrito').innerHTML= lista_carro.length;

    lista_carrito_bodega2(false)
}

function lista_carrito_bodega(){
    let id_bodega          = document.getElementById('id_bodega').value;
    let lista_carro_bodega = '';
    let lista_todo_bien = [];
    if(lista_carro.length == 0){ lista_todo_bien.push(false); }
    for (let i = 0; i < lista_carro.length; i++) {
        const element = lista_carro[i];
        let stock = get_stock_by_codigo(element.codigo,id_bodega);
        let aviso = (element.cantidad > stock) ? 'class="danger"' : 'class="success"';
        if(element.cantidad > stock){
            lista_todo_bien.push(false);
        }else{
            lista_todo_bien.push(true);
        }
        lista_carro_bodega+='<tr '+aviso+'><td><span>'+element.nombre+'</span></td><td>'+element.cantidad+'</td><td id="td_'+element.codigo+'">'+stock+'</td></tr>';
    }

    document.getElementById('lista_carro_bodega').innerHTML = lista_carro_bodega;
    let dato = lista_todo_bien.filter(estado => estado==false);
    if(dato.length >0){
        document.getElementById("singlebutton").disabled = true;
        alert("Tienes Productos Sin el Stock Suficiente.");
    }else{
        document.getElementById("singlebutton").disabled = false;
    }
}

function lista_carrito_bodega2(conmensaje = true){
    let id_bodega          = document.getElementById('id_bodega').value;
    let lista_todo_bien = [];
    if(lista_carro.length == 0){ lista_todo_bien.push(false); }
    for (let i = 0; i < lista_carro.length; i++) {
        const element = lista_carro[i];

        if(element.cantidad > get_stock_by_codigo(element.codigo,id_bodega)){
            lista_todo_bien.push(false);
        }else{
            lista_todo_bien.push(true);
        }
    }
    let dato = lista_todo_bien.filter(estado => estado==false);
    if(dato.length >0){
        document.getElementById("singlebutton").disabled = true;
        if(conmensaje){
            alert("Tienes Productos Sin el Stock Suficiente.");
        }

    }else{
        document.getElementById("singlebutton").disabled = false;
    }
}

function elimina_item(index){
    lista_carro.splice(index,1);
    mostrar_lista_carro();
    calculo_monto();
}

function aumenta_cantidad(index){
    lista_carro[index].cantidad ++;
    lista_carro[index].total = lista_carro[index].cantidad * lista_carro[index].precio;
    mostrar_lista_carro();
    calculo_monto();
}

function disminuir_cantidad(index){
    if(lista_carro[index].cantidad > 1){
        lista_carro[index].cantidad --;
        lista_carro[index].total = lista_carro[index].cantidad * lista_carro[index].precio;
        mostrar_lista_carro();
        calculo_monto();
    }
}

function calculo_monto(){
    let aux_neto  = 0;
    let aux_iva   = 0;
    let aux_total = 0;
    for (let i = 0; i < lista_carro.length; i++) {
        const element = lista_carro[i];
        aux_total+=element.total
    }

    aux_neto  = aux_total/1.19;
    aux_neto  = parseInt(parseFloat(aux_neto).toFixed(0));
    aux_iva   = (aux_neto * 0.19);
    aux_iva   = parseInt(parseFloat(aux_iva).toFixed(0));
    aux_total = aux_neto + aux_iva;
    aux_total = redondeo(aux_total)

    neto  = aux_neto;
    iva   = aux_iva;
    total = aux_total;

    document.getElementById('id_neto').value  = neto;
    document.getElementById('id_iva').value   = iva;
    document.getElementById('id_total').value = total;
}

function redondeo(numero){
    n = numero/10;
    n = Math.round(n);
    n = n*10;
    return n;
}

function set_storage(){
    localStorage.setItem(KEY, JSON.stringify(lista_carro))
}

function get_storage(){
    lista_carro = JSON.parse(localStorage.getItem(KEY));
    lista_carro = (lista_carro == null) ? [] : lista_carro;
    mostrar_lista_carro();
    calculo_monto();
}

function clear_storage(){
    localStorage.removeItem(KEY);
}

function get_inventario(){
    let id_bodega = document.getElementById('id_tienda_retiro').value;
    $.ajax({
        url: URL_INVENTARIO,
        data:{
            id_bodega:id_bodega
        },
        success: function(respuesta) {
            lista_inventario = respuesta;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function get_stock_by_codigo(codigo,id_bodega){
    try {
        let dato = lista_inventario.filter(producto => producto.id_producto == codigo && producto.id_bodega == id_bodega)[0];
        return dato.stock;
    } catch (error) {
        return 0;
    }

}

function get_categorias(){
    $.ajax({
        url: URL_CATEGORIA,
        success: function(respuesta) {
            let categoria = respuesta
            let lista = "<option value=''>Todas las categorías</option>";
            for (let i = 0; i < categoria.length; i++) {
                const element = categoria[i];
                lista += "<option value=" + element.id + ">"+ element.nombre + "</option>";
            }
            document.getElementById('lista_categoria').innerHTML = lista;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function filtro_categoria(id) {
    let id_categoria = parseInt(id);
    let array_aux = lista_productos;
    if(!isNaN(id_categoria)){
        array_aux = lista_productos.filter(producto => producto.id_familia == id_categoria);
    }
    mostrar_lista_producto(array_aux);
}


function work_flow_retiro(){
    carga_bodega();

    lista_carrito_bodega();
}

function work_flow_change_bodega(){
    lista_carrito_bodega();
}


function lista_compra(){
    let desde =  document.getElementById('desde').value;
    let hasta =  document.getElementById('hasta').value;
    let table2  = $('#example').DataTable();
    table2.destroy();
    let table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_COMPRAS,
            data:{
                desde   : desde,
                hasta   : hasta,
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
            { "data": "total_venta", name: 'ventas.total_venta'},
            { "data": "tipo_documento", name: 'ventas.tipo_documento'},
            { "data": "forma_pago", name: 'ventas.forma_pago'},
            { "data": "created_at", name: 'ventas.created_at'},
            {"data": 'accion', name: 'accion', orderable: false, searchable: false},
            {"data": 'comprar', name: 'comprar', orderable: false, searchable: false}
        ]
    });
}


function cargar_datos_venta(){
    $.ajax({
        url: URL_DATA_VENTA,
        data:{
            TokenVenta:TokenVenta
        },
        success: function(respuesta) {
            if(pagado != 0){
                switch (respuesta.Pago.Flow.estado) {
                    case 1:
                        //pendiente de pago
                        cargar_estado_venta_triple();
                        break;
                    case 2:
                        cargar_estado_venta(respuesta);
                        break;
                    case 3:
                        //rechazada
                        cargar_estado_venta_triple();
                        break;
                    case 4:
                        //anulada
                        cargar_estado_venta_triple();
                        break;

                    default:
                        break;
                }

                clear_storage();
                lista_carro      = []
                mostrar_lista_carro();
            }else{
                $("#myModalPago").modal()
                document.getElementById('form_test_flow').action = respuesta.Pago.Flow.url;
                document.getElementById('token_flow').value = respuesta.Pago.Flow.token;
                document.getElementById('btn_pago').firstChild.textContent = 'ir a Pagar : $'+respuesta.Venta.total_venta+'.-';
            }
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}


function cargar_estado_venta(datos){
    let Detalle   = datos.Detalle
    let Direccion = datos.Direccion
    let Cliente  = datos.Cliente

    let lista_compra = '';
    $("#myModalEstadoPago").modal()

    for (let i = 0; i < Detalle.length; i++) {
        const element = Detalle[i];
        lista_compra += '<tr>'+
            '<td>'+element.item+'</td>'+
            '<td>'+element.nombre+'</td>'+
            '<td>'+formatonumero(element.cantidad)+'</td>'+
            '<td>$'+formatonumero(element.total)+'</td>'+
        '</tr>';
    }

    let fecha = datos.Venta.created_at.substr(0,10);

    let informacion_cliente = '<strong>'+Cliente.razon_social+'</strong><br>'+Cliente.direccion+'<br>'+Cliente.ciudad+','+Cliente.comuna+'<br>'+'Email: '+Cliente.correo;
    informacion_cliente = informacion_cliente.toUpperCase();

    let informacion_empresa = '<strong>'+datos_empresa.nombre+'</strong><br>'+datos_empresa.direccion+'<br>'+datos_empresa.ciudad+','+datos_empresa.comuna+'<br>'+'Telefono:'+datos_empresa.telefono+'<br>'+'Email: '+datos_empresa.correo;
    informacion_empresa = informacion_empresa.toUpperCase();


    document.getElementById('lista_compra').innerHTML      = lista_compra;
    document.getElementById('dv_fecha').innerHTML          = fecha;
    document.getElementById('id_invoice').innerHTML        = "#"+datos.Venta.id;
    document.getElementById('id_flowOrder').innerHTML      = datos.Pago.Flow.flowOrder;
    document.getElementById('td_neto').innerHTML           = "$"+formatonumero(datos.Venta.neto);
    document.getElementById('td_iva').innerHTML            = "$"+formatonumero(datos.Venta.iva);
    document.getElementById('td_total').innerHTML          = "$"+formatonumero(datos.Venta.total_venta);
    document.getElementById('add_datos_cliente').innerHTML = informacion_cliente;
    document.getElementById('add_datos_empresa').innerHTML = informacion_empresa;
    document.getElementById('id_nombre_empresa').innerHTML = datos_empresa.nombre;
    document.getElementById('id_observacion').innerHTML    = datos.Venta.observacion;

    try { document.getElementById('id_direccion_pago').innerHTML = Direccion.direccion+' ,'+Direccion.ciudad+' ,'+Direccion.comuna; } catch (error) { }

}

function cargar_estado_venta_triple(){
  $("#myModalEstadoPagoTriple").modal()
}


function formatonumero(numero){
    let newnumber = new Intl.NumberFormat("CLP").format(numero);
    let valida    = 0;
    let respuesta = true;
    do {
        if (valida >= -1) {
            respuesta = false;
            newnumber = newnumber.replace(",",".");
        }
        newnumber = newnumber.replace(",",".");
        valida    = newnumber.search(",");
    }while(respuesta);
    return newnumber;
}

function seleccion_bodega(lista){
    let largo_lista =  lista.length;
    if(largo_lista > 1){
        mostrar_bodegas2();
        $("#myModalBodegaDefecto").modal();
    }
}

function bodega_defecto(){

    id_bodega_defecto = document.getElementById('id_tienda_retiro2').value;
    document.getElementById('id_bodega').value = id_bodega_defecto;
    carga_productos();
    lista_carrito_bodega2();
}

function bodega_defecto2(){

    id_bodega_defecto = document.getElementById('id_tienda_retiro').value;
    document.getElementById('id_bodega').value = id_bodega_defecto;
    carga_productos()
}


function guardar_direccion(){
    let direccion   = document.getElementById('direccion').value;
    let ciudad      = document.getElementById('ciudad').value;
    let comuna      = document.getElementById('comuna').value;
    let observacion = document.getElementById('observacion').value;

    let array_boolean     = [ true, true, true ];

    if(direccion == ''){ array_boolean[0] = false; }
    if(ciudad == ''){    array_boolean[1] = false; }
    if(comuna == ''){    array_boolean[2] = false; }

    let is_enviar = array_boolean.every(CheckBoolean);

    if(is_enviar){

        let obj ={ direccion : direccion, ciudad : ciudad, comuna : comuna, observacion : observacion, _token : token };

        $.ajax({
            url: URL_GUARDAR_DIRECCION,
            data:obj,
            type:  'post',
            success: function(respuesta) {

                document.getElementById('direccion').value   = '';
                document.getElementById('ciudad').value      = '';
                document.getElementById('comuna').value      = '';
                document.getElementById('observacion').value = '';

                seleccion_direccion(respuesta.id);

                lista_direccion();

            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });

    }

}

function seleccion_direccion(id){
    document.getElementById('id_direccion').value = id;
    toastr.info("Direccion de Despacho Seleccionada", '', {timeOut: 1000})
}

function quitar_direccion_despacho(){
    document.getElementById('id_direccion').value = 0;
    toastr.info("Modo Retiro en Tienda", '', {timeOut: 1000})
}

function lista_direccion(){

    let table2  = $('#lista_direccion').DataTable();
    table2.destroy();
    let table = $('#lista_direccion').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_LISTA_DIRECCION,
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
            { "data": "id" , name: 'direccions.id'},
            { "data": "direccion", name: 'direccions.direccion'},
            { "data": "ciudad", name: 'direccions.ciudad'},
            { "data": "comuna", name: 'direccions.comuna'},
            {"data": 'accion', name: 'accion', orderable: false, searchable: false}
        ]
    });
}

function CheckBoolean(bool) { return bool == true; }

function get_datos_empresa(){
    $.ajax({
        url: URL_GET_DATOS_EMPRESA,
        success: function(respuesta) {
            datos_empresa = respuesta;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function abrir_login(){
    cerrar_todo()
    let respuesta = false;
    if(!is_auth){
        $("#menu").show("slide", { direction: "right" }, 200);
        $("#collapseOne").addClass("in");
        document.getElementById('collapseOne').setAttribute("aria-expanded", true)
    }else{
        respuesta = true;
    }
    return respuesta;
}

function comprar_denuevo(TokenVenta){
    $.ajax({
        url: URL_DATA_VENTA,
        data:{
            TokenVenta:TokenVenta
        },
        success: function(respuesta) {
            let Detalle = respuesta.Detalle;
            for (let i = 0; i < Detalle.length; i++) {
                const element = Detalle[i];
                try {
                    let producto = buscar_producto(element.codigo_producto);
                    let obj_detalle = { codigo : element.codigo_producto, nombre : element.nombre, precio : element.valor_producto, cantidad : element.cantidad, total : element.total, ID_CATEGORIA: producto.id_familia,imagen: producto.imagen };
                    add_carrito(obj_detalle);
                } catch (error) {
                    toastr.info("Producto :"+element.nombre+". No Existe en Esta Tienda ", '', {timeOut: 500})
                }

            }

            lista_carrito_bodega2();
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function buscar_producto(codigo) {
    return lista_productos.filter(producto => producto.codigo == codigo)[0];
}

function abrir_registrarte(){
    cerrar_todo()
    $("#menu").show("slide", { direction: "right" }, 200);
    $("#collapseTwo").addClass("in");
    document.getElementById('collapseTwo').setAttribute("aria-expanded", true)
}

function cerrar_todo(){
    $("#collapseOne").removeClass("in");
    document.getElementById('collapseOne').setAttribute("aria-expanded", false)

    $("#collapseTwo").removeClass("in");
    document.getElementById('collapseTwo').setAttribute("aria-expanded", false)

    try {
        if(window.screen.width <= 1024){
            $(".seccion-02").fadeOut();
        }

    } catch (error) {}
}

function imgError(){
    console.log("hola");
}

function AbreProd(index,lista){

  $("#ModalProd").modal();

  let producto = null;

  if (lista== true) {
    producto = lista_productos_favorito[index]
    document.getElementById('btn_prod_simple').style.display = 'none'
    document.getElementById('btn_prod_favorito').style.display = ''
  }else {
    producto = lista_productos[index]
    document.getElementById('btn_prod_simple').style.display = ''
  document.getElementById('btn_prod_favorito').style.display = 'none'
  }

  document.getElementById("Modal_NombreProd").innerHTML = producto.nombre;
  document.getElementById("Modal_PrecioProd").innerHTML = "$"+formatonumero(producto.precio_venta);
  document.getElementById("Modal_ImgProd").src = (producto.imagen == 'Sin Imagen') ? 'img/no-imagen.png' : producto.imagen;
  document.getElementById("Modal_CodigoProd").innerHTML = producto.codigo;

  document.getElementById("Modal_Descripcion").innerHTML = producto.descripcion;

}
