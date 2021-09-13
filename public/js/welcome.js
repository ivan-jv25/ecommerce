var lista_productos  = null;
var lista_carro      = [];
var lista_inventario = null;

var neto  = 0;
var IVA   = 0;
var Total = 0;

var aux_index = null;
var KEY = 'ecommerce.lista';

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
        success: function(respuesta) {
            lista_productos = respuesta;
            mostrar_lista_producto(respuesta);
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
            mostrar_bodegas(respuesta);
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

function mostrar_lista_producto(lista){
    let lista_productos = '';
    for (let i = 0; i < lista.length; i++) {
        const element = lista[i];

        lista_productos +='<div class="prod">'+
        '<img class="thumb" src="img/productos/t2lite.png" alt="">'+
        '<div class="detal">'+
        '<h5>'+element.nombre.substring(0,30)+'</h5>'+
        '<div class="nuevo" onclick="add_producto_simple('+i+');">en Stock</div>'+
        '</div>'+
        '<div class="mas" onclick="add_producto_simple('+i+');" ><i class="fa fa-plus fa-lg"></i></div>'+
        '<div class="precio">$'+element.precio_venta+'</div>'+
        '</div>';   
    }
    
    document.getElementById('lista_col2').innerHTML= lista_productos;
}

function add_producto_simple(index){
    let producto    = lista_productos[index];
    let obj_detalle = { codigo : producto.codigo, nombre : producto.nombre, precio : producto.precio_venta, cantidad : 1, total : producto.precio_venta, ID_CATEGORIA: producto.id_familia };
    add_carrito(obj_detalle);
}

function add_carrito(producto){
    if(existe_producto(producto)){
        let index = aux_index;
        lista_carro[index].cantidad ++;
        lista_carro[index].total = lista_carro[index].cantidad * lista_carro[index].precio;
    }else{
        lista_carro.push(producto);
    }

    toastr.info("Producto :"+producto.nombre+". Agregado ", '', {timeOut: 1000})
    document.getElementById('dv_carrito').innerHTML= lista_carro.length;
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

    if(lista_carro.length >= 1){
        document.getElementById("singlebutton").disabled = false;
    }else{
        document.getElementById("singlebutton").disabled = true;
    }
    

    for (let i = 0; i < lista_carro.length; i++) {
        const element = lista_carro[i];
        lista +='<tr>'+
            '<td>'+
                '<img class="thumb" src="img/productos/d2scombo.png" alt="">'+
                '<span>'+element.nombre.substring(0,30)+'</span>'+
            '</td>'+
            '<td>'+
                '<div class="menos"><i class="fa fa-minus fa-lg" onclick="disminuir_cantidad('+i+')"></i></div>'+
                element.cantidad+
                '<div class="mas"><i class="fa fa-plus fa-lg" onclick="aumenta_cantidad('+i+')"></i></div>'+
            '</td>'+
            '<td>$'+element.total+'</td>'+
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
}

function lista_carrito_bodega(){
    let id_bodega          = document.getElementById('id_tienda_retiro').value;
    let lista_carro_bodega = '';
    let lista_todo_bien = [];
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
        alert("Tienes Productos Sin el Stock Suficiente.");
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
            let lista = "<option value=''>Seleccionar Categorias</option>";
            for (let i = 0; i < categoria.length; i++) {
                const element = categoria[i];
                lista += "<option value=" + element.id + ">"+element.id+" " + element.nombre + "</option>";
            }
            document.getElementById('lista_categoria').innerHTML = lista;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function filtro_categoria(id) {
    let array_aux = lista_productos.filter(producto => producto.id_familia == id);
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

    let table2  = $('#example').DataTable();
    table2.destroy();
    let table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_COMPRAS,
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
