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