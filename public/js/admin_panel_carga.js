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
            //document.getElementById('td_carga_lista_precio').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
            //document.getElementById('td_carga_formapago').innerHTML= '<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>';
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
                try {
                    document.getElementById(element.id).innerHTML= icono;    
                } catch (error) {
                    
                }
                
                
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

function lista_bodega(){
    let table2  = $('#table_panel_bodega').DataTable();
    table2.destroy();
    let table = $('#table_panel_bodega').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            url : URL_LISTA_BODEGA,
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
            { "data": "id" , name: 'bodegas.id'},
            { "data": "nombre" , name: 'bodegas.nombre'},
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

function cambiar_estado_bodega(id){

    $.ajax({
        url: URL_CAMBIO_BODEGA_ESTADO,
        data:{
            id:id
        },
        success: function(respuesta) {
            lista_bodega()
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });

}

function GenerarPago(){
    let correo     = document.getElementById('correo').value;
    let monto      = document.getElementById('monto').value;
    let comentario = document.getElementById('comentario').value;


    $.ajax({
        url: URL_TEST_FLOW,
        data:{
            correo:correo,
            monto:monto,
            comentario:comentario,
            _token:token,
        },
        success: function(respuesta) {
            console.log(respuesta);
            document.getElementById('form_test_flow').action = respuesta.url;
            document.getElementById('token_flow').value = respuesta.token;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
    
}


function carga_datos_flow(){
    let API_KEY_FLOW    = document.getElementById('API_KEY_FLOW').value;
    let SECRET_KEY_FLOW = document.getElementById('SECRET_KEY_FLOW').value;
    
    $.ajax({
        url: URL_CARGA_DATOS_FLOW,
        data:{
            API_KEY_FLOW:API_KEY_FLOW,
            SECRET_KEY_FLOW:SECRET_KEY_FLOW,
            _token:token,
        },
        type:  'post',
        success: function(respuesta) {
            get_datos_flow();
            
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
    
}


function get_datos_flow(){
    let return_grabar_flow     = false;
    let return_SECRET_KEY_FLOW = '';
    let return_API_KEY_FLOW    = '';
    $.ajax({
        url: URL_GET_DATOS_FLOW,
        success: function(respuesta) {
            if(respuesta.API_KEY_FLOW == '' || respuesta.SECRET_KEY_FLOW == '' ){
                return_grabar_flow     = false;
                return_SECRET_KEY_FLOW = '';
                return_API_KEY_FLOW    = '';
            }else{
                return_grabar_flow     = true;
                return_SECRET_KEY_FLOW = respuesta.SECRET_KEY_FLOW;
                return_API_KEY_FLOW    = respuesta.API_KEY_FLOW;
            }
            document.getElementById('API_KEY_FLOW').value   = return_API_KEY_FLOW;
            document.getElementById('SECRET_KEY_FLOW').value =return_SECRET_KEY_FLOW;
            document.getElementById("grabar_flow").disabled = return_grabar_flow;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}

function cambiar_datos_flow(){
    document.getElementById('API_KEY_FLOW').value   = '';
    document.getElementById('SECRET_KEY_FLOW').value = '';
    document.getElementById("grabar_flow").disabled = false;
}

function cargar_correos(){

    let array_boolean     = [ true, true, true ];

    let correo_principal = document.getElementById('correo_principal').value;
    let correo_copia = document.getElementById('correo_copia').value;
    let correo_asunto = document.getElementById('correo_asunto').value;


    if(correo_principal == ''){ array_boolean[0] = false; $("#correo_principal").addClass("is-invalid");}
	if(correo_copia == ''){     array_boolean[1] = false; $("#correo_copia").addClass("is-invalid"); }
	if(correo_asunto == ''){    array_boolean[2] = false; $("#correo_asunto").addClass("is-invalid"); }

    let is_enviar = array_boolean.every(CheckBoolean);

    if(is_enviar){

        let obj = { correo_principal: correo_principal,correo_copia: correo_copia,correo_asunto: correo_asunto,_token: token, };
    
        $.ajax({
            url: URL_CARGA_CORREO,
            data:obj,
            type:  'post',
            success: function(respuesta) {
                console.log(respuesta)
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });

    }
}

function get_correos(){
    $.ajax({
        url: URL_GET_CORREO,
        success: function(respuesta) {
            document.getElementById('correo_principal').value = respuesta.principal;
            document.getElementById('correo_copia').value = respuesta.copia;
            document.getElementById('correo_asunto').value = respuesta.asunto;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });   
}

function CheckBoolean(bool) { return bool == true; }
function clar_error(e){ $('#'+e.id).removeClass("is-invalid"); }

function mouseDown(){
    document.getElementById('email_password').type='text'
    document.getElementById('svg_eye').src = 'img/visibility_black_24dp.svg';
}

function mouseUp(){
    document.getElementById('email_password').type='password'
    document.getElementById('svg_eye').src = 'img/visibility_off_black_24dp.svg';
}

function guardar_configuracion_correo(){

    let array_boolean     = [ true, true, true, true ];

    let host = document.getElementById('email_host').value;
    let port = document.getElementById('email_port').value;
    let correo = document.getElementById('email_correo').value;
    let password = document.getElementById('email_password').value;

    if(host == ''){     array_boolean[0] = false; $("#email_host").addClass("is-invalid");}
	if(port == ''){     array_boolean[1] = false; $("#email_port").addClass("is-invalid"); }
	if(correo == ''){   array_boolean[2] = false; $("#email_correo").addClass("is-invalid"); }
    if(password == ''){ array_boolean[3] = false; $("#email_password").addClass("is-invalid"); }

    let is_enviar = array_boolean.every(CheckBoolean)

    if(is_enviar){

        let obj = { host: host, port: port, correo: correo, password: password, _token: token, };
        $.ajax({
            url: URL_CARGA_CONFIGURACION_CORREO,
            data:obj,
            type:  'post',
            success: function(respuesta) {
                console.log(respuesta)
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
    }
}

function get_correos(){
    $.ajax({
        url: URL_GET_CONFIGURACION_CORREO,
        success: function(respuesta) {
            document.getElementById('email_host').value = respuesta.host;
            document.getElementById('email_port').value = respuesta.port;
            document.getElementById('email_correo').value = respuesta.correo;
            document.getElementById('email_password').value = respuesta.password;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });   
}

function guardar_datos_empresa(){

    let array_boolean     = [ true, true, true, true ];

    let host = document.getElementById('email_host').value;
    let port = document.getElementById('email_port').value;
    let correo = document.getElementById('email_correo').value;
    let password = document.getElementById('email_password').value;

}