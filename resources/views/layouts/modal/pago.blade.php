<div class="modal fade modales" id="myModalPago" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Confirmación de compra</h4>
          </div>
          <div class="modal-body">
            <form id="form_test_flow">
              <p>Productos en carro</p>
              <table class="table table-hover table-striped">
                <thead class="thead-light">
                  <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Valor unitario</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Producto #1</td>
                    <td>2</td>
                    <td>$100.000</td>
                  </tr>
                  <tr>
                    <td>Producto #2</td>
                    <td>1</td>
                    <td>$35.000</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th></th>
                    <th>Sub total</th>
                    <th>$235.000</th>
                  </tr>
                </tfoot>
              </table>
              <p>Sucursal: <strong>Nombre Sucursal</strong></p>
              <p>Forma de entrega: <strong>Despacho</strong></p>
              <p>Dirección de envío: <strong>Walker Martinez #555, San Miguel, Santiago, RM</strong></p>
              <p>Valor despacho: <strong>$5.000</strong></p>
              <p>Tipo de documento: <strong>Boleta</strong></p>
              <p class="total">Total <strong>$240.000</strong></p>
              <p class="text-flow">Este Proceso de pago se realizara mediente <img class="sc-Rmtcm jRcmKS" src="https://www.flow.cl/images/header/logo-flow.svg" alt="logo"></p>
              <input type="text" name="token" id="token_flow" hidden>
              <button id="btn_pago" name="singlebutton" class="btn btn-block">Ir a Pagar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
