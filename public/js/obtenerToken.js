function formato_rut(){
    rut = document.getElementById("rut_empresa").value;            
    res = true;
    let n = 0;
    let n2 = 0;
    let n3 = 0;
    while(res){
        if (n!=-1){rut = rut.replace(".", "");}
        if (n2 !=-1) {rut = rut.replace(" ", "");}
        if (n3 != -1) {rut = rut.replace("-", "");}
            
        n = rut.indexOf(".");
        n2 = rut.indexOf(" ");
        n3 = rut.indexOf("-");

        if (n == -1 && n2 == -1 && n3 == -1){
            res     = false;
            largo   = rut.length;
            dv      = rut.substr(largo-1, 1);
            aux_rut = rut.substring(0, largo-1);
            rut     = aux_rut+"-"+dv;
        }
    };
    document.getElementById("rut_empresa").value = rut;            
}


function obtener_token(){
    let rut_empresa = document.getElementById('rut_empresa').value;
    let username    = document.getElementById('username').value;
    let password    = document.getElementById('password').value;

    let obj = { _token : token, rut_empresa : rut_empresa, username : username, password : password, };
    $.ajax({
        url: URL_TOKEN, 
        data:obj, 
        type:  'post',
        success: function(respuesta) {
            document.getElementById('token').value = respuesta.Token;
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });

}

