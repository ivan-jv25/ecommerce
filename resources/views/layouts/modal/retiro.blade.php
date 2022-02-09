<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Seleccion de Tienda de Retiro</h4>
          </div>
          <div class="modal-body">
            <div class="row form-group">
              <label class="col-md-4 control-label" for="id_tienda_retiro">Tiendas de Retiro</label>
              <div class="col-md-8">
                <select id="id_tienda_retiro" class="form-control" onchange="work_flow_change_bodega(); ">
                  <option value="1">Option one</option>
                  <option value="2">Option two</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Stock</th>
                  </tr>
                </thead>
                <tbody id="lista_carro_bodega">
                  
                </tbody>
              </table>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
