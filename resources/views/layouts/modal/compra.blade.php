<div class="modal fade" id="myModalCompras" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Compra</h4>
          </div>
          <div class="modal-body">

            <div class="table-responsive">
            <div class="col-md-4 ml-auto">
                        <div class="form-group">
                            <label for="sel1">Tipo de Ventas :</label>
                            <input id="desde" name="desde" type="date" class="form-control input-md" value="{{getPrimerUltimoFecha()['primero']}}" onchange="ventas_totales();">
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto">
                        <div class="form-group">
                            <label for="sel1">Tipo de Ventas :</label>
                            <input id="hasta" name="hasta" type="date" class="form-control input-md" value="{{getPrimerUltimoFecha()['ultimo']}}" onchange="ventas_totales();">
                        </div>
                    </div>
              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Cliente</th>
                    <th>Folio</th>
                    <th>Resepcion</th>
                    <th>Total</th>
                    <th>Documento</th>
                    <th>Forma Pago</th>
                    <th>Fecha</th>
                    <th>Ticket</th>
                    <th>Compra</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
