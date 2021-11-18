<div class="modal fade" id="myModalEstadoPago" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="fa fa-globe"></i> <b id="id_nombre_empresa">Appnet ltda.</b> Compra realizada con éxito
        </h4>
      </div>
      <div class="modal-body">
        <section class="invoice">

          <h4>¡Gracias por su compra!<br><br>Nuestros ejecutivos se encargarán de tomar su pedido y ponerse en contacto con usted a la brevedad.</h4>
          <br>
          <div  id="pdfdiv">
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                De:
                <address id="add_datos_empresa">
                  <strong>Appnet</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  (804) 123-5432<br>
                  info@almasaeedstudio.com
                </address>
              </div>
              <div class="col-sm-4 invoice-col">
                Para:
                <address id="add_datos_cliente">
                  <strong>John Doe</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  (555) 539-1037<br>
                  john.doe@example.com
                </address>
              </div>
              <div class="col-sm-4 invoice-col">
                <b>Venta <b id="id_invoice"></b></b><br>
                <br>
                <b>Número de orden:</b> <b id="id_flowOrder"></b><br>
                <b>Fecha de pago:</b> <b id="dv_fecha"></b><br>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody id="lista_compra"></tbody>
                </table>
              </div>
            </div>
            <div class="row">

            <div class="col-xs-6">
                <p class="lead">Metodos de Pago:</p>
                <img src="https://www.flow.cl/images/header/logo-flow.svg" style="width: 50%;" alt="flow">


              </div>
              <div class="col-xs-6">
                <div class="table-responsive">
                  <table class="table resultado">
                    <tbody>
                      <tr>
                        <th style="width:50%">Neto:</th>
                        <td id="td_neto">$250.30</td>
                      </tr>
                      <tr>
                        <th>I.V.A (19%)</th>
                        <td id="td_iva">$10.34</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td id="td_total">$265.24</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-xs-12">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Direccion Despacho :
                  <b id="id_direccion_pago"></b>

                </p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Observacion :
                  <b id="id_observacion"></b>
                </p>

              </div>
            </div>
          </div>


        </section>
      </div>
    </div>
  </div>
</div>
