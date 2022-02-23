<div class="modal fade modales" id="myModalEntrega" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Seleccione forma de entrega</h4>
            </div>
            <div class="modal-body">

              <form class="" action="" method="">
                <p>¿Cómo prefiere recibir sus productos?</p>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="EntregaRetiro" value="option1" checked>
                  <label class="form-check-label" for="exampleRadios1">
                    Retiro en tienda <strong>(Nombre Sucursal)</strong>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="EntregaDespacho" value="option2">
                  <label class="form-check-label" for="exampleRadios2">
                    Despacho
                  </label>
                </div>
                <a href="#" onClick="document.location.reload(true)" id="cambiaSucursal">Cambiar de sucursal</a>
                <hr>
                <div class="" id="contenidoDespacho">
                  <p>Seleccione su dirección de despacho</p>
                  <select class="form-control" name="">
                    <option value="direccionderegistro">Walker Martinez #555, San Miguel, Santiago, Región Metropolitana</option>
                    <option value="direccionderegistro">Calle #555, Mostazal, Región Libertador Bernardo O'higgins</option>
                  </select>
                  <a href="#" id="agregarDireccion">Agregar una nueva dirección</a>
                  <br>
                  <hr>
                  <p>Aceptar términos y condiciones de despacho</p>
                  <div class="infox">Valor despacho $5.000</div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                    <label class="form-check-label" for="defaultCheck1">
                      Acepto los términos y condiciones
                    </label>
                  </div>
                  <hr>
                </div>

                <button class="siguiente" type="submit" id="entregaSiguiente">Siguiente</button>

              </form>

            </div>

        </div>
    </div>
</div>
