<div class="modal fade" id="myModalEstadoPago" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="fa fa-globe"></i> Appnet ltda.
        </h4>
      </div>
      <div class="modal-body">
        <section class="invoice">
          
          <div  id="pdfdiv">
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>Appnet</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (804) 123-5432<br>
                  Email: info@almasaeedstudio.com
                </address>
              </div>
              <div class="col-sm-4 invoice-col">
                To
                <address>
                  <strong>John Doe</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (555) 539-1037<br>
                  Email: john.doe@example.com
                </address>
              </div>
              <div class="col-sm-4 invoice-col">
                <b>Venta <b id="id_invoice"></b></b><br>
                <br>
                <b>flowOrder:</b> <b id="id_flowOrder"></b><br>
                <b>Fecha de pagoe:</b> <b id="dv_fecha"></b><br>
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
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Direccion Despacho : 
                  varas mena 980, san miguel, santiago

                </p>
                
              </div>
              <div class="col-xs-6">
                <div class="table-responsive">
                  <table class="table">
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
            </div>
          </div>
          
          <div class="row no-print">
            <div class="col-xs-12">
              <a id="pdfview" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
              <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
              <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
            </div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>