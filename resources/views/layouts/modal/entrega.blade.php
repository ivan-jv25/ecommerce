<div class="modal fade modales" id="myModalEntrega" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">1.- Seleccione forma de entrega</h4>
            </div>
            <div class="modal-body">

              <form class="" action="" method="">
                <p><strong>¿Cómo prefiere recibir sus productos?</strong></p>
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
                  <p><strong>Seleccione dirección de despacho</strong></p>
                  <select class="form-control" name="">
                    <option value="direccionderegistro">Walker Martinez #555, San Miguel, Santiago, Región Metropolitana</option>
                    <option value="direccionderegistro">Calle #555, Mostazal, Región Libertador Bernardo O'higgins</option>
                  </select>
                  <a href="#" id="agregarDireccion">Agregar una nueva dirección</a>
                  <div class="" id="contenidoNewDir">
                    <br>
                    <div class="" id="ocultar">Ocultar</div>
                    <label for="">Dirección</label>
                    <input type="text" class="form-control" placeholder="Calle #555" name="" value="">
                    <br>
                    <label for="">Región</label>
                    <select class="form-control input-md" name="">
                      <option value="">Arica-Parinacota</option>
                      <option value="">Tarapacá</option>
                      <option value="">Antofagasta</option>
                      <option value="">Atacama</option>
                      <option value="">Coquimbo</option>
                      <option value="">Valparaíso</option>
                      <option value="">Metropolitana de Santiago</option>
                      <option value="">Libertador General Bernardo O'Higgins</option>
                      <option value="">Maule</option>
                      <option value="">Ñuble</option>
                      <option value="">Biobío</option>
                      <option value="">Araucanía</option>
                      <option value="">Los Ríos</option>
                      <option value="">Los Lagos</option>
                      <option value="">Aysén del General Carlos Ibáñez del Campo</option>
                      <option value="">Magallanes y de la Antártica Chilena</option>
                    </select>
                    <br>
                    <label for="">Ciudad</label>
                    <select class="form-control input-md" name="">
                      <option value="">Ciudad 01</option>
                      <option value="">Santiago</option>
                      <option value="">Ciudad 03</option>
                      <option value="">Ciudad 04</option>
                      <option value="">Ciudad 05</option>
                      <option value="">Ciudad 06</option>
                      <option value="">Ciudad 07</option>
                      <option value="">Ciudad 08</option>
                      <option value="">Ciudad 09</option>
                      <option value="">Ciudad 10</option>
                    </select>
                    <br>
                    <label for="">Comuna</label>
                    <select class="form-control input-md" name="">
                      <option value="">Comuna 01</option>
                      <option value="">Comuna 02</option>
                      <option value="">Comuna 03</option>
                      <option value="">Comuna 04</option>
                      <option value="">Comuna 05</option>
                      <option value="">Comuna 06</option>
                      <option value="">Comuna 07</option>
                      <option value="">Comuna 08</option>
                      <option value="">Comuna 09</option>
                      <option value="">Comuna 10</option>
                    </select>
                    <br>
                    <div class="text-center">
                      <button type="button" id="btnAgregarDir" class="btn btn-secundary" name="button">Agregar y seleccionar</button>
                    </div>
                  </div>
                  <br>
                  <div class="" id="medioEnvio">
                    <hr>
                    <label for="">Seleccione medio de envío</label>
                    <select class="form-control input-md" name="">
                      <option value="">Starken</option>
                      <option value="">Envio 02</option>
                      <option value="">Envio 03</option>
                      <option value="">Envio 04</option>
                    </select>
                    <br>
                    <div class="sucodom">
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="radioSucursal" onclick="checkRadio()" value="option1"> A sucursal
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="inlineRadioOptions" id="radioDomicilio" onclick="checkRadiodom()" value="option2"> A domicilio
                      </label>
                    </div>
                    <input type="text" class="form-control" id="nombreSucursal" placeholder="Nombre o ubicación de sucursal" name="" value="">
                  </div>
                  <hr>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="otraRecepcion" id="otraRecepcion" onclick="checkealo()">
                    <label class="form-check-label" for="otraRecepcion">
                      Otra persona va a recepcionar los productos
                    </label>
                  </div>
                  <div class="" id="contenidoOtraRec">
                    <br>
                    <label for="">Nombre y apellido receptor</label>
                    <input type="text" class="form-control" name="" value="" placeholder="Nombre Apellido">
                    <br>
                    <label for="">Rut receptor</label>
                    <input type="text" class="form-control" name="" value="" placeholder="20.555.555-k">
                    <br>
                    <label for="">Teléfono</label>
                    <input type="text" class="form-control" name="" value="" placeholder="+56 2 55 55 555">
                  </div>
                  <hr>
                  <p><strong>Aceptar términos y condiciones de despacho</strong></p>
                  <div class="infox">Valor despacho $5.000</div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="aceptaT" id="aceptaT" required>
                    <label class="form-check-label" for="aceptaT">
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
