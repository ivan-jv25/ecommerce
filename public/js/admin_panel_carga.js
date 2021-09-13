function carga_inicial(){
    let icono = '';
    $.ajax({
        url: URL_CARGA, 
        beforeSend: function() {            
            document.getElementById('td_carga_producto').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_sucursal').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_bodega').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_inventario').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_familia').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_lista_precio').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            document.getElementById('td_carga_formapago').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            console.log(respuesta);
            let Carga = respuesta.Carga;
            document.getElementById('token').value       = respuesta.Token;
            document.getElementById('rut_empresa').value = respuesta.Credenciales.empresa;
            document.getElementById('password').value    = respuesta.Credenciales.password;
            document.getElementById('username').value    = respuesta.Credenciales.username;

            for (let i = 0; i < Carga.length; i++) {
                const element = Carga[i];

                if(element.Estado == true){
                    icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
                }else if(element.Estado == false){
                    icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
                }else{
                    icono = '<span class="material-icons"style="color: orange;font-size: 2rem;">error</span>'
                }
                document.getElementById(element.id).innerHTML= icono;
                
            }

            

           
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_productos(){
    $.ajax({
        url: URL_CARGA_PRODUCTOS, 
        beforeSend: function() {
            document.getElementById('td_carga_producto').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            console.log(respuesta);
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }

            document.getElementById('td_carga_producto').innerHTML= icono;  
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_bodega(){

    $.ajax({
        url: URL_CARGA_BODEGA,
        beforeSend: function() {
            document.getElementById('td_carga_bodega').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }
            document.getElementById('td_carga_bodega').innerHTML= icono;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_sucursal(){

    $.ajax({
        url: URL_CARGA_SUCURSAL,
        beforeSend: function() {
            document.getElementById('td_carga_sucursal').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }
            document.getElementById('td_carga_sucursal').innerHTML= icono;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_familia(){

    $.ajax({
        url: URL_CARGA_FAMILIA,
        beforeSend: function() {
            document.getElementById('td_carga_familia').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }
            document.getElementById('td_carga_familia').innerHTML= icono;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function carga_subfamilia(){

    $.ajax({
        url: URL_CARGA_SUBFAMILIA,
        beforeSend: function() {
            document.getElementById('td_carga_subfamilia').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }
            document.getElementById('td_carga_subfamilia').innerHTML= icono;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}


function carga_inventario(){

    $.ajax({
        url: URL_CARGA_INVENTARIO,
        beforeSend: function() {
            document.getElementById('td_carga_inventario').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
        },
        success: function(respuesta) {
            let icono = '';
            if(respuesta.Estado == true){
                icono = '<span class="material-icons" style="color: green;font-size: 2rem;">check_circle_outline</span>';
            }else{
                icono = '<span class="material-icons" style="color: red;font-size: 2rem;">highlight_off</span>';
            }
            document.getElementById('td_carga_inventario').innerHTML= icono;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function lista_productos(){
    let table2  = $('#table_panel_producto').DataTable();
    table2.destroy();
    let table = $('#table_panel_producto').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_LISTA_PRODUCTOS,
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
            { "data": "id" , name: 'productos.id'},
            { "data": "nombre" , name: 'productos.nombre'},
            { "data": "codigo", name: 'productos.codigo'},
            { "data": "precio_venta", name: 'productos.precio_venta'},
            { "data": "subfamilia", name: 'sub_familias.nombre'},
            {"data": 'favorito', name: 'favorito', orderable: false, searchable: false},
            {"data": 'estado', name: 'estado', orderable: false, searchable: false}
        ]
    });
}


function lista_subfamilia(){
    let table2  = $('#table_panel_subfamilia').DataTable();
    table2.destroy();
    let table = $('#table_panel_subfamilia').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_LISTA_SUBFAMILIA,
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
            { "data": "id" , name: 'sub_familias.id'},
            { "data": "nombre" , name: 'sub_familias.nombre'},
            {"data": 'estado', name: 'estado', orderable: false, searchable: false}
        ]
    });
}



function cambiar_favorito_producto(id){

    $.ajax({
        url: URL_CAMBIO_PRODUCTOS_FAVORITO,
        data:{
            id:id
        },
        success: function(respuesta) {
            lista_productos()
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });

}

function cambiar_estado_producto(id){

    $.ajax({
        url: URL_CAMBIO_PRODUCTOS_ESTADO,
        data:{
            id:id
        },
        success: function(respuesta) {
            lista_productos()
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });

}


function cambiar_estado_subfamilia(id){

    $.ajax({
        url: URL_CAMBIO_SUBFAMILIA_ESTADO,
        data:{
            id:id
        },
        success: function(respuesta) {
            lista_subfamilia()
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });

}